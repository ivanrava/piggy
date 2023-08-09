<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyVariationController;
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
    Route::get('/stats/year/categories/{id}', [StatsController::class, 'year'])->name('year.categories');
    Route::get('/stats/year/beneficiaries/{id}', [StatsController::class, 'year'])->name('year.beneficiaries');
    Route::get('/stats/year/accounts/{id}', [StatsController::class, 'year'])->name('year.accounts');
    Route::get('/stats/year/top', [StatsController::class, 'year']);
    Route::get('/stats/month', [StatsController::class, 'month']);
    Route::get('/stats/month/categories/{id}', [StatsController::class, 'month'])->name('month.categories');
    Route::get('/stats/month/beneficiaries/{id}', [StatsController::class, 'month'])->name('month.beneficiaries');
    Route::get('/stats/month/accounts/{id}', [StatsController::class, 'month'])->name('month.accounts');
    Route::get('/stats/month/top', [StatsController::class, 'month']);
    Route::get('/stats/beneficiaries', [StatsController::class, 'beneficiaries']);
    Route::get('/stats/beneficiaries/top', [StatsController::class, 'beneficiaries']);
    Route::get('/stats/categories', [StatsController::class, 'categories']);
    Route::get('/stats/categories/top', [StatsController::class, 'categories']);
    Route::get('/stats/accounts', [StatsController::class, 'accounts']);
    Route::get('/stats/accounts/top', [StatsController::class, 'accounts']);

    Route::get('/stats/categories/{category}/beneficiaries', [CategoryController::class, 'stats_beneficiaries']);
    Route::get('/stats/categories/{category}/accounts', [CategoryController::class, 'stats_accounts']);
    Route::get('/stats/beneficiaries/{beneficiary}/categories', [BeneficiaryController::class, 'stats_categories']);
    Route::get('/stats/beneficiaries/{beneficiary}/accounts', [BeneficiaryController::class, 'stats_accounts']);
    Route::get('/stats/accounts/{account}/categories', [AccountController::class, 'stats_categories']);
    Route::get('/stats/accounts/{account}/beneficiaries', [AccountController::class, 'stats_beneficiaries']);

    Route::apiResource('accounts', AccountController::class);
    Route::apiResource('beneficiaries', BeneficiaryController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('transactions', TransactionController::class);
    Route::apiResource('transfers', TransferController::class);
    Route::get('/charts/favorites', [ChartController::class, 'favorites']);
    Route::apiResource('charts', ChartController::class);
    Route::apiResource('properties', PropertyController::class);
    Route::post('/properties/{property}/variations', [PropertyVariationController::class, 'store']);
    Route::apiResource('budget', BudgetController::class)->only(['index', 'update']);
});
