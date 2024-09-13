<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Booking;
use App\Mail\ThankYouForBooking;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Agent;
use App\Models\AgentTransaction;

class BookingController extends Controller
{
    public function updateBookingStatus()
    {
        // Get checkout_date's date and set the time to 11:00 AM
        $checkout_date = Carbon::today()->setTime(11, 0);
        $checkin_date = Carbon::today();

        // Find all bookings where check_out_date is checkout_date or earlier, status is 'active', and status is not 'completed'
        $completedBookings = Booking::where('check_out_date', '<=', $checkout_date)
                                     ->where('booking_status', 'active')
                                     ->where('booking_status', '!=', 'completed')
                                     ->get();

        foreach ($completedBookings as $booking) {
            try {
                // Update booking status to 'completed'
                $booking->update(['booking_status' => 'completed']);

                $roomsDetails = json_decode($booking->rooms_details, true) ?? [];

                // Decode the room_guest_details JSON string into an array and calculate the totals
                $roomGuestDetails = json_decode($booking->room_guest_details, true) ?? [];
                $totalAdults = 0;
                $totalChildren = 0;
                $totalToddlers = 0;
                $totalInfants = 0;

                foreach ($roomGuestDetails as $details) {
                    foreach ($details as $key => $value) {
                        if (strpos($key, 'adults') !== false) {
                            $totalAdults += (int)$value;
                        } elseif (strpos($key, 'children') !== false) {
                            $totalChildren += (int)$value;
                        } elseif (strpos($key, 'toddlers') !== false) {
                            $totalToddlers += (int)$value;
                        } elseif (strpos($key, 'infants') !== false) {
                            $totalInfants += (int)$value;
                        }
                    }
                }

                $totalGuests = $totalAdults + $totalChildren + $totalToddlers + $totalInfants;

                // Fetch the user associated with the booking
                $user = User::find($booking->user_id);

                if ($user) {
                    //Log::info('Sending email to user: ' . $user->email);
                    // Send thank you email
                    Mail::to($user->email)->send(new ThankYouForBooking($booking, $roomsDetails, $totalGuests));
                } else {
                    //Log::error('User not found for booking ID: ' . $booking->id);
                }
            } catch (Exception $e) {
                // Log the error or handle it as needed
                //Log::error('Error updating booking status or sending email for booking ID: ' . $booking->id . '. Error: ' . $e->getMessage());
            }
        }

        // Find all bookings where check_in_date is checkin_date and status is not 'active'
        $activeBookings = Booking::where('check_in_date', '=', $checkin_date)
                                  ->where('booking_status', 'confirmed')
                                  ->where('booking_status', '!=', 'active')
                                  ->get();

        foreach ($activeBookings as $booking) {
            try {
                // Update booking status to 'active'
                $booking->update(['booking_status' => 'active']);
            } catch (Exception $e) {
                // Log the error or handle it as needed
                //Log::error('Error updating booking status to active for booking ID: ' . $booking->id . '. Error: ' . $e->getMessage());
            }
        }

        return response()->json(['message' => 'Booking statuses updated and emails sent successfully.']);
    }


    public function DistributeAgentCommission()
    {
        //Log::info('Starting DistributeAgentCommission function.');

        try {
            // Fetch all pending transactions
            $pendingTransactions = AgentTransaction::where('commission_status', 'pending')->get();

            //Log::info('Fetched pending transactions.', ['count' => $pendingTransactions->count()]);

            // Iterate through each pending transaction
            foreach ($pendingTransactions as $transaction) {
                // Fetch the corresponding booking
                $booking = Booking::find($transaction->booking_id);

                //Log::info('Processing transaction.', [
                //    'transaction_id' => $transaction->id,
                //    'booking_id' => $transaction->booking_id,
                //    'agent_code' => $transaction->agent_code,
                //    'commission_amount' => $transaction->commission_amount,
                //]);

                if ($booking) {
                    // Check if booking status is 'completed'
                    if ($booking->booking_status == 'completed') {
                        //Log::info('Booking status is completed.', [
                        //    'booking_id' => $booking->id,
                        //    'status' => $booking->booking_status,
                        //]);

                        // Find the agent
                        $agent = Agent::where('agent_code', $transaction->agent_code)->first();

                        if ($agent) {
                            //Log::info('Agent found.', [
                            //    'agent_id' => $agent->id,
                            //    'agent_code' => $agent->agent_code,
                            //    'agent_wallet_balance' => $agent->agent_wallet_balance,
                            //]);

                            // Start a transaction
                            DB::beginTransaction();

                            try {
                                // Add commission amount to agent's wallet balance
                                $agent->agent_wallet_balance += $transaction->commission_amount;
                                $agent->save();

                                //Log::info('Commission added to agent\'s wallet.', [
                                //    'agent_id' => $agent->id,
                                //    'new_wallet_balance' => $agent->agent_wallet_balance,
                                //]);

                                // Update the transaction status to 'paid'
                                $transaction->commission_status = 'paid';
                                $transaction->save();

                                //Log::info('Transaction status updated to paid.', [
                                //    'transaction_id' => $transaction->id,
                                //    'new_status' => $transaction->commission_status,
                                //]);

                                // Commit the transaction
                                DB::commit();
                            } catch (Exception $e) {
                                // Rollback the transaction in case of error
                                DB::rollBack();

                                // Log the error
                                //Log::error('Error distributing commission: ' . $e->getMessage(), [
                                //    'agent_code' => $transaction->agent_code,
                                //    'booking_id' => $transaction->booking_id,
                                //    'transaction_id' => $transaction->id
                                //]);

                                // Rollback the changes made to agent's wallet balance
                                $this->rollbackCommission($agent, $transaction->commission_amount);

                                // Return error response
                                return response()->json(['message' => 'An error occurred while distributing commissions.'], 500);
                            }
                        } else {
                            //Log::warning('Agent not found.', [
                            //    'agent_code' => $transaction->agent_code,
                            //]);
                        }
                    } elseif ($booking->booking_status == 'cancelled' && $booking->check_in_date < now()) {
                        //Log::info('Booking status is failed and check-in date has passed.', [
                        //    'booking_id' => $booking->id,
                        //    'status' => $booking->booking_status,
                        //    'check_in_date' => $booking->check_in_date,
                        //]);

                        // Start a transaction
                        DB::beginTransaction();

                        try {
                            // Update the transaction status to 'cancelled'
                            $transaction->commission_status = 'cancelled';
                            $transaction->save();

                            //Log::info('Transaction status updated to cancelled.', [
                            //    'transaction_id' => $transaction->id,
                            //    'new_status' => $transaction->commission_status,
                            //]);

                            // Commit the transaction
                            DB::commit();
                        } catch (Exception $e) {
                            // Rollback the transaction in case of error
                            DB::rollBack();

                            // Log the error
                            //Log::error('Error updating commission status to cancelled: ' . $e->getMessage(), [
                            //    'agent_code' => $transaction->agent_code,
                            //    'booking_id' => $transaction->booking_id,
                            //    'transaction_id' => $transaction->id
                            //]);

                            // Return error response
                            return response()->json(['message' => 'An error occurred while updating commission status.'], 500);
                        }
                    } else {
                        //Log::info('Booking status is not completed or failed with check-in date not passed.', [
                        //    'booking_id' => $booking->id,
                        //    'status' => $booking->booking_status,
                        //    'check_in_date' => $booking->check_in_date,
                        //]);
                    }
                } else {
                    //Log::info('Booking not found.', [
                    //    'booking_id' => $transaction->booking_id,
                    //]);
                }
            }

            //Log::info('DistributeAgentCommission function completed successfully.');
            return response()->json(['message' => 'Agent commissions distributed successfully.'], 200);
        } catch (Exception $e) {
            // Log the error
            //Log::error('Error distributing agent commissions: ' . $e->getMessage());

            return response()->json(['message' => 'An error occurred while distributing commissions.'], 500);
        }
    }


    private function rollbackCommission($agent, $commissionAmount)
    {
        try {
            // Start a transaction
            DB::beginTransaction();

            // Subtract the commission amount from agent's wallet balance
            $agent->agent_wallet_balance -= $commissionAmount;
            $agent->save();

            // Commit the transaction
            DB::commit();

            //Log::info('Rolled back commission successfully.', [
            //    'agent_id' => $agent->id,
            //    'commission_amount' => $commissionAmount,
            //    'new_wallet_balance' => $agent->agent_wallet_balance,
            //]);
        } catch (Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Log the error
            //Log::error('Error rolling back commission: ' . $e->getMessage(), [
            //    'agent_id' => $agent->id,
            //    'commission_amount' => $commissionAmount
            //]);
        }
    }

}
