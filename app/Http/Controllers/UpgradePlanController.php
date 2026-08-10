<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Company;
use App\Models\CompanySubscription;
use App\Models\SuperAdmin\Payment;

class UpgradePlanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $company = $user->company;

        // Auto-Deduct Check (Logic for 15-day trial)
        if ($company && !$company->is_paid && $company->trial_ends_at && Carbon::now()->gt($company->trial_ends_at)) {
            $subscription = CompanySubscription::where('company_id', $company->id)->first();
            if ($subscription && $subscription->status !== 'active') {
                // Auto-deduct simulated
                $company->update(['is_paid' => true, 'status' => 'active']);
                $subscription->update([
                    'status' => 'active',
                    'starts_at' => Carbon::now(),
                    'ends_at' => Carbon::now()->addMonth(),
                    'next_payment_at' => Carbon::now()->addMonth(),
                ]);
                
                Payment::create([
                    'payment_id' => 'AUTO-' . strtoupper(uniqid()),
                    'customer_id' => $company->id,
                    'amount' => $subscription->amount,
                    'tax_amount' => 0,
                    'total_amount' => $subscription->amount,
                    'payment_method' => 'online', // Must match ENUM
                    'payment_type' => 'subscription', // Must match ENUM
                    'transaction_id' => 'TXN-' . strtoupper(uniqid()),
                    'status' => 'completed',
                    'payment_date' => Carbon::now(),
                    'currency' => 'INR',
                    'payment_gateway' => 'razorpay-simulation',
                    'metadata' => ['type' => 'auto_deduct_after_trial']
                ]);
                
                // Refresh company object
                $company = $company->fresh();
            }
        }

        $trialRemaining = '';
        $isTrial = false;

        if ($company) {
            if (!$company->is_paid && $company->trial_ends_at && Carbon::now()->lt($company->trial_ends_at)) {
                $diff = Carbon::now()->diff($company->trial_ends_at);
                if ($diff->days > 0) {
                    $trialRemaining = $diff->days . ' Days ' . $diff->h . ' Hours';
                } elseif ($diff->h > 0) {
                    $trialRemaining = $diff->h . ' Hours ' . $diff->i . ' Mins';
                } else {
                    $trialRemaining = $diff->i . ' Mins ' . $diff->s . ' Secs';
                }
                $isTrial = true;
            }
        }

        return view('admin.upgrade.index', compact('company', 'trialRemaining', 'isTrial'));
    }
}
