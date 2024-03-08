<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;

    protected $fillable = [
        'BooksISBN',
        'path',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
