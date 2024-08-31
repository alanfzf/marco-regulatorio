<?php

namespace App\Http\Controllers;

use App\Models\Law;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TeamController extends Controller
{
    public function __construct()
    {
    }

    public function show(Request $request)
    {
        $user = $request->user();
        $laws = $user->laws;

        return view('teams.show', compact('laws'));
    }

    public function users(Law $law, Request $request)
    {
        $lawManagers = $law->managers()->pluck('user_id')->toArray();
        $users = User::with('roles')
            ->where('id', '!=', $request->user()->id)
            ->get()
            ->map(function ($user) use ($lawManagers) {
                $user->is_part_of_law = in_array($user->id, $lawManagers);
                return $user;
            });

        return view('teams.users', compact('law', 'users'));
    }

    public function update(Law $law, Request $request)
    {
        $valid = $request->validate([
            'team_users' => 'nullable|array',
        ]);
        $members = array_keys($valid['team_users'] ?? []);
        // add back the current user
        $members[] = $request->user()->id;

        $law->managers()->sync($members);

        return redirect(route('teams.show'));
    }
}
