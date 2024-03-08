<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CirculatedBookFactory extends Factory
{ 
    public function definition(): array
    {
        $book = Book::factory()->create();
        $user = User::factory()->create();
        return [
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(0, 200000),
            'status' => 'available',
            'BooksISBN' => $book->ISBN,
            'userID' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
