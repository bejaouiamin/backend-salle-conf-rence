<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\EquipmentController;


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

Route::apiResource('salles', SalleController::class);
Route::post('reservations', [SalleController::class, 'createReservation']);
Route::get('reservations', [SalleController::class, 'getReservations']);


Route::apiResource('equipment', EquipmentController::class);
Route::put('equipment/{id}/status', [EquipmentController::class, 'updateStatus']);

