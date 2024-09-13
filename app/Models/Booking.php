<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FamilyMember;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'main_guest_id',
        'main_guest_first_name',
        'main_guest_last_name',
        'main_guest_email',
        'main_guest_phone_number',
        'booking_id',
        'user_id',
        'package_id',
        'package_name',
        'rooms_details',
        'no_of_rooms',
        'room_guest_details',
        'check_in_date',
        'check_out_date',
        'package_charges',
        'additional_services_total',
        'marine_fee',
        'total_surcharge_amount',
        'sub_total',
        'service_charge',
        'tax',
        'net_total',
        'included_services',
        'additional_services',
        'selected_family_members',
        'booking_status',
        'payment_status',
        'transaction_id',
        'stripe_session_id',
        'coupon_code',
        'discount_amt',
        'email_sent',
        'activity_assignment',
        'agent_code',
        'agent_commission',
        'arrival_method',
        'arrival_port_name',
        'drop_off_port_name',
        'arrival_time',
        'departure_time',
        'arrival_guest_list',
        'departure_guest_list',
        'total_guest_arrival',
        'total_guest_departure'
    ];

    protected $casts = [
        'rooms_details' => 'array',
        'room_guest_details' => 'array',
        'included_services' => 'array',
        'additional_services' => 'array',
        'selected_family_members' => 'array',
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'activity_assignment' => 'array',
        'arrival_guest_list' => 'array',
        'departure_guest_list' => 'array',
        'arrival_time' => 'datetime:H:i',
        'departure_time' => 'datetime:H:i',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    /**
     * Get the notes associated with the booking.
     */
    public function notes()
    {
        return $this->hasMany(BookingNote::class);
    }
}