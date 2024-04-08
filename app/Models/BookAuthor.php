<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookAuthor extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_ID',
        'book_ISBN'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class,);
    }

    public function author()
    {
        return $this->belongsTo(Author::class,);
    }
}
