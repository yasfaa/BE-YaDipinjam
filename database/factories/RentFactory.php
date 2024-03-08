<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\CirculatedBook;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rent>
 */
class RentFactory extends Factory
{
    public function definition(): array
    {
        $circulated_book = CirculatedBook::factory()->create();
        $user = User::factory()->create();
        return [
            'userID' => $user->id,
            'Circulated_BookID' => $circulated_book->id,
            'start_date'=> $this->faker->date(),
            'end_date'=> $this->faker->date(),
        ];
    }
}
