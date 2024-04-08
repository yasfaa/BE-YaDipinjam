<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Author;
use App\Models\Book;
use App\Models\CirculatedPicture;
use App\Models\Picture;
use App\Models\Publisher;
use App\Models\Rent;
use App\Models\Review;
use App\Models\User;
use App\Models\BookAuthor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Publisher::factory(10)->create();
        Author::factory(10)->create();
        Review::factory(10)->create();
        Book::factory(10)->create();
        BookAuthor::factory(10)->create();
        Picture::factory(10)->create();
        CirculatedPicture::factory(10)->create();
        Rent::factory(10)->create();
    }


}
