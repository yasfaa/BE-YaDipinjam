<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('circulated_books', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->integer('price');
            $table->enum('status', ['available','unavailable', 'borrowed'])->default('available');
            $table->string('BooksISBN');
            $table->foreign('BooksISBN')->references('isbn')->on('books');
            $table->unsignedBigInteger('userID');
            $table->foreign('userID')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circulated_books');
    }
};
