<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfireController extends Controller
{

    // @desc update profile info
    // @route PUT /Profile
    public function update(Request $request): RedirectResponse
    {
        // Get the logged in  user
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // validated data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048'
        ]);



        // get user name and email
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exist
            if ($user->avatar) {
                Storage::delete('public/' . $user->avatar);
            }
            // Store new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        // update user Info



        $user->save();
        // dd($saved);

        return redirect()->route('dashboard')->with('success', 'Profile info updated');
    }
}
