<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_name',
        'duration',
        'short_description',
        'long_description',
        'package_price',
        'main_image',
        'other_images',
        'beds',
        'max_adults',
        'max_children',
        'rooms',
        'services',
        'service_charge',
        'tax',
        'marine_fees',
        'surcharge',
        'adult_price',
        'children_price',
        'adult_price_start',
        'children_price_start',
        'kids_price',
        'kids_price_start_at',
        'addon_services_available',
    ];

    protected $casts = [
        'duration' => 'array',
        'other_images' => 'array',
        'rooms' => 'array',
        'services' => 'array',
        'addon_services_available' => 'array',
    ];
}
