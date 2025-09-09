<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'photo_url' => $user->photo ? asset('storage/profile_photos/' . $user->photo) : null,
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'photo' => 'nullable|image|max:2048', // max 2MB
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('photo')) {
            // Supprimer l’ancienne photo si elle existe
            if ($user->photo && Storage::exists('public/profile_photos/' . $user->photo)) {
                Storage::delete('public/profile_photos/' . $user->photo);
            }

            $photo = $request->file('photo');
            $filename = 'profile_' . $user->id . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('public/profile_photos', $filename);

            $user->photo = $filename;
        }

        $user->save();

        return response()->json([
            'message' => 'Profil mis à jour avec succès.',
            'photo_url' => $user->photo ? asset('storage/profile_photos/' . $user->photo) : null,
        ]);
    }
}
