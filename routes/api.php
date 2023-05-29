<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\Api\V1\LocationController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\WebHookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function (Request $request) {
    return response()->json(['message' => 'Welcome To Ticket Booking App']);
});

Route::prefix('/V1')->group(function () {
    Route::controller(AuthController::class)->prefix('/auth')->name('auth.')->group(function () {
        Route::post('/login', 'login')->name('login');
        Route::post('/register', 'register')->name('register');
        Route::post('/verification', 'verification')->name('verification');
        Route::get('/refresh-token', 'refreshToken')->name('refreshToken')->middleware('refresh.jwt');
        Route::delete('/logout', 'logout')->name('logout')->middleware('auth.jwt');
    });
    Route::controller(EventController::class)->prefix('events')->name('events.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/get-event-by-ticket/{id}', 'getEventByTicket')->name('getEventByTicket');
        Route::get('/{slug}', 'show')->name('show');
    });
    Route::controller(TicketController::class)->prefix('tickets')->name('tickets')->group(function () {
        Route::get('/get-ticket-event', 'getTicketEvent')->name('getTicketEvent');
    });
    Route::middleware('auth.jwt')->controller(OrderController::class)->prefix('order')->name('order')->group(function () {
        Route::post('/create-order', 'createOrder')->name('createOrder');
        Route::get('/get-order-user', 'getOrder')->name('getOrder');
        Route::get('/get-order-detail/{orderId}', 'getOrderUserDetail')->name('getOrderDetail');
    });
    Route::controller(LocationController::class)->prefix('locations')->name('locations.')->group(function () {
        Route::get('/', 'index')->name('index');
    });
    Route::controller(WebHookController::class)->prefix('webhook')->name('webhook.')->group(function () {
        Route::post('/', 'webhook')->name('webhook');
    });
    Route::middleware('auth.jwt')->controller(UserController::class)->prefix('/user')->group(function () {
        Route::get('/profile', 'profile')->name('profile');
        Route::post('/change-avatar', 'updateAvatar')->name('changeAvatar');
        Route::put('/change-password', 'changePassword')->name('changePassword');
        Route::put('/change-profile', 'changeProfile')->name('changeProfile');
    });
});
