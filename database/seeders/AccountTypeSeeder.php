<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('account_types')->insert(['type' => 'Cash']);
        DB::table('account_types')->insert(['type' => 'Investments']);
        DB::table('account_types')->insert(['type' => 'Credits']);
        DB::table('account_types')->insert(['type' => 'Bank account']);
    }
}
