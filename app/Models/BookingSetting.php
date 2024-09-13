<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSetting extends Model
{
    protected $table = 'booking_settings';

    protected $fillable = [
        'adult_age',
        'adult_discount',
        'children_age',
        'children_discount',
        'kids_age',
        'kids_discount',
        'Toddlers_age',
        'Toddlers_discount',
        'ports',
        'default_port'
    ];

    protected $casts = [
        'ports' => 'array',
        'default_port' => 'array',
    ];

    /**
     * Get the parsed ports attribute.
     *
     * @return array
     */
    public function getParsedPortsAttribute()
    {
        return $this->ports ? json_decode($this->ports, true) : [];
    }
}
