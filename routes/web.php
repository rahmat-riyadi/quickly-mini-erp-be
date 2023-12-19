<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\DeliveryOrderController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ItemCategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MonthlySalaryController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SaleItemController;
use App\Http\Controllers\SaleItemGroupController;
use App\Http\Controllers\ShiftTimeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WarehouseItemController;
use App\Http\Controllers\WarehouseItemGroupController;
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
    // Route::post('/admin', [AdminController::class, 'index'])->name('admin.post');
    // Route::delete('/admin/delete/{admin}', [AdminController::class, 'destroy']);
    Route::post('/supplier', [SupplierController::class, 'index'])->name('supplier.post');
    Route::delete('/supplier/delete/{supplier}', [SupplierController::class, 'destroy']);
    Route::post('/warehouse-item-group', [WarehouseItemGroupController::class, 'index'])->name('warehouseItemGroup.post');
    Route::delete('/warehouse-item-group/delete/{warehouseItemGroup}', [WarehouseItemGroupController::class, 'destroy']);
    Route::post('/warehouse-item', [WarehouseItemController::class, 'index'])->name('warehouseItem.post');
    Route::delete('/warehouse-item/delete/{warehouseItem}', [WarehouseItemController::class, 'destroy']);
    Route::post('/sale-item-group', [SaleItemGroupController::class, 'index'])->name('saleItemGroup.post');
    Route::delete('/sale-item-group/delete/{saleItemGroup}', [SaleItemGroupController::class, 'destroy']);
    Route::post('/sale-item', [SaleItemController::class, 'index'])->name('saleItem.post');
    Route::delete('/sale-item/delete/{saleItem}', [SaleItemController::class, 'destroy']);
    Route::post('/item-category', [ItemCategoryController::class, 'index'])->name('itemCategory.post');
    Route::delete('/item-category/delete/{itemCategory}', [ItemCategoryController::class, 'destroy']);
    Route::post('/item', [ItemController::class, 'index'])->name('item.post');
    Route::delete('/item/delete/{item}', [ItemController::class, 'destroy']);
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

Route::group(['prefix' => 'operational'], function(){
    Route::post('/delivery-order', [DeliveryOrderController::class, 'index'])->name('deliveryOrder.post');
    Route::delete('/delivery-order/delete/{deliveryOrder}', [DeliveryOrderController::class, 'destroy']);
});

    Route::post('/test', [TestController::class, 'index'])->name('test.post');
    Route::delete('/test/delete/{test}', [TestController::class, 'destroy']);
        
