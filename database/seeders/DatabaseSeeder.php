<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AccountTypeSeeder::class
        ]);
        User::factory()->count(3)->create()->each(function (User $user) {
            $user->accounts()->saveMany(Account::factory()->count(10)->make());
        });
    }
}
