<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'stripe_payment_id',
        'booking_id',
        'user_id',
        'amount',
        'currency',
        'status',
        'metadata',
        'payment_method_id',
        'refund_id',
        'refund_amount',
        'paid_at',
        'refunded_at'
    ];

    protected $casts = [
        'metadata' => 'array',
        'amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

}
