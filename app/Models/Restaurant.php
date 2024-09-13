<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'icon_textList',
        'description_1',
        'description_2',
        'gallery',
        'menu_sub_title',
        'menu_title',
        'menu_categories',
        'items_list',
        'main_image',
    ];

    protected $casts = [
        'icon_textList' => 'array',
        'gallery' => 'array',
        'menu_categories' => 'array',
        'items_list' => 'array',
    ];
}
