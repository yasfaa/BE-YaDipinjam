<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookAuthor;

class BookAuthorController extends Controller
{
    public function store($ISBN, $author) {
        try {
            $data = BookAuthor::create([
                "book_ISBN" => $ISBN,
                "author_ID" => $author,
            ]);

            return $data;
        } catch (\Exceptions $exceptions) {
            return $exceptions;
        }
    }
    public function create(Request $request) {
        try {
            $data = BookAuthor::create([
                "book_ISBN" => $request->input("ISBN"),
                "author_ID" => $request->input("ISBN"),
            ]);

            return response()->json([
                "code" => 200,
                "message" => "created",
                "data" => $data
            ]);
        } catch (\Exceptions $exceptions) {
            return response()->json([
                "code" => 500,
                "message" => "fail",
                "error" => $exceptions
            ], 500);
        }
    }
}
