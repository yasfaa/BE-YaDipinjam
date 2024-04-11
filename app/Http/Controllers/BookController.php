<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CirculatedBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookAuthorController;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /*
    Flow of the data in book domain

    User upload their book, the book will be created if there's no record of that book in database.
    App will looking ISBN to the google books api,
    if the book data is exist in google api, fetch the api and insert it into database.
    If the book ISBN not exist in google api, insert the data from user instead.
    The author and publisher of the book will be checked before storing the book
    if author and publisher exist, get the id's. if not, create and get the id's.
    after all of that is complete, create the book entity.

    the google api will return array of string for author.
    do for loop to create the author according to the array length,
    create the book_authors with ISBN and list of authors id

    After making sure book's exist, store the circulated_book to the correspond user with status to unavailable.

    */

    //this code bellow will store book data into book, and act as master data
    public function createBook(Request $request = null, $ISBN = null, $publisher = null, $author = null, $year = null, $title = null)
    {
        $PublisherController = new PublisherController();
        $AuthorController = new AuthorController();
        $BookAuthorController = new BookAuthorController();

        if ($request && $ISBN && $publisher && $author && $year && $title) {
            return response()->json([
                "code" => 400,
                "message" => "too much argument provided"
            ], 400);
        }

        elseif ($request !== null) {
            // Handle the case where only $request is provided

            $request->validate([
                'ISBN' => 'required|unique:books'
            ]);
            $ISBN = $request->input('ISBN');

            $existingBook = Book::where('ISBN', $ISBN)->first();

            if ($existingBook) {
                return response()->json([
                    "code" => 400,
                    "message" => "Book already exists"
                ], 400);
            }
            try {
                DB::beginTransaction();
                $bookData = $this->fetchBook(null, $ISBN);
                $totalItems = $bookData->getData()->data->totalItems;
                $publisher = $bookData->getData()->data->items[0]->volumeInfo->publisher;
                $author = $bookData->getData()->data->items[0]->volumeInfo->authors;
                $dateString = $bookData->getData()->data->items[0]->volumeInfo->publishedDate;
                $title = $bookData->getData()->data->items[0]->volumeInfo->title;

                $publisherID = $PublisherController->getID($publisher);
                $year = substr($dateString, 0, 4);

                if(!$publisherID){
                    $publisherID = $PublisherController->store($publisher);
                }

                if($totalItems > 0) {
                    // books found in google api
                    $created = Book::create([
                        'ISBN' => $ISBN,
                        'publisherID' => $publisherID,
                        'year' => $year,
                        'tittle' => $title,
                    ]);
                    //loop to store author and bookAuthor
                    for ($i=0; $i < count($author); $i++) {
                        $authorID = $AuthorController->getID($author[$i]);
                        if (!$authorID) {
                            $createdAuthorID = $AuthorController->store($author[$i]);
                            $BookAuthorController->store($created->ISBN,$createdAuthorID);
                            echo($createdAuthorID);
                        } else {
                            $BookAuthorController->store($created->ISBN,$authorID);
                            echo($authorID);
                        }
                    }
                } else {
                    // books not found in google api
                    $created = Book::create([
                        'ISBN' => $request->ISBN,
                        'publisherID' => $request->publisherID,
                        'authorID' => $request->authorID,
                        'year' => $request->year,
                        'tittle' => $request->tittle,
                    ]);
                }
                DB::commit();
                return response()->json([
                    "code" => 200,
                    "message" => "success",
                    "data" =>  $created
                ], 200);
            }
            catch (\Exceptions $exceptions) {
                DB::rollback();
                return response()->json([
                    "code" => 500,
                    "message" => "Internal Server Error",
                    "error" => $exceptions
                ], 500);
            }
        }

        elseif ($ISBN !== null || $publisher !== null || $author !== null || $year !== null || $title !== null) {
            // Handle the case when http request not provided
            $existingBook = Book::where('ISBN', $ISBN)->first();

            if ($existingBook) {
                return response()->json([
                    "code" => 400,
                    "message" => "Book already exists"
                ], 400);
            }
            try {
                DB::beginTransaction();
                $bookData = $this->fetchBook(null, $ISBN);
                $totalItems = $bookData->getData()->data->totalItems;
                $publisher = $bookData->getData()->data->items[0]->volumeInfo->publisher;
                $author = $bookData->getData()->data->items[0]->volumeInfo->authors;
                $dateString = $bookData->getData()->data->items[0]->volumeInfo->publishedDate;
                $title = $bookData->getData()->data->items[0]->volumeInfo->title;

                $publisherID = $PublisherController->getID($publisher);
                $year = substr($dateString, 0, 4);

                if(!$publisherID){
                    $publisherID = $PublisherController->store($publisher);
                }

                if($totalItems > 0) {
                    // books found in google api
                    $created = Book::create([
                        'ISBN' => $ISBN,
                        'publisherID' => $publisherID,
                        'year' => $year,
                        'tittle' => $title,
                    ]);
                    //loop to store author and bookAuthor
                    for ($i=0; $i < count($author); $i++) {
                        $authorID = $AuthorController->getID($author[$i]);
                        if (!$authorID) {
                            $createdAuthorID = $AuthorController->store($author[$i]);
                            $BookAuthorController->store($created->ISBN,$createdAuthorID);
                            echo($createdAuthorID);
                        } else {
                            $BookAuthorController->store($created->ISBN,$authorID);
                            echo($authorID);
                        }
                    }
                } else {
                    // books not found in google api
                    $created = Book::create([
                        'ISBN' => $ISBN,
                        'publisherID' => $publisher,
                        'authorID' => $author,
                        'year' => $year,
                        'tittle' => $title,
                    ]);
                }
                DB::commit();
                return response()->json([
                    "code" => 200,
                    "message" => "success",
                    "data" =>  $created
                ], 200);
            }
            catch (\Exceptions $exceptions) {
                DB::rollback();
                return response()->json([
                    "code" => 500,
                    "message" => "Internal Server Error",
                    "error" => $exceptions
                ], 500);
            }
        }

        else {
            return response()->json([
                "code" => 400,
                "message" => "provided no argument, need 1 argument"
            ], 400);
        }
    }

    //this upload is storing the data into circulated book correspond to the user that upload
    public function upload(Request $request)
    {
        $ISBN = $request->input('ISBN');
        $description = $request->input('description');
        $price = $request->input('price');
        $book = $this->getByISBN(null,$ISBN);

        $isBookExist = true;
        if ($book->getStatusCode() == 500) {
            $isBookExist = false;
        }

        try {
            $user = Auth::id();

            if (!$user) {
                return response()->json([
                    "code" => 401,
                    "status" => "unauthorized",
                    "message" => "You are not authorized to access this resource."
                ], 401);
            }
            // Check if the book already exists
            if ($isBookExist) {
                $data = CirculatedBook::create([
                    "BooksISBN" => $ISBN,
                    "description" => $description,
                    "price" => $price,
                    "status" => "available",
                    "userID" => $user
                ]);
            } else {
                // Create book entity if it doesn't exist
                $bookEntity = $this->createBook(null,$ISBN);
                // Create circulated book
                $data = CirculatedBook::create([
                    "BooksISBN" => $ISBN,
                    "description" => $description,
                    "price" => $price,
                    "status" => "available",
                    "userID" => $user
                ]);
            }
            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $data
            ],200);

        } catch (\Exceptions $exceptions) {
            return response()->json([
                "code" => 500,
                "message" => "Internal Server Error"
            ],500);
        }
    }
    public function fetchBook(Request $request = null, $ISBN = null)
    {
        if ($request != null && $ISBN == null) {
            $reqISBN = $request->input('ISBN');
            $url = 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $reqISBN;
        } elseif ($request == null && $ISBN != null) {
            $url = 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $ISBN;
        } elseif ($request != null && $ISBN != null) {
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

    public function getByTitle(Request $request)
    {
        try {
            $title = $request->query('title');
            $book = Book::where('tittle', $title)->firstOrFail();

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
    public function getByISBN(Request $request = null, $ISBN = null)
{
    try {
        // If $ISBN is not provided as a parameter, try to get it from the request
        if (!$ISBN && $request) {
            $ISBN = $request->query('ISBN');
        }

        // If $ISBN is still not available, return a response indicating bad request
        if (!$ISBN) {
            return response()->json([
                "code" => 400,
                "message" => "Bad request: ISBN is required"
            ], 400);
        }

        // Find the book with the provided ISBN
        $book = Book::where('ISBN', $ISBN)->firstOrFail();

        return response()->json([
            "code" => 200,
            "message" => "success",
            "data" => $book
        ]);
    } catch (\Exception $exception) {
        // Handle exceptions
        return response()->json([
            "code" => 500,
            "message" => "fail",
            "error" => $exception->getMessage()
        ], 500);
    }
}

}
