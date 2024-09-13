<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surcharge extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'amount',
        'start_date',
        'end_date',
        'days_of_week',
        'surcharge_type',
        'is_active',
    ];

    protected $casts = [
        'days_of_week' => 'array', // Add this line to cast the days_of_week to an array
    ];
}
