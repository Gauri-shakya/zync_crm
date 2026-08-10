<?php

namespace App\Http\Controllers;

use App\Models\CompanySubscription;
use App\Models\Company;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserSubscriptionController extends Controller
{
    private $api;

    public function __construct()
    {
        $this->api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
    }

    /**
     * Show Checkout Page for logged-in users who haven't completed mandate
     */
    public function checkout()
    {
        $company = auth()->user()->company;
        $planId = $company->selected_plan ?? 'plan_basic';
        
        $planDetails = [
            'plan_basic' => ['name' => 'Basic Plan', 'amount' => 1999],
            'plan_pro' => ['name' => 'Pro Plan', 'amount' => 4999]
        ];

        $plan = $planDetails[$planId];

        return view('admin.subscriptions.checkout', compact('company', 'plan', 'planId'));
    }

    /**
     * Step 1: Initialize Registration and Subscription
     * Triggered from Step 3 "Authorize" button
     */
    public function initiateTrial(Request $request)
    {
        try {
            // 1. Validation with "ignore" logic if user is already logged in (re-attempt)
            $user = Auth::user();
            $company = $user ? $user->company : null;

            $rules = [
                'company_name'   => 'required|string|max:255|unique:companies,name' . ($company ? ',' . $company->id : ''),
                'address'        => 'required|string|max:1000',
                'company_email'  => 'required|email|unique:companies,email' . ($company ? ',' . $company->id : ''),
                'phone'          => 'required|string|max:20',
                'gstin'          => 'nullable|string|max:20|unique:companies,gstin' . ($company ? ',' . $company->id : ''),
                'logo'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'name'           => 'required|string|max:255',
                'admin_email'    => 'required|email|unique:users,email' . ($user ? ',' . $user->id : ''),
                'selected_plan'  => 'required|in:plan_basic,plan_pro',
            ];

            // Only require password if user doesn't exist yet
            if (!$user) {
                $rules['password'] = 'required|min:4|confirmed';
            }

            $request->validate($rules);

            return DB::transaction(function () use ($request, $user, $company) {
                // 2. Update or Create Company & Admin
                $logoPath = $company ? $company->logo : null;
                if ($request->hasFile('logo')) {
                    $logoPath = $request->file('logo')->store('logos', 'public');
                }

                if ($company) {
                    $company->update([
                        'name'           => $request->company_name,
                        'address'        => $request->address,
                        'email'          => $request->company_email,
                        'phone'          => $request->phone,
                        'gstin'          => $request->gstin,
                        'logo'           => $logoPath,
                        'selected_plan'  => $request->selected_plan,
                    ]);
                } else {
                    $company = Company::create([
                        'name'           => $request->company_name,
                        'slug'           => Str::slug($request->company_name) . '-' . uniqid(),
                        'address'        => $request->address,
                        'email'          => $request->company_email,
                        'phone'          => $request->phone,
                        'gstin'          => $request->gstin,
                        'logo'           => $logoPath,
                        'trial_ends_at'  => now()->addDays(15),
                        'selected_plan'  => $request->selected_plan,
                        'is_paid'        => false,
                        'status'         => 'pending',
                    ]);
                }

                $adminRole = Role::firstOrCreate(['name' => 'admin', 'company_id' => $company->id]);
                Role::firstOrCreate(['name' => 'Client', 'company_id' => $company->id]);

                if ($user) {
                    $user->update([
                        'name'  => $request->name,
                        'email' => $request->admin_email,
                    ]);
                    if ($request->filled('password')) {
                        $user->update(['password' => Hash::make($request->password)]);
                    }
                } else {
                    $user = User::create([
                        'company_id' => $company->id,
                        'name'       => $request->name,
                        'email'      => $request->admin_email,
                        'password'   => Hash::make($request->password),
                    ]);
                    $user->assignRole($adminRole);
                    Auth::login($user);
                }

                // 3. Create/Refresh Razorpay Subscription
                $planId = $request->selected_plan;
                $plans = [
                    'plan_basic' => ['name' => 'Basic Monthly', 'amount' => 1999, 'period' => 'monthly', 'interval' => 1],
                    'plan_pro' => ['name' => 'Pro Monthly', 'amount' => 4999, 'period' => 'monthly', 'interval' => 1],
                ];
                $planInfo = $plans[$planId];

                $razorpayPlanId = $this->getOrCreatePlan($planId, $planInfo);

                // Create a fresh subscription every time they click authorize to avoid stale IDs
                $subscription = $this->api->subscription->create([
                    'plan_id' => $razorpayPlanId,
                    'customer_notify' => 1,
                    'total_count' => 120,
                    'start_at' => now()->addDays(15)->timestamp,
                ]);

                // 4. Save Subscription record
                CompanySubscription::updateOrCreate(
                    ['company_id' => $company->id],
                    [
                        'plan_name' => $planInfo['name'],
                        'razorpay_plan_id' => $razorpayPlanId,
                        'amount' => $planInfo['amount'],
                        'razorpay_subscription_id' => $subscription->id,
                        'status' => 'pending',
                        'billing_cycle' => 'monthly',
                        'starts_at' => now(),
                        'ends_at' => now()->addDays(15),
                    ]
                );

                return response()->json([
                    'subscription_id' => $subscription->id,
                    'razorpay_key' => config('services.razorpay.key'),
                    'admin_name' => $user->name,
                    'admin_email' => $user->email,
                    'company_phone' => $company->phone,
                ]);
            });

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Registration & Subscription Initialization Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to initialize. ' . $e->getMessage()], 500);
        }
    }

    /**
     * Create Razorpay Subscription for users already in checkout page
     */
    public function createSubscription(Request $request)
    {        $user = auth()->user();
        $company = $user->company;
        $planId = $request->plan_id ?? $company->selected_plan ?? 'plan_basic';

        $plans = [
            'plan_basic' => ['name' => 'Basic Monthly', 'amount' => 1999, 'period' => 'monthly', 'interval' => 1],
            'plan_pro' => ['name' => 'Pro Monthly', 'amount' => 4999, 'period' => 'monthly', 'interval' => 1],
        ];
        $planInfo = $plans[$planId];

        try {
            $razorpayPlanId = $this->getOrCreatePlan($planId, $planInfo);

            $subscription = $this->api->subscription->create([
                'plan_id' => $razorpayPlanId,
                'customer_notify' => 1,
                'total_count' => 120,
                'start_at' => now()->addDays(15)->timestamp,
            ]);

            CompanySubscription::updateOrCreate(
                ['company_id' => $company->id],
                [
                    'plan_name' => $planInfo['name'],
                    'razorpay_plan_id' => $razorpayPlanId,
                    'amount' => $planInfo['amount'],
                    'razorpay_subscription_id' => $subscription->id,
                    'status' => 'pending',
                    'billing_cycle' => 'monthly',
                    'starts_at' => now(),
                    'ends_at' => now()->addDays(15),
                ]
            );

            return response()->json([
                'subscription_id' => $subscription->id,
                'razorpay_key' => config('services.razorpay.key'),
                'company_name' => $company->name,
                'company_email' => $company->email,
                'company_phone' => $company->phone,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getOrCreatePlan($planKey, $planInfo)
    {
        // In production, you should store these Razorpay Plan IDs in a config or DB
        // For this implementation, we'll create one if not found (simulated)
        // Note: Real Razorpay API doesn't have a "get plan by name", so we create once.
        
        try {
            $planData = [
                'period' => $planInfo['period'],
                'interval' => $planInfo['interval'],
                'item' => [
                    'name' => $planInfo['name'],
                    'amount' => $planInfo['amount'] * 100, // in paise
                    'currency' => 'INR',
                ],
            ];

            $plan = $this->api->plan->create($planData);
            return $plan->id;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Step 2: Handle Payment/Mandate Success
     */
    public function handlePayment(Request $request)
    {
        $attributes = [
            'razorpay_subscription_id' => $request->razorpay_subscription_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        ];

        try {
            Log::info('Verifying Razorpay Mandate Signature', $attributes);
            $this->api->utility->verifyPaymentSignature($attributes);
            
            $subscription = CompanySubscription::where('razorpay_subscription_id', $request->razorpay_subscription_id)->first();
            
            if ($subscription) {
                $subscription->update([
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'status' => 'trial', // Mandate authorized, now on trial
                    'starts_at' => now(),
                    'ends_at' => $subscription->company->trial_ends_at,
                    'next_payment_at' => $subscription->company->trial_ends_at,
                ]);

                $subscription->company->update([
                    'is_paid' => false, // Trial is active, but not "paid" yet
                    'status' => 'trial',
                ]);

                // Record the "Verification" charge (simulated)
                \App\Models\SuperAdmin\Payment::create([
                    'payment_id' => 'VERIFY-' . strtoupper(uniqid()),
                    'customer_id' => $subscription->company_id,
                    'amount' => 0, // Verification is ₹0 effectively after refund
                    'tax_amount' => 0,
                    'total_amount' => 0,
                    'payment_method' => 'upi', // Must match ENUM in migration
                    'payment_type' => 'subscription', // Must match ENUM in migration
                    'transaction_id' => $request->razorpay_payment_id,
                    'status' => 'completed',
                    'payment_date' => now(),
                    'currency' => 'INR',
                    'payment_gateway' => 'razorpay',
                    'metadata' => array_merge($attributes, ['type' => 'mandate_verification'])
                ]);
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Razorpay Mandate Verification Failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Signature failed: ' . $e->getMessage()], 403);
        }
    }

    /**
     * Webhook Handler for Auto-Pay events
     */
    public function handleWebhook(Request $request)
    {
        $webhookSecret = config('services.razorpay.webhook_secret'); // Set this in .env
        $data = $request->all();

        // Verify webhook signature if secret is set
        if ($webhookSecret) {
            try {
                $this->api->utility->verifyWebhookSignature(
                    $request->getContent(),
                    $request->header('X-Razorpay-Signature'),
                    $webhookSecret
                );
            } catch (\Exception $e) {
                Log::error('Razorpay Webhook Signature Invalid');
                return response('Invalid Signature', 400);
            }
        }

        $event = $data['event'];
        $payload = $data['payload'];

        switch ($event) {
            case 'subscription.activated':
            case 'subscription.charged':
                $subData = $payload['subscription']['entity'];
                $this->updateSubscriptionFromWebhook($subData, 'active');
                break;

            case 'subscription.halted':
            case 'subscription.cancelled':
                $subData = $payload['subscription']['entity'];
                $this->updateSubscriptionFromWebhook($subData, 'expired');
                break;

            case 'invoice.paid':
                $invoiceData = $payload['invoice']['entity'];
                $this->handleInvoicePaid($invoiceData);
                break;
        }

        return response('Webhook Handled', 200);
    }

    private function updateSubscriptionFromWebhook($subData, $status)
    {
        $subId = $subData['id'];
        $subscription = CompanySubscription::where('razorpay_subscription_id', $subId)->first();
        
        if ($subscription) {
            $subscription->update([
                'status' => $status,
                'next_payment_at' => isset($subData['charge_at']) ? Carbon::createFromTimestamp($subData['charge_at']) : $subscription->next_payment_at,
                'ends_at' => isset($subData['end_at']) ? Carbon::createFromTimestamp($subData['end_at']) : $subscription->ends_at,
            ]);
        }
    }

    private function handleInvoicePaid($invoiceData)
    {
        $subId = $invoiceData['subscription_id'];
        $subscription = CompanySubscription::where('razorpay_subscription_id', $subId)->first();
        
        if ($subscription) {
            $subscription->update([
                'status' => 'active',
                'starts_at' => now(),
                'ends_at' => now()->addMonth(),
                'next_payment_at' => now()->addMonth(),
            ]);
        }
    }
}
