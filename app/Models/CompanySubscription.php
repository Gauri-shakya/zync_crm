<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySubscription extends Model
{
    protected $fillable = [
        'company_id',
        'plan_name',
        'razorpay_plan_id',
        'amount',
        'razorpay_subscription_id',
        'razorpay_payment_id',
        'starts_at',
        'ends_at',
        'next_payment_at',
        'billing_cycle',
        'status'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'next_payment_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
