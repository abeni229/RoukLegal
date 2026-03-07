<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('settings.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'. $user->id,
            'profile_photo' => 'nullable|image|max:15360',
            'remove_photo' => 'nullable|boolean',
            'theme' => 'required|in:light,dark',
        ]);

        $user->nom = $data['nom'];
        $user->email = $data['email'];

        // handle profile photo upload or removal
        if ($request->has('remove_photo') && $request->remove_photo) {
            if ($user->profile_photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_photo);
            }
            $user->profile_photo = null;
        }
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $user->profile_photo = $path;
        }

        $user->theme = $data['theme'];
        $user->save();

        return redirect()->route('settings.edit')->with('status', 'Paramètres mis à jour');
    }

    public function destroy()
{
    $user = Auth::user();
    Auth::logout();
    $user->delete();
    return redirect()->route('login')->with('status', 'Votre compte a été supprimé.');
}

}
