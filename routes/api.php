<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransferController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/account_types', [AccountTypeController::class, 'index']);
    Route::get('/categories/root', [CategoryController::class, 'root']);
    Route::get('/categories/leaves', [CategoryController::class, 'leaves']);
    Route::get('/report', [ReportController::class, 'report']);
    Route::get('/stats/year', [StatsController::class, 'year']);
    Route::get('/stats/year/top', [StatsController::class, 'year']);
    Route::get('/stats/month', [StatsController::class, 'month']);
    Route::get('/stats/month/top', [StatsController::class, 'month']);
    Route::get('/stats/beneficiaries', [StatsController::class, 'beneficiaries']);
    Route::get('/stats/beneficiaries/top', [StatsController::class, 'beneficiaries']);
    Route::get('/stats/categories', [StatsController::class, 'categories']);
    Route::get('/stats/categories/top', [StatsController::class, 'categories']);
    Route::get('/stats/accounts', [StatsController::class, 'accounts']);
    Route::get('/stats/accounts/top', [StatsController::class, 'accounts']);
    Route::apiResource('accounts', AccountController::class);
    Route::apiResource('beneficiaries', BeneficiaryController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('transactions', TransactionController::class);
    Route::apiResource('transfers', TransferController::class);
});
