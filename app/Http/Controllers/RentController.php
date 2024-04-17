<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Models\CirculatedBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RentController extends Controller
{
    public function lend(Request $request)
    {
        $user = Auth::id();
        try {

        } catch (\Exceptions $exceptions) {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function confirmation(Request $request)
    {
        $user = Auth::id();
        try {

        } catch (\Exceptions $exceptions) {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    /*
    this code bellow is implementing logic for a user to borrow a circulated book
    responsible for balance checking, create rent entity, change the status of circulated book

    data flow:
    get renter id, check if it's not their own book
    get renter balance, check whether balance >= price
    create rent entity, with start data is today, and end day is today + rent days (default 7 days)
    change the circulated book status to borrowed
    subtract renter balance with price of circulated book


    renter
    owner

    owner have book, book have price
    when renter want ot rent, check renter balance
    if balance >= price, ok

    */
    public function borrow(Reqeust $request)
    {
        $user = Auth::user();

        try {
            $reqeust
            if ($user) {
                # code...
            }
            $rent = Rent::create([
                "userID" => $user,

            ]);
        } catch (\Exceptions $exceptions) {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
}
