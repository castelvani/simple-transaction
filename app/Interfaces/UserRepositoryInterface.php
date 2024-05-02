<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
  public static function register(User $user): void;
  public static function login(string $email, string $password): void;
}
