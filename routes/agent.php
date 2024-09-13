<?php

//AGENT NAMESPACE

use App\Http\Controllers\Agent\Auth\LoginController;
use App\Http\Controllers\Agent\Auth\AgentPasswordResetLinkController;
use App\Http\Controllers\Agent\Auth\AgentPasswordResetController;
use App\Http\Controllers\Agent\Auth\RegisteredAgentController;
use App\Http\Controllers\Agent\DashboardController;
use App\Http\Controllers\Agent\AgentTransactionController;
use App\Http\Controllers\Agent\AgentBookingController;
use App\Http\Controllers\Agent\CashoutController;
use App\Http\Controllers\Agent\AgentProfileController;


Route::namespace('Agent')->prefix('agent')->name('agent.')->group(function(){
    Route::namespace('Auth')->middleware(['guest:agent'])->group(function(){
        // login route
        Route::get('login', [LoginController::class, 'create'])->name('login');
        Route::post('login', [LoginController::class, 'store'])->name('agentlogin');
        Route::get('register', [RegisteredAgentController::class, 'create'])->name('register');
        Route::post('register', [RegisteredAgentController::class, 'register'])->name('agentRegister');

        Route::get('forgot-password', [AgentPasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('forgot-password', [AgentPasswordResetLinkController::class, 'store'])->name('password.email');
        Route::get('reset-password/{token}', [AgentPasswordResetController::class, 'create'])->name('password.reset');
        Route::post('reset-password', [AgentPasswordResetController::class, 'store'])->name('password.update');

    });

    // Redirect /agent to /agent/login
    Route::redirect('/', '/agent/login');

    Route::middleware(['auth.agent', 'CheckAgentStatus'])->group(function(){
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('dashboard/code', [DashboardController::class, 'updateAgentCode'])->name('update_code');
        Route::get('dashboard/commissions', [AgentTransactionController::class, 'index'])->name('commissions');
        Route::get('dashboard/bookings', [AgentBookingController::class, 'index'])->name('bookings.index');
        Route::get('dashboard/bookings/{booking_id}', [AgentBookingController::class, 'viewBooking'])->name('bookings.view');


        Route::get('dashboard/cashout', [CashoutController::class, 'index'])->name('cashout');
        Route::post('dashboard/cashout', [CashoutController::class, 'store'])->name('cashout.store');

        Route::get('dashboard/profile', [AgentProfileController::class, 'editAgent'])->name('profile.edit');
        Route::put('dashboard/profile', [AgentProfileController::class, 'updateAgentProfile'])->name('profile.update');
        Route::put('dashboard/profile/password', [AgentProfileController::class, 'updateAgentPassword'])->name('profile.updatePassword');


        Route::post('logout', [LoginController::class, 'destroy'])->name('agentlogout');
    });
});

// unauthenticated routes
Route::post('validate-agent-code', [DashboardController::class, 'validateAgentCode']);
Route::post('fetch-agent-name', [DashboardController::class, 'fetchAgentName']);
