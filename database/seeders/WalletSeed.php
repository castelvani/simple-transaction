<?php

namespace Database\Seeders;

use App\Enums\UserTypeEnum;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class WalletSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Wallet::factory()->create([
            'balance'  => 5000,
            'owner_id' => User::where('type', UserTypeEnum::Common)->first()->id
        ]);
        
        Wallet::factory()->create([
            'owner_id' => User::where('type', UserTypeEnum::Merchant)->first()->id
        ]);
    }
}
