<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'username' => 'required'
        ]);

        $created = User::create([
            'email' => $request->email,
            'password' => $request->password,
            'username' => $request->username,
            'role' => 'User'
        ]);

        if ($created) {
            return response()->json([
                'message' => 'Successfuly register!'
            ], 201);
        } else {
            return response()->json([
                'message' => 'Server error'
            ], 500);
        }
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }
        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'role' => $user->role,
            'username' => $user->username,
        ]);
    }

    function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out!'
        ], 200);
    }

    public function getRole()
    {
        try {
            $user = Auth::user();

            return $user->role;
        } catch (\Throwable $th) {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

}
