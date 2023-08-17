<?php

namespace Database\Factories;

use App\Enums\LangEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $year = fake()->dateTimeBetween(1970)->format('Y');
        $createdAt = fake()->dateTimeBetween($year . '-01-01');

        return [
            'name' => fake()->sentence(),
            'year' => $year,
            'lang' => $this->faker->randomElement(LangEnum::class),
            'pages' => fake()->numberBetween(10, 55000),
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}
