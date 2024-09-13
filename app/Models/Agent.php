<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\Agent\AgentResetPasswordNotification;


class Agent extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_name',
        'phone_number',
        'street',
        'city',
        'postcode',
        'country',
        'account_status',
        'agent_code',
        'agent_wallet_balance',
        'pending_cashout',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AgentResetPasswordNotification($token));
    }
}
