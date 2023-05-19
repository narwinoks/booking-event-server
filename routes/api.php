<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\Api\V1\LocationController;
use App\Http\Controllers\Api\V1\UserController;
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
        Route::get('/{slug}', 'show')->name('show');
    });
    Route::controller(LocationController::class)->prefix('locations')->name('locations.')->group(function () {
        Route::get('/', 'index')->name('index');
    });
    Route::middleware('auth.jwt')->controller(UserController::class)->prefix('/user')->group(function () {
        Route::get('/profile', 'profile')->name('profile');
    });
});
