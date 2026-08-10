<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('company_subscriptions', function (Blueprint $table) {
            if (!Schema::hasColumn('company_subscriptions', 'razorpay_plan_id')) {
                $table->string('razorpay_plan_id')->nullable()->after('plan_name');
            }
            if (!Schema::hasColumn('company_subscriptions', 'next_payment_at')) {
                $table->timestamp('next_payment_at')->nullable()->after('ends_at');
            }
            if (!Schema::hasColumn('company_subscriptions', 'billing_cycle')) {
                $table->string('billing_cycle')->default('monthly')->after('next_payment_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_subscriptions', function (Blueprint $table) {
            $table->dropColumn(['razorpay_plan_id', 'next_payment_at', 'billing_cycle']);
        });
    }
};
