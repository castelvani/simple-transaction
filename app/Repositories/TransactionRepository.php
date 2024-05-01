<?php

namespace App\Repositories;

use App\Interfaces\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
  public static function transfer(array $payload): void
  {
    echo 'a';
  }
}
