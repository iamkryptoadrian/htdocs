<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_type',
        'beds',
        'max_adults',
        'max_children',
        'room_quantity',
        'empty_bed_charge',
        'room_img',
        'room_description',
        'max_guest',   
    ];

    protected $casts = [
        'room_gallery' => 'array',
    ];

    // In Room model (Room.php)
    public function scopeWithCapacity($query, $guests)
    {
        return $query->where('max_guest', '>=', $guests);
    }
    
}
