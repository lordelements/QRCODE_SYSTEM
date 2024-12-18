<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class AdminController extends Controller
{
    /**
     * Display the admin profile information.
     */
    public function profileinfo(Request $request): View
    {
        return view('admin.profile.profile_info');
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('admin.profile.edit', [
            'user' => $request->user(),

        ]);
    }

    public function updateinfo(Request $request): View
    {
        return view('admin.profile.partials.update-profile-information-form');
    }


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Update other profile details
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if ($request->user()->profile_picture && Storage::disk('public')->exists($request->user()->profile_picture)) {
                Storage::disk('public')->delete($request->user()->profile_picture);
            }

            // Save the new profile picture
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $request->user()->profile_picture = $path;
        }

        // Save the user with updated information
        $request->user()->save();

        return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    /**
     * Delete the Registered user's account.
     */
    public function deleteRegisteredUser($id)
    {
        // Find the QR code record in the database
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('status', 'Registered users account has been deleted successfully.');

    }

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(5);
        $total_users  = User::count();
        return view('admin.users.index', compact('users', 'total_users'));
    }
}
