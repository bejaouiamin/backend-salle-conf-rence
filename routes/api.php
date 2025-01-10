<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AuthController;


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


// routes/api.php

//Route::middleware('auth:sanctum')->group(function () {
//    Route::get('/user', function (Request $request) {
//        return $request->user();
//    });
//});

Route::apiResource('salles', SalleController::class);
Route::post('reservation', [SalleController::class, 'createReservation']);
Route::get('reservation', [SalleController::class, 'getReservations']);
Route::apiResource('reservations', ReservationController::class);

Route::apiResource('equipment', EquipmentController::class);
Route::put('equipment/{id}/status', [EquipmentController::class, 'updateStatus']);

Route::apiResource('reservations', ReservationController::class);

Route::apiResource('users', AuthController::class);
Route::get('users', [AuthController::class, 'getAllUsers']);
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/reservations/{id}/send-reminder', [ReservationController::class, 'sendReminder']);
