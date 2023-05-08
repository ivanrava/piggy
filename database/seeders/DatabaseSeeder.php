<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Account;
use App\Models\Beneficiary;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Transfer;
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
            $user->beneficiaries()->saveMany(Beneficiary::factory()->count(20)->make());
            $user->categories()->saveMany(Category::factory()->count(20)->make());
            $user->accounts()->saveMany(Account::factory()->count(25)->make()->each(
                function (Account $account) {
                    $account->transactions()->saveMany(Transaction::factory()->count(50)->make());
                    $account->in_transfers()->saveMany(Transfer::factory()->count(2)->make());
                    $account->out_transfers()->saveMany(Transfer::factory()->count(2)->make());
                }
            ));
        });
    }
}
