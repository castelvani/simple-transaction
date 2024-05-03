<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
  public static function register(array $payload): User;
  public static function login(array $payload): User;
}
