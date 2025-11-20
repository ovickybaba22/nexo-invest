<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount_cents',
        'method',
        'reference',
        'status',
        'processed_at',
    ];

    protected $casts = [
        'amount_cents' => 'integer',
        'processed_at' => 'datetime',
    ];

    // A withdrawal belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper: amount in dollars for display
    public function getAmountDollarsAttribute(): float
    {
        return $this->amount_cents / 100;
    }

    // Scope: only approved or paid withdrawals (used for balance)
    public function scopeApprovedOrPaid($query)
    {
        return $query->whereIn('status', ['approved', 'paid']);
    }

    // Scope: pending withdrawals (for the "Pending withdrawals" card)
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // When status changes to approved or paid, set processed_at if empty and adjust wallet balance
    protected static function booted(): void
    {
        static::updating(function ($withdrawal) {
            // If status changes to approved/paid, set processed_at if empty
            if (
                $withdrawal->isDirty('status') &&
                in_array($withdrawal->status, ['approved', 'paid']) &&
                is_null($withdrawal->processed_at)
            ) {
                $withdrawal->processed_at = now();
            }

            // Handle balance deduction when a withdrawal is approved/paid
            if ($withdrawal->isDirty('status')) {
                $originalStatus = $withdrawal->getOriginal('status');
                $newStatus      = $withdrawal->status;

                // Only act when transitioning from a non-final state to approved/paid
                if (! in_array($originalStatus, ['approved', 'paid'], true) &&
                    in_array($newStatus, ['approved', 'paid'], true)
                ) {
                    $user = $withdrawal->user;

                    if ($user) {
                        $currentBalance = (int) ($user->wallet_balance ?? 0);
                        $deduction      = (int) $withdrawal->amount_cents;

                        // Prevent negative balance; cap at current balance
                        if ($deduction > $currentBalance) {
                            $deduction = $currentBalance;
                        }

                        $user->wallet_balance = $currentBalance - $deduction;
                        $user->save();
                    }
                }
            }
        });
    }
}