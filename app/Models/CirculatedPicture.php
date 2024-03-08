<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CirculatedPicture extends Model
{
    use HasFactory;

    protected $fillable = [
        'Circulated_BookID',
        'path',
    ];

    public function circulatedBook()
    {
        return $this->belongsTo(CirculatedBook::class);
    }
}
