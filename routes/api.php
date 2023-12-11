<?php

use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\ShiftTimeController;
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

Route::middleware('auth:sanctum')->group(function(){

    Route::group(['prefix' => 'attendance'], function(){
        Route::controller(AttendanceController::class)->group(function(){
            Route::post('/store', 'store');
            Route::get('/changeStatus/{status}', 'changeStatus');
            Route::get('/status', 'getCurrentStatus');
            Route::get('/timeOut', 'timeOut');
        });
    });

    Route::group(['prefix' => 'shiftTime'], function(){
        Route::controller(ShiftTimeController::class)->group(function(){
            Route::get('/', 'index');
        });
    });

});


Route::post('/attendance/login', [EmployeeController::class, 'login']);