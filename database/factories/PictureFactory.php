<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Picture>
 */
class PictureFactory extends Factory
{
    
    public function definition(): array
    {
        $book = Book::factory()->create();
        return [
            'BooksISBN' => $book->ISBN,
            'path' => $this->faker->imageUrl(),
        ];
    }
}
