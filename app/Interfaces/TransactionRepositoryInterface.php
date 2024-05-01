<?php

namespace App\Interfaces;

interface TransactionRepositoryInterface
{
  public static function transfer(array $payload): void;
}
