<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/transfer', [TransactionController::class, 'transfer'])->name('transfer')->middleware(['auth:sanctum']);

Route::post('/user/register', [UserController::class, 'register'])->name('register');
Route::post('/user/login', [UserController::class, 'login'])->name('login');