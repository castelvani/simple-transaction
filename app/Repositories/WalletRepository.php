<?php

namespace App\Repositories;

use App\Interfaces\WalletRepositoryInterface;
use App\Models\User;

class WalletRepository implements WalletRepositoryInterface
{
  public static function balance(User $user): float
  {
    return 1;
  }
}
