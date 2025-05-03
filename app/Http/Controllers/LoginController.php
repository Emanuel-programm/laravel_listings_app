<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\View\View;
use illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // @desc show login form
    // @route Get /login
    public function login(): View
    {
        return view('auth.login');
    }

    // @desc Authenticate user
    // @route POST /login
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|string|email|max:100',
            'password' => 'required|string'
        ]);

        // Attempt to authentificate user
        if (Auth::attempt($credentials)) {
            //   Regenerate the session to prevebt fixation attack
            $request->session()->regenerate();

            return redirect()->intended(route('home'))->with('success', 'Your are now logged in!');
        }
        // if auth fail, redirect back with error
        return back()->withErrors([
            'email' => 'The provide credentials do not match our records'
        ])->onlyInput('email');
    }

    // @desc logout user
    //  @route POST /logout
    public function logout(Request $request): RedirectResponse
    {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logout successfuly!');
    }
}
