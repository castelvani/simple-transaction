<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::post('/transfer', [TransactionController::class, 'transfer'])->name('transfer');

Route::get('/', function(){
  return 'a';
});