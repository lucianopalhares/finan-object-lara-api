<?php

use Illuminate\Support\Facades\Route;
use App\Application\Controllers\BankAccountController;
use App\Application\Controllers\BankTransactionController;
use App\Application\Controllers\BankTransactionAuditController;
use App\Application\Controllers\LogController;
use App\Http\Controllers\AuthController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('profile', [AuthController::class, 'getProfile']);
    Route::get('notifications', [AuthController::class, 'notifications']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('/conta', [BankAccountController::class, 'create']);
    Route::get('/conta', [BankAccountController::class, 'show']);
    Route::post('/transacao', [BankTransactionController::class, 'transact']);

    Route::get('/transacao-auditoria', [BankTransactionAuditController::class, 'index']);
    Route::get('/logs', [LogController::class, 'index']);
});
