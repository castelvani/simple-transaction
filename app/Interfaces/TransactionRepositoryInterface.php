<?php

namespace App\Interfaces;

use App\Models\Transaction;

interface TransactionRepositoryInterface
{
  public static function processTransaction(array $payload): void;
  public static function executeTransaction(Transaction $transaction): void;
  public static function transactionReversal(Transaction $transaction): void;
}
