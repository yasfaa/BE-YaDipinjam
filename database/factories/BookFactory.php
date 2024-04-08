<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BookFactory extends Factory
{
    public function definition(): array
    {
        $publisher = Publisher::factory()->create();

        return [
            'ISBN' => $this->faker->unique()->isbn10(),
            'publisherID' => $publisher->id,
            'year' => $this->faker->year(),
            'tittle' => $this->faker->sentence(),

        ];
    }
}
