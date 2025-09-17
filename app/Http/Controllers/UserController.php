<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Tampilkan halaman profil user login
     */
    public function profile()
    {
        $user = Auth::user(); // ambil user yang sedang login
        return view('profile', compact('user'));
    }

    /**
     * Update profil user login
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name_user' => 'required|string|max:255',
            'email_user' => 'required|email|unique:tbl_user,email_user,' . $user->id_user . ',id_user',
            'img_user'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update data user
        $user->name_user = $request->name_user;
        $user->email_user = $request->email_user;

        // Upload gambar jika ada
        if ($request->hasFile('img_user')) {
            $path = $request->file('img_user')->store('profile_images', 'public');
            $user->img_user = $path;
        }

        $user->save();

        return redirect()->route('profile')
                         ->with('success', 'Profil berhasil diperbarui.');
    }
}
