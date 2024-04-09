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

    public function fetchBook(Request $request = null, $ISBN = null)
    {
        if ($request != null && $ISBN == null) {
            $reqISBN = $request->input('ISBN');
            $url = 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $reqISBN;
        } elseif ($request == null && $ISBN != null) {
            $url = 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $ISBN;
        } elseif ($request == null && $ISBN == null) {
            return response()->json([
                "code" => 400,
                "message" => "Bad Request: Please only passing one data."
            ], 400);
        }
        try {
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json();

                return response()->json([
                    "code" => 200,
                    "message" => "success",
                    "data" => $data
                ],200);
            } else {
                return response()->json([
                    "code" => 404,
                    "message" => "Error fetching book data"
                ],404);
            }
        } catch (\Throwable $e) {
            return response()->json([
                "code" => 500,
                "message" => "Internal Server Error"
            ]);
        }
    }
    public function getByISBN(Request $request)
    {
        try {
            $ISBN = $request->query('ISBN');
            $book = Book::where('ISBN', $ISBN)->firstOrFail();

            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $book
            ]);
        } catch (\Excaption $exceptions) {
            return response()->json([
                "code" => 500,
                "message" => "fail",
                "error" => $exceptions
            ], 500);
        }
    }
}
