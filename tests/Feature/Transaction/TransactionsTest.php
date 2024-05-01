<?php

namespace Test\Feature\Transaction;

use App\Enums\UserTypeEnum;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TransactionsTest extends TestCase{
  
  use DatabaseMigrations;
  
  /** @test */
  public function transfer_wallets_test(){
    $this->withoutExceptionHandling();
    
    $commonUser = User::factory()->create([
      'type' => UserTypeEnum::Common
    ]);

    $payerWallet = Wallet::factory()->create([
      'owner_id' => $commonUser->id
    ]);
    
    $payeeWallet = Wallet::factory()->create();

    $response = $this->postJson(route('transaction.transfer'), [
      'value' => 1000,
      'payer' => $payerWallet->id,
      'payee' => $payeeWallet->id,
    ]);

    $response->assertOk();
  }
}