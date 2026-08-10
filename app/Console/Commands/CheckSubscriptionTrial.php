<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Company;
use App\Models\CompanySubscription;
use App\Models\SuperAdmin\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckSubscriptionTrial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:check-trial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for expired trials and performs auto-deduction for testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired trials at: ' . Carbon::now()->toDateTimeString());

        // 1. Find companies whose trial has expired but are still marked as "trial" or not paid
        $expiredCompanies = Company::where('is_paid', false)
            ->whereNotNull('trial_ends_at')
            ->where('trial_ends_at', '<=', Carbon::now())
            ->get();

        if ($expiredCompanies->isEmpty()) {
            $this->info('No expired trials found.');
            return;
        }

        foreach ($expiredCompanies as $company) {
            $this->info("Processing company: {$company->name} (Trial ended: {$company->trial_ends_at})");

            // 2. Find the associated subscription
            $subscription = CompanySubscription::where('company_id', $company->id)->first();

            if ($subscription) {
                // 3. Perform "Auto-Deduction" (Simulated for testing)
                // In a real scenario, we would call Razorpay API here or it would happen via Webhook
                // For this test, we simulate the deduction of the subscription amount (Rs 5)
                
                $amountToDeduct = $subscription->amount;
                
                $this->info("Auto-deducting ₹{$amountToDeduct} for {$company->name}...");

                // 4. Update Company & Subscription status
                $company->update([
                    'is_paid' => true,
                    'status' => 'active'
                ]);

                $subscription->update([
                    'status' => 'active',
                    'starts_at' => Carbon::now(),
                    'ends_at' => Carbon::now()->addMonth(),
                    'next_payment_at' => Carbon::now()->addMonth(),
                ]);

                // 5. Record the Payment in the system
                Payment::create([
                    'payment_id' => 'AUTO-' . strtoupper(uniqid()),
                    'customer_id' => $company->id,
                    'amount' => $amountToDeduct,
                    'tax_amount' => 0,
                    'total_amount' => $amountToDeduct,
                    'payment_method' => 'online', // Must match ENUM
                    'payment_type' => 'subscription', // Must match ENUM
                    'transaction_id' => 'TXN-' . strtoupper(uniqid()),
                    'status' => 'completed',
                    'payment_date' => Carbon::now(),
                    'currency' => 'INR',
                    'payment_gateway' => 'razorpay-simulation',
                    'metadata' => [
                        'type' => 'auto_deduct_after_trial',
                        'trial_ended_at' => $company->trial_ends_at,
                    ]
                ]);

                $this->info("Successfully auto-deducted and activated plan for {$company->name}.");
            } else {
                $this->warn("No subscription record found for {$company->name}. Cannot auto-deduct.");
            }
        }

        $this->info('Finished checking trials.');
    }
}
