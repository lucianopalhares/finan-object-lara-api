<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\BankTransactionController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/conta', [BankAccountController::class, 'create']);
Route::get('/conta', [BankAccountController::class, 'show']);
Route::post('/transacao', [BankTransactionController::class, 'transact']);
