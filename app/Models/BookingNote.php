<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingNote extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'booking_notes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'booking_id',
        'author_id',
        'note_type',
        'content',
        'parent_id',
        'author_type'
    ];

    /**
     * Get the booking that owns the note.
     */
    public function booking()
    {
        return $this->belongsTo('App\Models\Booking');
    }

    /**
     * Get the user who authored the note.
     */
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id');
    }

    /**
     * Get the replies to this note.
     */
    public function replies()
    {
        return $this->hasMany('App\Models\BookingNote', 'parent_id');
    }
}
