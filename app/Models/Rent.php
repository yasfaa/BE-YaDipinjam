<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    protected $fillable = [
        'userID',
        'Circulated_BookID',
        'start_date',
        'end_date',
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
