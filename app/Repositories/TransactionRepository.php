<?php

namespace App\Repositories;

use App\Enums\TransactionStatusEnum;
use App\Interfaces\TransactionRepositoryInterface;
use App\Models\Transaction;

class TransactionRepository implements TransactionRepositoryInterface
{
  public static function processTransaction(array $payload): Transaction
  {
    return Transaction::create([
      'payer_id' => $payload['payer_id'],
      'payee_id' => $payload['payee_id'],
      'value'    => $payload['value'],
      'status'   => TransactionStatusEnum::Processing,
    ]);
  }

  public static function executeTransaction(Transaction $transaction): void
  {
    $transaction->update([
      'status' => TransactionStatusEnum::Finished
    ]);
  }

  public static function transactionReversal(Transaction $transaction): void
  {
    $transaction->update([
      'status' => TransactionStatusEnum::Reversed
    ]);
  }
}
