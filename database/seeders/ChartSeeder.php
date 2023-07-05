<?php

namespace Database\Seeders;

use App\Models\Chart;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChartSeeder extends Seeder
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
        $user->charts()->saveMany(
            Chart::factory()->count(20)->make()->each(function ($chart) use ($user) {
                if (($chart['kind'] == 'line' || $chart['kind'] == 'bar') && $chart['filter'] != 'all') {
                    $chart['filter_id'] = DB::table($chart['filter'])
                        ->where('user_id', '=', $user->id)
                        ->inRandomOrder()
                        ->first()->id;
                } elseif ($chart['kind'] == 'pie' && fake()->randomElement([true, false])) {
                    $groups = ['accounts', 'beneficiaries', 'categories'];
                    $chart['filter_id'] = DB::table($chart['filter'])
                        ->where('user_id', '=', $user->id)
                        ->inRandomOrder()
                        ->first()->id;
                    $chart['filter_group'] = fake()->randomElement(array_diff($groups, [$chart['filter']]));
                }
            })
        );
    }
}
