<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use illuminate\View\View;
use illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    // @desc show register form
    // @route Get /register
    public function register(): View
    {
        return view('auth.register');
    }


    // @desc store user in database
    // @route POST /register
    public function store(Request $request): RedirectResponse
    {
        $validateData = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        // Hash the password
        $validateData['password'] = Hash::make($validateData['password']);

        // create the user
        $user = User::create($validateData);

        return redirect()->route('login')->with('success', 'You are registred now you can login');
    }
}
