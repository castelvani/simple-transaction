<?php

namespace Test\Feature\User;

use App\Enums\UserTypeEnum;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class UsersTest extends TestCase
{
  use DatabaseMigrations;

  #[Test]
  public function register_test()
  {
    $response = $this->withHeaders([
      'Accept' => 'application/json'
    ])->post(route('register'), [
      'name'     => fake()->name(),
      'email'    => fake()->unique()->safeEmail(),
      'password' => 'password',
      'cpf'      => fake()->unique()->numerify('###########'),
      'type'     => UserTypeEnum::Common->value,
    ]);

    $response->assertOk();
  }

  #[Test]
  public function unique_cpf_register_test()
  {
    $response = $this->withHeaders([
      'Accept' => 'application/json'
    ])->post(route('register'), [
      'name'     => fake()->name(),
      'email'    => fake()->unique()->safeEmail(),
      'password' => 'password',
      'cpf'      => '11111111111',
      'type'     => UserTypeEnum::Common->value,
    ]);

    $response->assertOk();

    $response = $this->withHeaders([
      'Accept' => 'application/json'
    ])->post(route('register'), [
      'name'     => fake()->name(),
      'email'    => fake()->unique()->safeEmail(),
      'password' => 'password',
      'cpf'      => '11111111111',
      'type'     => UserTypeEnum::Common->value,
    ]);
    
    $response->assertStatus(422);
  }

  #[Test]
  public function unique_cnpj_register_test()
  {
    $response = $this->withHeaders([
      'Accept' => 'application/json'
    ])->post(route('register'), [
      'name'     => fake()->name(),
      'email'    => fake()->unique()->safeEmail(),
      'password' => 'password',
      'cnpj'     => '11111111111111',
      'type'     => UserTypeEnum::Merchant->value,
    ]);

    $response->assertOk();

    $response = $this->withHeaders([
      'Accept' => 'application/json'
    ])->post(route('register'), [
      'name'     => fake()->name(),
      'email'    => fake()->unique()->safeEmail(),
      'password' => 'password',
      'cnpj'     => '11111111111111',
      'type'     => UserTypeEnum::Merchant->value,
    ]);

    $response->assertStatus(422);
  }

  #[Test]
  public function unique_email_register_test()
  {
    $response = $this->withHeaders([
      'Accept' => 'application/json'
    ])->post(route('register'), [
      'name'     => fake()->name(),
      'email'    => 'merchant@gmail.com',
      'password' => 'password',
      'cnpj'     => fake()->unique()->numerify('##############'),
      'type'     => UserTypeEnum::Merchant->value,
    ]);

    $response->assertOk();

    $response = $this->withHeaders([
      'Accept' => 'application/json'
    ])->post(route('register'), [
      'name'     => fake()->name(),
      'email'    => 'merchant@gmail.com',
      'password' => 'password',
      'cnpj'     => fake()->unique()->numerify('##############'),
      'type'     => UserTypeEnum::Merchant->value,
    ]);

    $response->assertStatus(422);
  }

  #[Test]
  public function login_test()
  {
    $response = $this->withHeaders([
      'Accept' => 'application/json'
    ])->post(route('register'), [
      'name'     => fake()->name(),
      'email'    => 'merchant@gmail.com',
      'password' => 'password',
      'cnpj'     => fake()->unique()->numerify('##############'),
      'type'     => UserTypeEnum::Merchant->value,
    ]);

    $response->assertOk();

    $response = $this->withHeaders([
      'Accept' => 'application/json'
    ])->post(route('login'), [
      'email'    => 'merchant@gmail.com',
      'password' => 'password',
    ]);

    $response->assertOk();
  }
}
