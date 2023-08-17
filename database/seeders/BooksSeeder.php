<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 210000; $i++) {
            DB::table('books')
                ->insertOrIgnore([
                    'name' => fake()->streetName(),
                    'year' => fake()->dateTimeBetween('1970', 'now')->format('Y'),
                    'lang' => fake()->randomElement(['ua', 'en', 'pl', 'de']),
                    'pages' => fake()->numberBetween(10, 55000),
                    'category_id' => fake()->numberBetween('100', '400'),
                    'created_at' => fake()->dateTimeBetween('2022-01-01', '2023-01-01')->format('Y-m-d'),
                    'updated_at' => fake()->dateTimeBetween('2023-01-01', 'now')->format('Y-m-d'),
                ]);
        }
    }
}
