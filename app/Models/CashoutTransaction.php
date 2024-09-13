<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashoutTransaction extends Model
{
    use HasFactory;

    protected $table = 'cashout_transactions';

    protected $fillable = [
        'trx_id',
        'cashout_method',
        'total_amount',
        'status',
        'rejection_reason',
        'agent_code',
        'details'
    ];

    protected $casts = [
        'details' => 'array',
    ];
}
