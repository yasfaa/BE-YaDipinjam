<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $primaryKey = 'ISBN';
    public $incrementing = false;
    protected $keyType = 'integer';

    protected $fillable = [
        'ISBN',
        'publisherID',
        'year',
        'tittle',
    ];

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function circulated_books()
    {
        return $this->hasMany(CirculatedBook::class, 'BooksISBN', 'ISBN');
    }
}
