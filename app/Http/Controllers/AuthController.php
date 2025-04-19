<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            if ($user->role === 'admin') {
                return redirect('/admin');
            } elseif ($user->role === 'vendedor') {
                return redirect('/vendedor');
            } elseif ($user->role === 'bodeguero') {
                return redirect('/bodeguero');
            } else {
                return redirect('/dashboard');
            }
        }

        return back()->with('error', 'Credenciales inválidas');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}

