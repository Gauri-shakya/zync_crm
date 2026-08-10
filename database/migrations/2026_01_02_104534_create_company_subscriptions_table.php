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
        Schema::create('company_subscriptions', function (Blueprint $table) {
            $table->id();
    $table->foreignId('company_id')->constrained()->cascadeOnDelete();

    $table->string('plan_name'); // Monthly / Yearly
    $table->decimal('amount', 8, 2);
    $table->string('razorpay_subscription_id')->nullable();
    $table->string('razorpay_payment_id')->nullable();
    $table->date('starts_at')->nullable();
    $table->date('ends_at')->nullable();

    $table->enum('status', ['active', 'expired', 'pending'])->default('pending');

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_subscriptions');
    }
};
