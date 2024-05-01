<?php

namespace App\Repositories;

use App\Interfaces\WalletRepositoryInterface;
use App\Models\Wallet;

class WalletRepository implements WalletRepositoryInterface
{
  public static function debitBalance(Wallet $wallet, float $value): void
  {
    $wallet->update([
      'balance' => $wallet->balance - $value
    ]);
  }

  public static function creditBalance(Wallet $wallet, float $value): void
  {
    $wallet->update([
      'balance' => $wallet->balance + $value
    ]);
  }

  public static function reverseBalance(Wallet $wallet, float $value): void
  {
    $wallet->update([
      'balance' => $wallet->balance + $value
    ]);
  }
}
