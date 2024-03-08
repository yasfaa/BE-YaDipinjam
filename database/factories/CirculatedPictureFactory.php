<?php

namespace Database\Factories;

use App\Models\CirculatedBook;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CirculatedPictureFactory extends Factory
{
    public function definition(): array
    {
        $circulated_book = CirculatedBook::factory()->create();
        return [
            'Circulated_BookID' => $circulated_book->id,
            'path' => $this->faker->imageUrl(),
        ];
    }
}
