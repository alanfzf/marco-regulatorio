<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {

        $valid = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($valid)) {
            return redirect(route('home'))->with('Bienvenido');
        }

        return redirect(route('login'))
            ->withErrors(['auth' => 'Wrong credentials']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }

}
