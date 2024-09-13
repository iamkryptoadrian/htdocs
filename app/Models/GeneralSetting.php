<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    protected $table = 'general_settings';

    protected $fillable = [
        'site_name',
        'support_email',
        'agent_commission',
        'user_rewards',
        'envi_coin_price',
        'total_nights',
        'agent_withdraw_method',
    ];

}
