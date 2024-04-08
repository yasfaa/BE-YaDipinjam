<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookAuthor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookAuthor>
 */
class BookAuthorFactory extends Factory
{
    public function definition(): array
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create();
        return [
            'author_ID' => $author->id,
            'book_ISBN' => $book->ISBN
        ];
    }
}
