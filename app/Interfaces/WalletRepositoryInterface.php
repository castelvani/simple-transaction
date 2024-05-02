<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Wallet;

interface WalletRepositoryInterface
{
  public static function debitBalance(Wallet $wallet, float $value): void;
  public static function creditBalance(Wallet $wallet, float $value): void;
  public static function reverseBalance(Wallet $wallet, float $value): void;
}
