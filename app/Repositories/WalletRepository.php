<?php

namespace App\Repositories;

use App\Interfaces\WalletRepositoryInterface;
use App\Models\Wallet;

class WalletRepository implements WalletRepositoryInterface
{
  public static function updateBalance(Wallet $wallet, float $value): void
  {
    $wallet->update([
      'balance' => $wallet->balance - $value
    ]);
  }
}
