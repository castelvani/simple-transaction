<?php

namespace App\Interfaces;

use App\Models\Wallet;

interface WalletRepositoryInterface
{
  public static function updateBalance(Wallet $wallet, float $value): void;
}
