<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
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

Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [AuthController::class, 'login']);


Route::get('/station', [StationController::class, 'index']);
Route::get('/trip', [TripController::class, 'index']);
Route::get('/trip', [TripController::class, 'index']);
Route::post('/booking', [BookingController::class, 'store']);
Route::get('/booking/{code}', [BookingController::class, 'show']);
Route::get('/booking/{code}/seat', [BookingController::class, 'get_occupied_seat']);
Route::patch('/booking/{code}/seat', [BookingController::class, 'update']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/booking', [BookingController::class, 'index']);
    Route::get('/user', [UserController::class, 'show']);
});