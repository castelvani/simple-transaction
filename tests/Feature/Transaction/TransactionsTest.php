<?php

namespace Test\Feature\Transaction;

use App\Enums\TransactionStatusEnum;
use App\Enums\UserTypeEnum;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TransactionsTest extends TestCase
{

  use DatabaseMigrations;

  #[Test]
  public function transaction_processing_test()
  {
    $this->withoutExceptionHandling();
    $commonUser = User::factory()->create([
      'type' => UserTypeEnum::Common,
      'cpf' => fake()->unique()->numerify('###########')
    ]);

    $payerWallet = Wallet::factory()->create([
      'balance'  => 5000,
      'owner_id' => $commonUser->id
    ]);

    $merchantUser = User::factory()->create([
      'type' => UserTypeEnum::Merchant,
      'cnpj' => fake()->unique()->numerify('##############'),
    ]);

    $payeeWallet = Wallet::factory()->create([
      'owner_id' => $merchantUser->id
    ]);

    $value = 1000;

    $response = $this->post(route('transfer'), [
      'value' => $value,
      'payer' => $payerWallet->id,
      'payee' => $payeeWallet->id,
    ]);

    $response->assertOk();

    $this->assertDatabaseHas('transactions', [
      'payer_id' => $payerWallet->id,
      'payee_id' => $payeeWallet->id,
      'value'    => $value,
      'status'   => TransactionStatusEnum::Processing
    ]);

    $this->assertDatabaseHas('wallets', [
      'owner_id' => $payerWallet->owner_id,
      'balance'  => ($payerWallet->balance - $value)
    ]);
  }

  #[Test]
  public function wallet_insufficient_balance_test()
  {
    $commonUser = User::factory()->create([
      'type' => UserTypeEnum::Common,
      'cpf' => fake()->unique()->numerify('###########')
    ]);

    $payerWallet = Wallet::factory()->create([
      'balance'  => 0,
      'owner_id' => $commonUser->id
    ]);

    $merchantUser = User::factory()->create([
      'type' => UserTypeEnum::Merchant,
      'cnpj' => fake()->unique()->numerify('##############'),
    ]);

    $payeeWallet = Wallet::factory()->create([
      'owner_id' => $merchantUser->id
    ]);

    $response = $this->post(route('transfer'), [
      'value' => 1000,
      'payer' => $payerWallet->id,
      'payee' => $payeeWallet->id,
    ]);

    $response->assertStatus(402);
  }

  #[Test]
  public function transaction_merchant_payer_not_allowed_test()
  {
    $merchantUser = User::factory()->create([
      'type' => UserTypeEnum::Merchant,
      'cnpj' => fake()->unique()->numerify('##############'),
    ]);

    $payerWallet = Wallet::factory()->create([
      'balance'  => 5000,
      'owner_id' => $merchantUser->id
    ]);

    $commonUser = User::factory()->create([
      'type' => UserTypeEnum::Common
    ]);

    $payeeWallet = Wallet::factory()->create([
      'owner_id' => $commonUser->id
    ]);

    $response = $this->post(route('transfer'), [
      'value' => 1000,
      'payer' => $payerWallet->id,
      'payee' => $payeeWallet->id,
    ]);

    $response->assertSessionHasErrors('payer', 'Only common users can execute transfer');
  }

  #[Test]
  public function transaction_common_to_common_allowed_test()
  {
    $firstCommonUser = User::factory()->create([
      'type' => UserTypeEnum::Common,
      'cnpj' => fake()->unique()->numerify('##############'),
    ]);

    $payerWallet = Wallet::factory()->create([
      'balance'  => 5000,
      'owner_id' => $firstCommonUser->id
    ]);

    $secondCommonUser = User::factory()->create([
      'type' => UserTypeEnum::Common
    ]);

    $payeeWallet = Wallet::factory()->create([
      'owner_id' => $secondCommonUser->id
    ]);

    $response = $this->post(route('transfer'), [
      'value' => 1000,
      'payer' => $payerWallet->id,
      'payee' => $payeeWallet->id,
    ]);

    $response->assertSessionDoesntHaveErrors();
  }
}
