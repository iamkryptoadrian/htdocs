<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstagramSection extends Model
{
    use HasFactory;

    protected $table = 'instagram_section';

    protected $fillable = [
        'image_path',
    ];
}
