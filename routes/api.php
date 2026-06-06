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
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductTypeController;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\WarehouseController;
use App\Http\Controllers\Api\DashboardController;

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

Route::prefix('dashboard')->group(function () {

    Route::get('/summary', [DashboardController::class, 'summary']);

    Route::get('/weekly-sales', [DashboardController::class, 'weeklySales']);

    Route::get('/monthly-sales', [DashboardController::class, 'monthlySales']);

    Route::get('/top-customers', [DashboardController::class, 'topCustomers']);

    Route::get('/top-customers-monthly', [DashboardController::class, 'topCustomersMonthly']);

    Route::get('/stock-alert', [DashboardController::class, 'stockAlert']);

    Route::get('/top-selling-products', [DashboardController::class, 'topSellingProducts']);

    Route::get('/pie-chart', [DashboardController::class, 'pieChart']);

    Route::get('/statistics', [DashboardController::class, 'statistics']);

    Route::get('/expire-soon', [DashboardController::class, 'expireSoon']);

    Route::get('/sales-expense-chart', [DashboardController::class, 'salesExpenseChart']);
});
Route::prefix('reports')->group(function () {

    Route::get('/sales', [ReportController::class, 'salesReport']);
    Route::get('/sales/{id}', [ReportController::class, 'saleDetails']);

    Route::get('/customers', [ReportController::class, 'customerReport']);
    Route::get('/customers/{id}', [ReportController::class, 'customerDetails']);

    Route::get('/employees', [ReportController::class, 'employeeReport']);
    Route::get('/employees/{id}', [ReportController::class, 'employeeDetails']);

    Route::get('/products', [ReportController::class, 'productReport']);
    Route::get('/products/{id}', [ReportController::class, 'productDetails']);

    Route::get('/loans', [ReportController::class, 'loanReport']);
    Route::get('/loans/{id}', [ReportController::class, 'loanDetails']);

    Route::get('/accounts', [ReportController::class, 'accountReport']);
    Route::get('/accounts/{id}', [ReportController::class, 'accountDetails']);

    Route::get('/expenses', [ReportController::class, 'expenseReport']);

    Route::get('/owner-pickups', [ReportController::class, 'ownerPickupReport']);

    Route::get('/salaries', [ReportController::class, 'salaryReport']);

    Route::get('/attendances', [ReportController::class, 'attendanceReport']);

    Route::get('/charts/sales', [ReportController::class, 'salesChart']);

    Route::get('/charts/expenses', [ReportController::class, 'expenseChart']);

    Route::get('/charts/warehouse', [ReportController::class, 'warehouseChart']);

    Route::get('/charts/customers', [ReportController::class, 'customerSalesChart']);

    Route::get('/charts/accounts', [ReportController::class, 'accountBalanceChart']);

    Route::get('/charts/dashboard', [ReportController::class, 'dashboardChart']);
});