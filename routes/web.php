<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Auth\LoginController;
use App\Http\Controllers\Frontend\Auth\RegisterController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\RoomController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Frontend\BlogController;

 /* ------------------------------------- Auth Routes --------------------------------- */
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.submit');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'create'])->name('register');
Route::post('register', [RegisterController::class, 'store'])->name('register.submit');

Route::get('/verify-otp', [RegisterController::class, 'showVerifyForm'])->name('show.verify-otp');
Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->name('verify-otp');
Route::post('/resend-otp', [RegisterController::class, 'resendOtp'])->name('resend.otp');
 /* ------------------------------------- Auth Routes --------------------------------- */


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/rooms/available', [HomeController::class, 'getAvailableRooms'])->name('home.available.rooms');
Route::get('/rooms/filter', [RoomController::class, 'filter'])->name('rooms.filter');
Route::resource('rooms', RoomController::class);
Route::resource('blogs', BlogController::class);



    Route::get('/{room_id}/pay', [PaymentController::class, 'showPaymentPage'])
           ->name('payment.page');
                Route::post('/rooms/check-Room-Availability', [RoomController::class, 'checkRoomAvailability'])
           ->name('rooms.checkRoomAvailability');

Route::post('/contact_us', [HomeController::class, 'contactStore'])->name('contact.submit');
Route::get('/contact_us', [HomeController::class, 'showContact'])->name('contact.show');

