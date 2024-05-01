<?php

namespace App\Interfaces;

use App\Models\User;

interface WalletRepositoryInterface
{
  public static function balance(User $user): float;
}
