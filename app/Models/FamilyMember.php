<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;

    protected $table = 'family_members';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'date_of_birth',
        'id_number',
        'street_address',
        'city',
        'state',
        'zip_code',
        'country',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the user that the family member belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

