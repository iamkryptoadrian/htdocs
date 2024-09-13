<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Admin\RestaurantPageController;
use App\Http\Controllers\User\FamilyMemberListController;
use App\Http\Controllers\User\UserProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserDepositController;
use App\Http\Controllers\TokenTransactionController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\SearchResultController;
use App\Http\Controllers\BookingStep1Controller;
use App\Http\Controllers\BookingStep2Controller;
use App\Http\Controllers\BookingStep3Controller;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\User\UserBookingController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\TermsConditionController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__.'/auth.php';


Route::get('/', [HomePageController::class, 'index'])->name('home_index');

Route::get('/create-storage', [HomePageController::class, 'createStorageLink'])->name('create.storage');


//BASIC SEARCH AND OTHER PAGES
Route::get('/rooms', [SearchResultController::class, 'rooms_index'])->name('all_rooms');
Route::get('/rooms/{room}', [SearchResultController::class, 'room_show'])->name('rooms.show');

//Resturant Page
Route::get('/restaurant', [RestaurantPageController::class, 'index'])->name('restaurant.index');

Route::get('/search_results', [SearchResultController::class, 'index'])->name('search_results');
Route::get('/package_details/{id}', [SearchResultController::class, 'show'])->name('package_details');

//BOOKING STEP 1

Route::get('/booking-step1', [BookingStep1Controller::class, 'showSummary'])->name('booking.summary');
Route::post('/booking-preroom-data', [BookingStep1Controller::class, 'preRoomSelection'])->name('booking.preRoomSelection');
Route::get('/booking-select-room', [BookingStep1Controller::class, 'roomsIndex'])->name('booking.roomsIndex');
Route::post('/booking-step1-store', [BookingStep1Controller::class, 'store'])->name('booking.store');


// Route to show the form for the second step of the booking
Route::get('/booking-step2', [BookingStep2Controller::class, 'index'])->name('booking.step2');
Route::post('/booking-step2/store', [BookingStep2Controller::class, 'store'])->name('bookingstep2.store');
Route::post('/booking-finalize', [BookingStep2Controller::class, 'finalize'])->name('booking.finalize');
Route::post('/booking/add-guest', [BookingStep2Controller::class, 'addGuest'])->name('booking.addGuest');

//route for final booking page
Route::get('/booking-confirmation', [BookingStep3Controller::class, 'index'])->name('booking.step3');


//COUPON VALIDATION
Route::post('/validate-coupon', [CouponController::class, 'validateCoupon'])->name('validate-coupon');
Route::post('/remove-coupon', [CouponController::class, 'remove'])->name('remove-coupon');
Route::get('/check-coupon', [CouponController::class, 'checkCouponSession'])->name('check-coupon');



//Terms & conditions
Route::get('/terms-and-conditions', [TermsConditionController::class, 'index'])->name('terms.index');



// User Routes Required Auth -- check userstatus so if banned or not if banned can't access anything
Route::middleware(['auth', 'CheckUserStatus'])->group(function () {

    Route::get('user/dashboard', [UserDashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'CheckUserStatus'])
    ->name('dashboard');

    //user profile
    Route::get('user/profile/{user}', [UserProfileController::class, 'editUser'])->name('profile.edit');
    Route::put('user/profile/{user}', [UserProfileController::class, 'updateUserProfile'])->name('profile.update');

    //BOOKING DETAILS VIEW
    Route::get('user/booking/view/{booking}', [UserBookingController::class, 'show'])->name('booking.show');

    //resend on success page
    Route::post('/resendBooking-confirmation/{booking_id}', [UserBookingController::class, 'resendBookingConfirmation'])->name('resendBooking.confirmation');

    //retry payment incase of failed from view booking page
    Route::post('/booking/{booking}/retry-payment', [UserBookingController::class, 'retryBookingPayment'])->name('retryBooking.payment');
    Route::get('/booking/successPayment/{booking:booking_id}', [UserBookingController::class, 'retrysuccess'])->name('retrybooking.success');
    Route::get('/booking/cancelPayment/{booking:booking_id}', [UserBookingController::class, 'retrycancel'])->name('retrybooking.cancel');

    //upload documents in booking
    Route::post('/booking/{bookingId}/upload-documents', [UserBookingController::class, 'uploadIdDocuments'])->name('booking.uploadIdDocuments');
    Route::post('/upload-scuba-diving-documents/{bookingId}', [UserBookingController::class, 'uploadScubaDivingDocuments'])->name('booking.uploadScubaDivingDocuments');

    //send support message
    Route::post('/booking/{bookingId}/message', [UserBookingController::class, 'postMessage'])->name('booking.postMessage');

    //Add additional service in already booked booking
    Route::post('/booking/{booking_id}/add-services', [UserBookingController::class, 'addAdditionalServices'])->name('booking.add-services');

    // Route for successful service_payment
    Route::get('booking/service_payment/success/{booking_id}', [UserBookingController::class, 'ServicepaymentSuccess'])->name('service.payment.success');

    // Route for canceled service_payment
    Route::get('booking/service_payment/cancel/{booking_id}', [UserBookingController::class, 'ServicepaymentCancel'])->name('service.payment.cancel');

    // route to edit family members
    Route::get('user/family', [FamilyMemberListController::class, 'index'])->name('family.index');
    Route::put('user/family/update/{familyMember}', [FamilyMemberListController::class, 'update'])->name('family.update');
    Route::delete('user/family/delete/{familyMember}', [FamilyMemberListController::class, 'destroy'])->name('family.destroy');



    //resend on success page
    Route::post('booking/resend-confirmation/{booking_id}', [PaymentController::class, 'resendConfirmation'])->name('resend.confirmation');

});


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//ADDITONAL ROUTES
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//PAYMENT GATEWAY IPN
Route::post('/ipn/coinbase/', [UserDepositController::class, 'handleCoinbaseWebhook']);
Route::post('/ipn/token-transaction', [TokenTransactionController::class, 'TokenTransaction']);

Route::post('/booking/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');
Route::get('/booking/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/booking/payment/failure', [PaymentController::class, 'failure'])->name('payment.failure');


Route::get('/webhook/stripe', [WebhookController::class, 'showWebhookStatus'])->name('webhook.stripe.get');
Route::post('/webhook/stripe', [WebhookController::class, 'handleWebhook'])->name('webhook.stripe');

Route::get('/update-booking-status', [BookingController::class, 'updateBookingStatus'])->name('update.booking.status');

Route::get('/distribute-agent-commission', [BookingController::class, 'DistributeAgentCommission'])->name('distribite.agent.commission');


// resgiter success page
Route::get('/search-result', function () {
    return view('user.search_result');
})->name('result');



/*

cron jobs

/update-booking-status every minute

php artisan queue:work

/distribute-agent-commission every 1 hour

*/

