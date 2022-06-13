<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory(10)->create();
        foreach ($users as $user) {
            Wallet::create([
                'user_id' => $user->id,
                'name' => 'Your default wallet',
                'currency' => 'VND',
                'amount' => 0,
            ]);
            Wallet::create([
                'user_id' => $user->id,
                'name' => 'Your bank wallet',
                'currency' => 'VND',
                'amount' => 0,
            ]);
        }

        $this->call(GroupSeeder::class);
    }
}
