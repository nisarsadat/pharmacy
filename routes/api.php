<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductTypeController;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\WarehouseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Api\ExpenseCategoryController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\OwnerPickupController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('accounts', AccountController::class);
Route::apiResource('expense-categories', ExpenseCategoryController::class);
Route::apiResource('expenses', ExpenseController::class);
Route::apiResource('owner-pickups', OwnerPickupController::class);
Route::apiResource('warehouses', WarehouseController::class);
Route::apiResource('product-types', ProductTypeController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('customers', CustomerController::class);
Route::apiResource('sales', SaleController::class);
Route::apiResource('employees', EmployeeController::class);
Route::apiResource('attendances', AttendanceController::class);
Route::apiResource('salaries', SalaryController::class);