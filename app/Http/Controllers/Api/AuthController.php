<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'in:user,organizer', // Admin created manually
            // Organizer specific
            'organizer_name' => 'required_if:role,organizer|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 'role' => $request->role ?? 'user', // Deprecated
        ]);

        // Assign 'Organizer' Role by default as requested
        $organizerRole = \App\Models\Role::where('slug', 'organizer')->first();
        if ($organizerRole) {
            $user->roles()->attach($organizerRole);
        }

        // Create Organizer Profile (Even if basic user, they get the capability)
        // If the user provided organizer_name use it, otherwise use their name
        Organizer::create([
            'user_id' => $user->id,
            'name' => $request->organizer_name ?? $user->name,
            'contact_email' => $user->email,
        ]);

        // Logic for specific "Organizer" input removed since EVERYONE is an organizer now

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user->load('organizer_profile'),
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user->load('organizer_profile'),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function me(Request $request)
    {
        return $request->user()->load('organizer_profile');
    }
}
