<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publisher;

class PublisherController extends Controller
{
    public function create(Request $request) {
        try {
            Publisher::create([
                "name" => $request->input("name")
            ]);
        } catch (\Exceptions $exceptions) {
            return response()->json([
                "code" => 500,
                "message" => "fail",
                "error" => $exceptions
            ], 500);
        }
    }
    public function get(Request $request, $name) {
        // $payload = $request->input('name');
        try {
            Publisher::where('name', $name)->first;
        } catch (\Throwable $th) {
            return response()->json([
                "code" => 500,
                "message" => "fail",
                "error" => $exceptions
            ], 500);
        }
    }
}
