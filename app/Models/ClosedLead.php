<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClosedLead extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'lead_id',
        'user_id',
        'service_name',
        'closed_date',
        'payment_type',
        'total_amount',
        'paid_amount',
        'due_amount',
        'next_payment_date',
        'is_due_dismissed',
        'updated_by',
    ];

    protected $casts = [
        'closed_date' => 'date',
        'next_payment_date' => 'date',
    ];

    protected static function booted()
    {
        static::creating(function ($closedLead) {
            if (auth()->check()) {
                $closedLead->company_id = auth()->user()->company_id;
            }
        });
    }

    public function lead()
    {
        return $this->belongsTo(Mylead::class, 'lead_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
