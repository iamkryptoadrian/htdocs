<?php

//ADMIN NAMESPACE
use App\Http\Controllers\Admin\GeneralSettingsController;
use App\Http\Controllers\Admin\AdminUserProfileController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\UserListController;
use App\Http\Controllers\Admin\AdminServiceController;
use App\Http\Controllers\Admin\AdminRoomController;
use App\Http\Controllers\Admin\AdminPackageController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\SurchargeController;
use App\Http\Controllers\Admin\AllBookingController;
use App\Http\Controllers\Admin\BookingSettingController;
use App\Http\Controllers\Admin\FrontendController;
use App\Http\Controllers\BookingNoteController;
use App\Http\Controllers\Admin\RestaurantPageController;
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\ArtisanCommandController;
use App\Http\Controllers\TermsConditionController;



Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function(){

    Route::namespace('Auth')->middleware('guest:admin')->group(function(){
        //login route
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('adminlogin');
    });

    Route::middleware('admin')->group(function(){
        Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');

        // Profile routes for admin
        Route::get('dashboard/profile', [AdminProfileController::class, 'profile'])->name('adminprofile');
        Route::put('dashboard/profile/update', [AdminProfileController::class, 'updateProfile'])->name('adminupdate');
        Route::put('dashboard/profile/update-password', [AdminProfileController::class, 'updatePassword'])->name('adminupdatePassword');

        // Admin user control
        Route::get('dashboard/users', [UserListController::class, 'index'])->name('userlist');
        Route::get('dashboard/users/edit-user/{user}', [AdminUserProfileController::class, 'editUser'])->name('editUser');
        Route::put('dashboard/users/update-user/{user}', [AdminUserProfileController::class, 'updateUser'])->name('updateUser');
        Route::delete('dashboard/users/ban/{user}', [UserListController::class, 'banUser'])->name('banUser');
        Route::post('dashboard/users/update-balance/{user}', [AdminUserProfileController::class, 'updateUserBalance'])->name('updateUserBalance');
        Route::get('dashboard/users/get-user-balance/{user}/{walletType}', [AdminUserProfileController::class, 'getUserBalance'])->name('getUserBalance');


        // Admin Agents control
        Route::get('dashboard/agents', [AgentController::class, 'index'])->name('agentlist');
        Route::get('dashboard/agents/edit-agent/{agent}', [AdminUserProfileController::class, 'editUser'])->name('editAgent');
        Route::put('dashboard/agents/update-agent/{agent}', [AdminUserProfileController::class, 'agentUser'])->name('updateAgent');
        Route::delete('dashboard/agents/ban/{agent}', [AgentController::class, 'banAgent'])->name('banAgent');

        //Login as user
        Route::get('dashboard/login-as-user/{user}', [AdminUserProfileController::class, 'loginAsUser'])->name('loginAsUser');

        //Login as Agent
        Route::get('dashboard/login-as-agent/{agent}', [AdminUserProfileController::class, 'loginAsAgent'])->name('loginAsAgent');

        //general settings
        Route::get('dashboard/general_settings', [GeneralSettingsController::class, 'index'])->name('general_settings.index');
        Route::put('dashboard/general_settings/{settings}', [GeneralSettingsController::class, 'update'])->name('general_settings.update');
        Route::post('dashboard/general_settings/{id}/add_withdraw_method', [GeneralSettingsController::class, 'addWithdrawMethod'])->name('general_settings.add_withdraw_method');
        Route::put('dashboard/general_settings/{id}/update_withdraw_method/{methodIndex}', [GeneralSettingsController::class, 'updateWithdrawMethod'])->name('general_settings.update_withdraw_method');
        Route::delete('dashboard/general_settings/{id}/delete_withdraw_method/{methodIndex}', [GeneralSettingsController::class, 'deleteWithdrawMethod'])->name('general_settings.delete_withdraw_method');


        // Service routes
        Route::get('dashboard/services', [AdminServiceController::class, 'index'])->name('services.index');
        Route::post('dashboard/services', [AdminServiceController::class, 'store'])->name('services.store');
        Route::put('dashboard/services/{service_id}', [AdminServiceController::class, 'update'])->name('services.update');
        Route::delete('dashboard/services/{service_id}', [AdminServiceController::class, 'destroy'])->name('services.destroy');

        // rooms routes
        Route::get('dashboard/rooms', [AdminRoomController::class, 'index'])->name('rooms.index');
        Route::post('dashboard/rooms', [AdminRoomController::class, 'store'])->name('rooms.store');
        Route::put('dashboard/rooms/{room_id}', [AdminRoomController::class, 'update'])->name('rooms.update');
        Route::delete('dashboard/rooms/{room_id}', [AdminRoomController::class, 'destroy'])->name('rooms.destroy');
        Route::post('/dashboard/rooms/deleteGalleryImage/{room_id}', [AdminRoomController::class, 'deleteGalleryImage']);

        // Coupons routes
        Route::get('dashboard/coupons', [CouponController::class, 'index'])->name('coupon');
        Route::post('dashboard/coupon_save', [CouponController::class, 'store'])->name('coupon.store');
        Route::put('dashboard/coupons/{coupon_id}', [CouponController::class, 'update'])->name('coupon.update');
        Route::delete('dashboard/coupons/{coupon_id}', [CouponController::class, 'destroy'])->name('coupon.destroy');


        // Package routes
        Route::get('dashboard/packages', [AdminPackageController::class, 'index'])->name('packages.index');
        Route::get('dashboard/packages/create', [AdminPackageController::class, 'create'])->name('packages.create');
        Route::post('dashboard/packages', [AdminPackageController::class, 'store'])->name('packages.store');
        Route::get('dashboard/packages/{package_id}/edit', [AdminPackageController::class, 'edit'])->name('packages.edit');
        Route::put('dashboard/packages/{package}', [AdminPackageController::class, 'update'])->name('packages.update');
        Route::delete('dashboard/packages/{package_id}', [AdminPackageController::class, 'destroy'])->name('packages.destroy');
        Route::post('dashboard/packages/{package_id}/delete-image', [AdminPackageController::class, 'deleteImage'])->name('packages.deleteImage');
        Route::post('dashboard/packages/{package}/delete-other-image', [AdminPackageController::class, 'deleteOtherImage'])->name('packages.deleteOtherImage');

        //SURCHARE ROUTES
        Route::get('dashboard/surcharges', [SurchargeController::class, 'index'])->name('surcharge.index');
        Route::post('dashboard/surcharges', [SurchargeController::class, 'store'])->name('surcharge.store');
        Route::put('dashboard/surcharges/{surcharge}', [SurchargeController::class, 'update'])->name('surcharge.update');
        Route::delete('dashboard/surcharges/{surcharge}', [SurchargeController::class, 'destroy'])->name('surcharge.destroy');

        //ALL BOOKING ROUTES
        Route::get('dashboard/bookings', [AllBookingController::class, 'index'])->name('bookings.index');
        Route::get('dashboard/view/booking/{booking_id}', [AllBookingController::class, 'viewBooking'])->name('bookings.view');
        Route::post('dashboard/bookings/{bookingId}/notes/private', [BookingNoteController::class, 'storePrivateNote'])->name('notes.private');
        Route::delete('dashboard/delete/notes/{id}', [BookingNoteController::class, 'delete'])->name('notes.delete');
        Route::patch('dashboard/bookings/{id}/update-status', [AllBookingController::class, 'updateStatus'])->name('booking.updateStatus');


        //reply user message
        Route::post('dashboard/booking/{bookingId}/reply-message', [AllBookingController::class, 'replyMessage'])->name('booking.replyMessage');

        // Booking Settings (Age and Discount)
        Route::get('dashboard/bookingAge_setings', [BookingSettingController::class, 'index'])->name('ageSettings.index');
        Route::post('dashboard/booking_settings/update', [BookingSettingController::class, 'storeGeneralSettings'])->name('bookingSettings.storeGeneral');

        // Port Settings and Calendar
        route::get('dashboard/bookingPort_calender', [BookingSettingController::class, 'port_calender_index'])->name('portcalender.index');
        Route::get('dashboard/portDetails/setup/{date}', [BookingSettingController::class, 'portSetup'])->name('portDetails.setup');
        Route::post('dashboard/bookingPort_setings/store/{date}', [BookingSettingController::class, 'storePortSettings'])->name('bookingSettings.storePort');

        Route::post('dashboard/default-port-setup', [BookingSettingController::class, 'updateDefaultPort'])->name('defaultPort.setup');


        //Frontend Settings
        //Activity
        Route::get('dashboard/frontend/activity-section', [FrontendController::class, 'activity_section'])->name('frontend.activity');
        Route::PUT('dashboard/frontend/activity-section/save', [FrontendController::class, 'update_activity_section'])->name('frontend.activities.update');

        //Testimonial
        Route::get('dashboard/frontend/testimonials', [FrontendController::class, 'showTestimonials'])->name('frontend.testimonials');
        Route::post('dashboard/frontend/testimonials/save', [FrontendController::class, 'saveTestimonial'])->name('frontend.testimonials.save');

        //Instgram Section
        Route::get('dashboard/frontend/instagram_section', [FrontendController::class, 'instagramShow'])->name('frontend.instagram_section');
        Route::put('dashboard/frontend/instagram_section/save', [FrontendController::class, 'InstagramSave'])->name('frontend.instagram_section.save');

        //Slider Section
        Route::get('dashboard/frontend/sliders', [FrontendController::class, 'sliderIndex'])->name('sliders.index');
        Route::post('dashboard/frontend/sliders', [FrontendController::class, 'sliderstore'])->name('sliders.store');
        Route::get('dashboard/frontend/sliders/{slider}/edit', [FrontendController::class, 'slideredit'])->name('sliders.edit');
        Route::put('dashboard/frontend/sliders/{slider}', [FrontendController::class, 'sliderupdate'])->name('sliders.update');
        Route::delete('dashboard/frontend/sliders/{slider}', [FrontendController::class, 'sliderdestroy'])->name('sliders.destroy');


        //Restuarant Page
        Route::get('dashboard/frontend/restaurant', [RestaurantPageController::class, 'admin_index'])->name('restaurant.index');
        Route::post('dashboard/frontend/restaurant', [RestaurantPageController::class, 'store'])->name('restaurant.store');
        Route::put('dashboard/frontend/restaurant/{restaurant}', [RestaurantPageController::class, 'update'])->name('restaurant.update');
        Route::delete('dashboard/frontend/restaurant/{restaurant}', [RestaurantPageController::class, 'destroy'])->name('restaurant.destroy');

        //Artisan Command Page
        Route::get('dashboard/command', [ArtisanCommandController::class, 'showCommandPage'])->name('command');
        Route::post('dashboard/command', [ArtisanCommandController::class, 'runCommand'])->name('runCommand');

        //agent cashout request
        Route::get('dashboard/agent_cashout', [AgentController::class, 'viewCashoutRequests'])->name('agent_cashout');
        // Approve cashout request
        Route::post('dashboard/agent_cashout/approve/{id}', [AgentController::class, 'approveCashoutRequest'])->name('approve_cashout');
        // Reject cashout request
        Route::post('dashboard/agent_cashout/reject/{id}', [AgentController::class, 'rejectCashoutRequest'])->name('reject_cashout');

        //admin terms and condition page
        Route::get('dashboard/terms-and-conditions', [TermsConditionController::class, 'manage'])->name('terms.manage');
        Route::post('dashboard/terms-and-conditions', [TermsConditionController::class, 'save'])->name('terms.save');
    
    });

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
