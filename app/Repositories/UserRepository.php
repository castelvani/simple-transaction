<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
  public static function register(array $payload): User
  {
    return User::create($payload);
  }

  public static function login(array $payload): User
  {
    return User::where('email', $payload['email'])
      ->first();
  }
}
