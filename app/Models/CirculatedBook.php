<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CirculatedBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'price',
        'status',
        'BooksISBN',
        'userID',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class,);
    }

    public function user()
    {
        return $this->belongsTo(User::class,);
    }
}
