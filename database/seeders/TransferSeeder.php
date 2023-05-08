<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransferSeeder extends Seeder
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
        $account->in_transfers()->saveMany(Transfer::factory()->count(2)->make()->each(function (Transfer $transfer) use ($user, $account) {
            $transfer->from_account_id = $user->accounts()->where('id', '!=', $account->id)->inRandomOrder()->first()->id;
        }));
        $account->out_transfers()->saveMany(Transfer::factory()->count(2)->make()->each(function (Transfer $transfer) use ($user, $account) {
            $transfer->to_account_id = $user->accounts()->where('id', '!=', $account->id)->inRandomOrder()->first()->id;
        }));
    }
}
