<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthViewController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => [
                'required',
                'email'
            ],

            'password' => [
                'required'
            ],
        ]);

        if (
            Auth::attempt($validated)
        ) {

            $request->session()
                ->regenerate();

            return redirect(
                '/ui/dashboard'
            );
        }

        return back()
            ->withErrors([
                'email' =>
                    'Invalid credentials'
            ])
            ->withInput();
    }

    public function register(Request $request)
    {
        $validated =
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255'
                ],

                'email' => [
                    'required',
                    'email',
                    'unique:users,email'
                ],

                'password' => [
                    'required',
                    'min:8'
                ],
            ]);

        $user = User::create([
            'name' =>
                $validated['name'],

            'email' =>
                $validated['email'],

            'password' =>
                Hash::make(
                    $validated['password']
                ),
        ]);

        Auth::login($user);

        return redirect(
            '/ui/dashboard'
        );
    }

    public function logout(
        Request $request
    )
    {
        Auth::logout();

        $request->session()
            ->invalidate();

        $request->session()
            ->regenerateToken();

        return redirect('/login');
    }
}