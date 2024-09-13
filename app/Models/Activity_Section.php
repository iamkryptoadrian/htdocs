<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity_Section extends Model
{
    use HasFactory;

    protected $table ="activity_section";

    protected $fillable = [
        'sub_title',
        'title',
        'description',
        'image',
    ];
}
