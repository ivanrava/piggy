<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Account;
use App\Models\Property;
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
        User::factory()->count(2)->create()->each(function (User $user) {
            BeneficiarySeeder::seed($user);
            CategorySeeder::seed($user);
            AccountSeeder::seed($user);
            $user->accounts()->each(function (Account $account) use ($user) {
                TransactionSeeder::seed($account, $user);
                TransferSeeder::seed($account, $user);
            });
            ChartSeeder::seed($user);
            PropertySeeder::seed($user);
            $user->properties()->each(function (Property $property) {
                PropertyVariationSeeder::seed($property);
            });
        });
    }
}
