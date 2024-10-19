<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id')->toArray();
        $companies = Company::pluck('company_name', 'id')->toArray();

        return view('users.create', compact('roles', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|numeric',
            'company_id' => 'required|numeric'
        ]);

        DB::transaction(function () use ($valid) {
            $user = User::create($valid);
            $role = Role::findById($valid['role']);
            $user->syncRoles($role);
        });


        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'id')->toArray();
        $companies = Company::pluck('company_name', 'id')->toArray();
        $user->load('roles');
        return view('users.edit', compact('user', 'roles', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $valid = $request->validate([
            'name' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|numeric',
            'company_id' => 'required|numeric'
        ]);

        if (is_null($valid['password'])) {
            unset($valid['password']);
        }

        DB::transaction(function () use ($user, $valid) {
            $role = Role::findById($valid['role']);
            $user->update($valid);
            $user->syncRoles($role);
        });

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect(route('users.index'));
    }
}
