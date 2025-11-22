<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Withdrawal;

class User extends Authenticatable
{
    // Always expose wallet balance in cents, even if there is no DB column.
    public function getWalletBalanceCentsAttribute(): int
    {
        return (int) round(($this->wallet_balance ?? 0) * 100);
    }

    // The app uses available_balance_cents for "Available to invest" / modal.
    // Map it to the same wallet balance so all places stay in sync.
    public function getAvailableBalanceCentsAttribute(): int
    {
        return $this->wallet_balance_cents;
    }
// Some places may use withdrawable_wallet_cents — keep it in sync too.
public function getWithdrawableWalletCentsAttribute(): int
{
    return $this->wallet_balance_cents;
}
    public function deposits()
{
    return $this->hasMany(\App\Models\Deposit::class);
}
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Alias for wallet_balance (stored in cents) so views/controllers
     * can reference available_balance_cents consistently.
     */
    public function getAvailableBalanceCentsAttribute(): int
    {
        return (int) ($this->wallet_balance ?? 0);
    }
}
