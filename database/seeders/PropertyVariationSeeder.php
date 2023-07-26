<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyVariation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertyVariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    }

    public static function seed(Property $property): void
    {
        $property->variations()->saveMany(PropertyVariation::factory()->count(fake()->numberBetween(0,5))->make());
    }
}
