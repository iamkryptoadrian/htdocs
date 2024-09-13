<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class BookingConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $booking;
    public $nights;
    public $mainImage;
    public $memberNames;
    public $roomsDetails;
    public $totalAdults;
    public $totalChildren;
    public $totalToddlers;
    public $totalKids;
    public $totalGuests;

    public function __construct($booking, $nights, $mainImage, $memberNames, $roomsDetails, $totalAdults, $totalChildren, $totalToddlers, $totalKids, $totalGuests)
    {
        $this->booking = $booking;
        $this->nights = $nights;
        $this->mainImage = $mainImage;
        $this->memberNames = $memberNames;
        $this->roomsDetails = $roomsDetails;
        $this->totalAdults = $totalAdults;
        $this->totalChildren = $totalChildren;
        $this->totalToddlers = $totalToddlers;
        $this->totalKids = $totalKids;
        $this->totalGuests = $totalGuests;
    }

    public function build()
    {
        try {
            $pdf = Pdf::loadView('emails.pdf_booking_confirmation', [
                'booking' => $this->booking,
                'nights' => $this->nights,
                'mainImage' => $this->mainImage,
                'memberNames' => $this->memberNames,
                'roomsDetails' => $this->roomsDetails,
                'totalAdults' => $this->totalAdults,
                'totalChildren' => $this->totalChildren,
                'totalToddlers' => $this->totalToddlers,
                'totalKids' => $this->totalKids,
                'totalGuests' => $this->totalGuests,
            ]);
            Log::info('Booking confirmation email is being sent for booking ID: ' . $this->booking->id);

            return $this->view('emails.booking_confirmation')
                ->attachData($pdf->output(), 'booking_confirmation.pdf', [
                    'mime' => 'application/pdf',
                ])
                ->with([
                    'booking' => $this->booking,
                    'nights' => $this->nights,
                    'mainImage' => $this->mainImage,
                    'memberNames' => $this->memberNames,
                    'roomsDetails' => $this->roomsDetails,
                    'totalAdults' => $this->totalAdults,
                    'totalChildren' => $this->totalChildren,
                    'totalToddlers' => $this->totalToddlers,
                    'totalKids' => $this->totalKids,
                    'totalGuests' => $this->totalGuests,
                ]);
        } catch (\Exception $e) {
            Log::error('Error generating booking confirmation email: ' . $e->getMessage(), [
                'bookingId' => $this->booking->id,
                'userId' => $this->booking->user_id,
            ]);

            // You can also return a fallback view or perform other actions if needed
            return $this->view('emails.booking_confirmation')
                ->with([
                    'booking' => $this->booking,
                    'nights' => $this->nights,
                    'mainImage' => $this->mainImage,
                    'memberNames' => $this->memberNames,
                    'roomsDetails' => $this->roomsDetails,
                    'totalAdults' => $this->totalAdults,
                    'totalChildren' => $this->totalChildren,
                    'totalToddlers' => $this->totalToddlers,
                    'totalKids' => $this->totalKids,
                    'totalGuests' => $this->totalGuests,
                    'error' => 'An error occurred while generating the PDF. Please contact support.'
                ]);
        }
    }
}
