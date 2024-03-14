<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    public function createBook(Request $request)
    {
        $request->validate([
            'ISBN' => 'required|unique:books',
            'publisherID' => 'required',
            'authorID' => 'required',
            'year' => 'required|numeric',
            'tittle' => 'required',
        ]);

        $existingBook = Book::where('ISBN', $request->ISBN)->first();

        if ($existingBook) {
            return response()->json(['message' => 'Book already exists'], 400);
        }

        $bookData = Http::get('xxx.com/getBook' . $request->xxxx)->json();

        $created = Book::create([
            'ISBN' => $request->ISBN,
            'publisherID' => $request->publisherID,
            'authorID' => $request->authorID,
            'year' => $request->year,
            'tittle' => $request->tittle,
        ]);
    }
}