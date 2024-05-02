<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
  public static function register(User $user): void
  {
    echo 'a';
  }

  public static function login(string $email, string $password): void
  {
    
  }
}
