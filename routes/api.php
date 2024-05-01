<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::post('/transaction/transfer', [TransactionController::class, 'transfer'])->name('transaction.transfer');

Route::get('/', function(){
  return 'a';
});