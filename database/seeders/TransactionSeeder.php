<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    }

    public static function seed(Account $account, User $user): void
    {
        $account->transactions()->saveMany(Transaction::factory()->count(50)->make()->each(function (Transaction $trans) use ($user) {
            $trans->category_id = $user->categories()->inRandomOrder()->first()->id;
            $trans->beneficiary_id = $user->beneficiaries()->inRandomOrder()->first()->id;
        }));
    }
}
