<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;

use App\Http\Controllers\AccountController;
use App\Http\Controllers\OwnerPickupController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoanPaymentController;

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ExpenseCategoryController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductTypeController;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\WarehouseController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Login
Route::post('/login', [AuthController::class, 'login']);


/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // Logged user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */

    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // Change Password
    Route::post('/change-password', [UserController::class, 'changePassword']);


    /*
    |--------------------------------------------------------------------------
    | API Resources
    |--------------------------------------------------------------------------
    */

    Route::apiResource('accounts', AccountController::class);

    Route::apiResource('expense-categories', ExpenseCategoryController::class);

    Route::apiResource('expenses', ExpenseController::class);

    Route::apiResource('owner-pickups', OwnerPickupController::class);

    Route::apiResource('warehouses', WarehouseController::class);

    Route::apiResource('customers', CustomerController::class);

    Route::apiResource('sales', SaleController::class);

    Route::apiResource('employees', EmployeeController::class);

    Route::apiResource('attendances', AttendanceController::class);

    Route::apiResource('product-types', ProductTypeController::class);

    Route::apiResource('products', ProductController::class);

    Route::apiResource('salaries', SalaryController::class);

    Route::apiResource('loans', LoanController::class);

    Route::apiResource('loan-payments', LoanPaymentController::class);


    /*
    |--------------------------------------------------------------------------
    | Custom Routes
    |--------------------------------------------------------------------------
    */

    // Bulk attendance
    Route::post(
        '/attendances/bulk',
        [AttendanceController::class, 'bulkStore']
    );

    // Payments
    Route::post(
        '/payments',
        [PaymentController::class, 'store']
    );
});