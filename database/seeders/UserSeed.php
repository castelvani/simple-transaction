<?php

namespace Database\Seeders;

use App\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'type' => UserTypeEnum::Common,
            'cpf' => fake()->unique()->numerify('###########')
        ]);

        User::factory()->create([
            'type' => UserTypeEnum::Merchant,
            'cnpj' => fake()->unique()->numerify('##############'),
        ]);
    }
}
