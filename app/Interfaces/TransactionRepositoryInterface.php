<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Transaction;

interface TransactionRepositoryInterface
{
  public static function processTransaction(array $payload): Transaction;
  public static function executeTransaction(Transaction $transaction): void;
  public static function transactionReversal(Transaction $transaction): void;
}
