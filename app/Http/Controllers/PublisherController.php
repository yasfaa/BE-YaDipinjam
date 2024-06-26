<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publisher;

class PublisherController extends Controller
{
    public function store($name) {
        try {
            $author = Publisher::create([
                "name" => $name
            ]);
            return $author->id;
        } catch (\Throwable $th) {
            return null;
        }
    }
    public function create(Request $request) {
        try {
            $pub = Publisher::create([
                "name" => $request->input("name")
            ]);
            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $pub
            ], 200);
        } catch (\Exceptions $exceptions) {
            return response()->json([
                "code" => 500,
                "message" => "fail",
                "error" => $exceptions
            ], 500);
        }
    }
    public function get(Request $request, $name = null) {
        try {
            if ($request->has('name')) {
                $payload = $request->query('name');
                $data = Publisher::where('name', $payload)->first();
            } elseif ($name !== null) {
                $data = Publisher::where('name', $name)->first();
            } else {
                // Handle case where both $request and $name are null
                throw new \InvalidArgumentException("No name parameter provided.");
            }

            if ($data) {
                return response()->json([
                    "code" => 200,
                    "message" => "success",
                    "data" => $data
                ], 200);
            } else {
                return response()->json([
                    "code" => 404,
                    "message" => "Not found",
                ], 404);
            }
        } catch (\Exception $exception) {
            return response()->json([
                "code" => 500,
                "message" => "fail",
                "error" => $exception->getMessage()
            ], 500);
        }
    }
    public function getID($name) {
        try {
            $data = Publisher::where('name', $name)->first();
            if ($data) {
                return $data->id;
            } else {
                return null;
            }
        } catch (\Throwable $th) {
            return null;
        }
    }
}
