<?php

namespace Database\Seeders;

use App\Models\Beneficiary;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BeneficiarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    }

    public static function seed(User $user): void
    {
        $user->beneficiaries()->saveMany(Beneficiary::factory()->count(60)->make());
    }
}
