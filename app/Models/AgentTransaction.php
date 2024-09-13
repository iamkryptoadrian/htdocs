<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentTransaction extends Model
{
    use HasFactory;
    protected $table = 'agent_transactions';

    protected $fillable = [
        'booking_id',
        'agent_code',
        'customer_name',
        'commission_amount',
        'commission_status',
    ];

    // Define relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
