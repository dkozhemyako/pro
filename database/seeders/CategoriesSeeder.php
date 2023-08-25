<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 1000; $i++) {
            DB::table('categories')
                ->insertOrIgnore([
                    'id' => fake()->numberBetween('1', '1000'),
                    'name' => fake()->word(),
                    'created_at' => fake()->dateTimeBetween('2022-01-01', '2023-01-01')->format('Y-m-d'),
                    'updated_at' => fake()->dateTimeBetween('2023-01-01', 'now')->format('Y-m-d'),
                ]);
        }
    }
}
