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
        Schema::create('books', function (Blueprint $table) {
            $table->string('ISBN')->primary();
            $table->unsignedBigInteger('publisherID');
            $table->foreign('publisherID')->references('id')->on('publishers');
            $table->unsignedBigInteger('authorID');
            $table->foreign('authorID')->references('id')->on('authors');
            $table->integer('year');
            $table->string('tittle');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
