<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestmentProfitLog extends Model
{
    protected $fillable = [
        'investment_id',
        'user_id',
        'amount_cents',
        'for_date',
    ];

    protected $casts = [
        'for_date'      => 'date',
        'amount_cents'  => 'integer',
    ];

    public function investment()
    {
        return $this->belongsTo(Investment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
