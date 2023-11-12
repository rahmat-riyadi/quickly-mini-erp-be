<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MonthlySalaryController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ShiftTimeController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'master-data'], function(){
    Route::post('/counter', [CounterController::class, 'index'])->name('counter.post');
    Route::delete('/counter/delete/{counter}', [CounterController::class, 'destroy']);
    Route::post('/admin', [AdminController::class, 'index'])->name('admin.post');
    Route::delete('/admin/delete/{admin}', [AdminController::class, 'destroy']);
    Route::post('/supplier', [SupplierController::class, 'index'])->name('supplier.post');
    Route::delete('/supplier/delete/{supplier}', [SupplierController::class, 'destroy']);
});


Route::group(['prefix' => 'human-resource'], function(){
    Route::post('/position', [PositionController::class, 'index'])->name('position.post');
    Route::delete('/position/delete/{position}', [PositionController::class, 'destroy']);
    Route::post('/shiftTime', [ShiftTimeController::class, 'index'])->name('shiftTime.post');
    Route::delete('/shiftTime/delete/{shiftTime}', [ShiftTimeController::class, 'destroy']);
    Route::post('/employee', [EmployeeController::class, 'index'])->name('employee.post');
    Route::delete('/employee/delete/{employee}', [EmployeeController::class, 'destroy']);
    Route::post('/salary', [SalaryController::class, 'index'])->name('salary.post');
    Route::delete('/salary/delete/{salary}', [SalaryController::class, 'destroy']);
    Route::post('/attendance', [AttendanceController::class, 'index'])->name('attendance.post');
    Route::delete('/attendance/delete/{attendance}', [AttendanceController::class, 'destroy']);
    Route::post('/monthly-salary', [MonthlySalaryController::class, 'index'])->name('monthlySalary.post');
    Route::delete('/monthly-salary/delete/{monthlySalary}', [MonthlySalaryController::class, 'destroy']);
});

        




        
