<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'user_name' => 'required|string|max:50',
            'user_surname' => 'required|string|max:50',
            'id_number' => 'required|string|max:20',
            'email' => 'required|string|email|max:50|unique:users',
            'contact_number' => 'required|string|max:15',
            'date_of_birth' => 'required|date',
            'user_gender' => 'required|string|max:10',
            'user_nationality' => 'required|string|max:50',
        ]);

        $user = User::create([
            'username' => $validatedData['username'],
            'password' => Hash::make($validatedData['password']),
            'user_name' => $validatedData['user_name'],
            'user_surname' => $validatedData['user_surname'],
            'id_number' => $validatedData['id_number'],
            'email' => $validatedData['email'],
            'contact_number' => $validatedData['contact_number'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'user_gender' => $validatedData['user_gender'],
            'user_nationality' => $validatedData['user_nationality'],
            'account_active' => true, // Auto-activate for now
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 201);
    }

    /**
     * Login user and create token.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (!$user->account_active) {
            return response()->json(['message' => 'Account is inactive.'], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    /**
     * Logout user (Revoke the token).
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User.
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
