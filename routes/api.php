<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/line/webhook', [\App\Http\Controllers\LineController::class, 'webhook']);
Route::post('/line/repairInfo',[\App\Http\Controllers\RepairInfoController::class, 'getRepairInfo']);
Route::post('/line/carInfo',[\App\Http\Controllers\RepairInfoController::class, 'getCarInfo']);
Route::post('/line/customer/profile',[\App\Http\Controllers\CustomerController::class, 'profile']);

Route::get('/repairOrder/{id}',[\App\Http\Controllers\Api\RepairController::class, 'show']);
