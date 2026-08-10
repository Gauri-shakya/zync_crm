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
            $table->string('razorpay_subscription_id')->nullable()->after('amount');
            $table->string('razorpay_payment_id')->nullable()->after('razorpay_subscription_id');
            $table->string('status')->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_subscriptions', function (Blueprint $table) {
            $table->dropColumn(['razorpay_subscription_id', 'razorpay_payment_id']);
        });
    }
};
