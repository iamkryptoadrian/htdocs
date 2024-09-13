<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Webhook;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Set your Stripe secret key
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        // Log the entire payload and signature header for debugging
        //Log::info('Stripe Webhook Received', [
        //    'payload' => $payload,
        //    'signature_header' => $sigHeader
        //]);

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            //Log::error('Invalid payload', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            //Log::error('Invalid signature', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Log the event type
        //Log::info('Stripe Event Type', ['type' => $event->type]);

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutSessionCompleted($session);
                break;
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                $this->handlePaymentIntentSucceeded($paymentIntent);
                break;
            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;
                $this->handlePaymentIntentFailed($paymentIntent);
                break;
            case 'payment_intent.requires_action':
                $paymentIntent = $event->data->object;
                $this->handlePaymentIntentRequiresAction($paymentIntent);
                break;
            default:
        }

        return response()->json(['status' => 'success'], 200);
    }

    protected function handleCheckoutSessionCompleted($session)
    {
        $bookingId = $session->metadata->booking_id;

        if (!$bookingId) {
            return;
        }

        $booking = Booking::where('booking_id', $bookingId)->first();

        if ($booking) {
            if ($booking->payment_status !== 'Paid') {
                $booking->update([
                    'payment_status' => 'Paid',
                    'booking_status' => 'confirmed'
                ]);
            } else {
            }
        } else {

        }
    }

    protected function handlePaymentIntentSucceeded($paymentIntent)
    {
        // Check if the payment intent contains the booking ID
        if (empty($paymentIntent->metadata->booking_id)) {
            return;
        }

        $bookingId = $paymentIntent->metadata->booking_id;

        $booking = Booking::where('booking_id', $bookingId)->first();

        if ($booking) {
            if ($booking->payment_status !== 'Paid') {
                $booking->update([
                    'payment_status' => 'Paid',
                    'booking_status' => 'confirmed'
                ]);
            } else {
            }
        } else {
        }
    }

    protected function handlePaymentIntentFailed($paymentIntent)
    {
        if (empty($paymentIntent->metadata->booking_id)) {
            return;
        }

        $bookingId = $paymentIntent->metadata->booking_id;

        $booking = Booking::where('booking_id', $bookingId)->first();

        if ($booking) {
            $booking->update([
                'payment_status' => 'Failed',
                'booking_status' => 'cancelled'
            ]);
        } else {
        }
    }

    protected function handlePaymentIntentRequiresAction($paymentIntent)
    {
        if (empty($paymentIntent->metadata->booking_id)) {
            return;
        }

        $bookingId = $paymentIntent->metadata->booking_id;

        $booking = Booking::where('booking_id', $bookingId)->first();

        if ($booking) {
            if ($booking->payment_status !== 'Failed') {
                $booking->update([
                    'payment_status' => 'Failed',
                    'booking_status' => 'Pending For Payment'
                ]);
            } else {
            }
        } else {

        }
    }
}
