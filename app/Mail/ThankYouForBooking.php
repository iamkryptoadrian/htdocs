<?php

namespace App\Mail;

use App\Models\Booking;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ThankYouForBooking extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $roomsDetails;
    public $totalGuests;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Booking $booking, $roomsDetails, $totalGuests)
    {
        $this->booking = $booking;
        $this->roomsDetails = $roomsDetails;
        $this->totalGuests = $totalGuests;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        try {
            //Log::info('Building ThankYouForBooking email for booking ID: ' . $this->booking->id);
            return $this->view('emails.booking_review')
                        ->subject('Thank You for Your Stay at The Rock Resorts')
                        ->with([
                            'booking' => $this->booking,
                            'roomsDetails' => $this->roomsDetails,
                            'totalGuests' => $this->totalGuests,
                        ]);
        } catch (Exception $e) {
            // Log the error
            Log::error('Error building ThankYouForBooking email for booking ID: ' . $this->booking->id . '. Error: ' . $e->getMessage());
            // Optionally, you can throw the exception again to handle it further up the stack
            throw $e;
        }
    }
}
