<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; // Standard Role for auth
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $organizer = $request->user()->organizer_profile;
        if (!$organizer) abort(403);

        return response()->json(
            $organizer->collaborators
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:admin,editor,staff'
        ]);

        $organizer = $request->user()->organizer_profile;
        if (!$organizer) abort(403);

        // Find or Create User
        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => explode('@', $request->email)[0],
                'password' => Hash::make(Str::random(16)), // Temp password
            ]
        );

        // Ensure user has generic 'organizer' role capability so they can access the panel
        $organizerRole = Role::where('slug', 'organizer')->first();
        if ($organizerRole && !$user->roles()->where('slug', 'organizer')->exists()) {
            $user->roles()->attach($organizerRole);
        }

        // Add to team
        if (!$organizer->collaborators()->where('user_id', $user->id)->exists()) {
            $organizer->collaborators()->attach($user->id, [
                'role' => $request->role,
                'is_active' => true
            ]);
        }

        return response()->json(['message' => 'Collaborator added', 'user' => $user]);
    }

    public function destroy(Request $request, $userId)
    {
        $organizer = $request->user()->organizer_profile;
        if (!$organizer) abort(403);

        $organizer->collaborators()->detach($userId);

        return response()->json(['message' => 'Collaborator removed']);
    }
}
