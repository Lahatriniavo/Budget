<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\ForecastController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\FinancialGoalController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\RevenueController;
use App\Http\Controllers\DataImportExportController;

// Routes publiques
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées par Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('budgets', BudgetController::class);
    Route::apiResource('transactions', TransactionController::class);
    Route::apiResource('forecasts', ForecastController::class);
    Route::get('profile', [ProfileController::class, 'show']);
    Route::put('profile', [ProfileController::class, 'update']);
    Route::apiResource('financial-goals', FinancialGoalController::class);
    Route::apiResource('revenues', RevenueController::class);
    Route::post('/import', [DataImportExportController::class, 'import']);
    Route::get('/export', [DataImportExportController::class, 'export']);
    Route::post('/financial-goals', [FinancialGoalController::class, 'store']);
    Route::put('/financial-goals/{id}', [FinancialGoalController::class, 'update']);
    Route::delete('/financial-goals/{id}', [FinancialGoalController::class, 'destroy']);
    Route::get('/financial-goals', [FinancialGoalController::class, 'index']);
    Route::post('/notifications', [NotificationController::class, 'store']);
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead']);
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('profile', [ProfileController::class, 'show']);
    Route::put('profile', [ProfileController::class, 'update']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});
