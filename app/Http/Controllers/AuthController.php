<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:6',
            ]);

            $validated['password'] = bcrypt($validated['password']);
            $user = User::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
                'data' => $user,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'data' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred during registration',
                'data' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        $token = JWTAuth::attempt($credentials);


        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
                'data' => null,
            ], 401);
        }

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'data' => [
                'token' => $token,
            ],
        ]);
    }
}
