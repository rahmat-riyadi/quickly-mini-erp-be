<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\CounterSaleItemController;
use App\Http\Controllers\DeliveryOrderController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SalesItemController;
use App\Http\Controllers\SalesItemGroupController;
use App\Http\Controllers\ShiftTimeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WarehouseItemController;
use App\Http\Controllers\WarehouseItemGroupController;
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

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['prefix' => 'sales'], function(){
    
    Route::group(['prefix' => 'item-group'], function(){
        Route::controller(SalesItemGroupController::class)->group(function(){
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::put('/{salesItemGroup}', 'update');
            Route::delete('/{salesItemGroup}', 'destroy');
        });
    });

    Route::group(['prefix' => 'item'], function(){
        Route::controller(SalesItemController::class)->group(function(){
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::put('/{salesItem}', 'update');
            Route::delete('/{salesItem}', 'destroy');
        });
    });

    
});

Route::group(['prefix' => 'warehouseItemGroup'], function(){
    Route::controller(WarehouseItemGroupController::class)->group(function(){
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/{warehouseItemGroup}', 'update');
        Route::delete('/{warehouseItemGroup}', 'destroy');
    });
});

Route::group(['prefix' => 'warehouseItem'], function(){
    Route::controller(WarehouseItemController::class)->group(function(){
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/{warehouseItem}', 'update');
        Route::delete('/{warehouseItem}', 'destroy');
    });
});

Route::group(['prefix' => 'counter'], function(){
    Route::controller(CounterController::class)->group(function(){
        Route::get('/', 'index');
        Route::get('/{counter}', 'show');
        Route::post('/', 'store');
        Route::put('/{counter}', 'update');
        Route::delete('/{counter}', 'destroy');
    });
});

Route::middleware('auth:sanctum')->group(function(){

    Route::group(['prefix' => 'report'], function(){
        Route::group(['prefix' => 'sales'], function(){
            Route::controller(SalesController::class)->group(function(){
                Route::get('/today', 'getTodaySalesRecord');
                Route::get('/today/{id}', 'getDetailTodaySales');
            });
        });
    });

    Route::group(['prefix' => 'invoice'], function(){
        Route::controller(InvoiceController::class)->group(function(){
            Route::get('/', 'index');
            Route::get('/salesRecord', 'getSalesRecord');
            Route::get('/salesRecord/{id}', 'getDetailSalesRecord');
            Route::post('/', 'store');
            Route::put('/{invoice}', 'update');
            Route::delete('/{invoice}', 'destroy');
        });
    });

    Route::group(['prefix' => 'counterSaleItem'], function(){
        Route::controller(CounterSaleItemController::class)->group(function(){
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::put('/{counterSaleItem}', 'update');
            Route::delete('/{counterSaleItem}', 'destroy');
        });
    });


    Route::group(['prefix' => 'cashier'], function(){
        Route::controller(CashierController::class)->group(function(){
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::put('/{cashier}', 'update');
            Route::delete('/{cashier}', 'destroy');
        });
    });

    Route::group(['prefix' => 'deliveryOrder'], function(){
        Route::controller(DeliveryOrderController::class)->group(function(){
            Route::get('/', 'index');
            Route::get('/detail/{deliveryOrder}', 'show');
            Route::get('/counter', 'counterDeliveryOrder');
            Route::post('/', 'store');
            Route::post('/storeDOitems', 'storeDOItems');
            Route::post('/operational', 'storeDO');
            Route::put('/{deliveryOrder}', 'update');
            Route::put('/updateDOItems/{id}', 'updateDOItems');
            Route::delete('/destroyDOItems/{id}', 'destroyDeliveryItems');
            Route::delete('/{deliveryOrder}', 'destroy');
        });
    });

    Route::group(['prefix' => 'supplier'], function(){
        Route::controller(SupplierController::class)->group(function(){
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::put('/{supplier}', 'update');
            Route::delete('/{supplier}', 'destroy');
        });
    });

    Route::group(['prefix' => 'employee'], function(){
        Route::controller(EmployeeController::class)->group(function(){
            Route::get('/', 'index');
            Route::get('/{employee}', 'show');
            Route::post('/', 'store');
            Route::put('/{employee}', 'update');
            Route::delete('/{employee}', 'destroy');
        });

    });

    Route::group(['prefix' => 'salary'], function(){
        Route::controller(SalaryController::class)->group(function(){
            Route::get('/{employee}', 'index');
            Route::post('/{employee}', 'store');
            Route::put('/{position}', 'update');
            Route::delete('/{salary}', 'destroy');
        });

        Route::controller(EmployeeController::class)->group(function(){
            Route::get('/employee/all', 'getAllEmployeeCurrentSalary');
            Route::get('/employee/{id}', 'getDetailAttendance');
        });
    });
    
    Route::group(['prefix' => 'position'], function(){
        Route::controller(PositionController::class)->group(function(){
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::put('/{position}', 'update');
            Route::delete('/{position}', 'destroy');
        });

    });

    

    Route::group(['prefix' => 'attendance'], function(){
        Route::controller(AttendanceController::class)->group(function(){
            Route::get('/', 'index');
            Route::put('/{attendance}', 'update');
            Route::delete('/{attendance}', 'destroy');
        });

        Route::controller(EmployeeController::class)->group(function(){
            Route::get('/employee/today', 'getEmployeeTodayAttendance');
            Route::get('/employee/today/{id}', 'getDetailAttendance');
        });



    });
    

});

Route::group(['prefix' => 'attendance'], function(){
    Route::controller(AttendanceController::class)->group(function(){
        Route::post('/', 'store');
        Route::post('/login', 'login');
    });
});

Route::group(['prefix' => 'shiftTime'], function(){
    Route::controller(ShiftTimeController::class)->group(function(){
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::put('/{shiftTime}', 'update');
        Route::delete('/{shiftTime}', 'destroy');
    });
});

Route::put('/mobile/employee/{employee}', [EmployeeController::class, 'updateEmployeeFromMobile']);