<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class AuthController extends Controller
{
    // === Redirect ke Google ===
    public function redirectToGoogle($role)
    {
        // simpan role ke session
        session(['login_role' => $role]);

        return Socialite::driver('google')->redirect();
    }

    // === Callback dari Google ===
    // === Callback dari Google ===
public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Ambil role dari session, default student
        $role = session('login_role', 'student');

        // Cek apakah user sudah ada
        $user = User::where('email_user', $googleUser->getEmail())->first();

        if (!$user) {
            // === USER BARU ===
            $user = User::create([
                'name_user'         => $googleUser->getName(),
                'email_user'        => $googleUser->getEmail(),
                'img_user'          => $googleUser->getAvatar(),
                'role_user'         => $role, // sesuai tombol login
                'access_token_user' => $googleUser->token,
            ]);
        } else {
            // === USER LAMA ===
            // Update data dasar
            $user->update([
                'name_user'         => $googleUser->getName(),
                'img_user'          => $googleUser->getAvatar(),
                'access_token_user' => $googleUser->token,
            ]);

            // Kalau role berbeda dengan session login, update role
            if ($user->role_user !== $role) {
                $user->update(['role_user' => $role]);
            }
        }

        // Login ke aplikasi
        Auth::login($user);

        // Redirect sesuai role
        if ($user->role_user === 'mentor') {
            return redirect()->route('mentor.dashboard')->with('success', 'Login sebagai Mentor');
        }

        return redirect()->route('student.dashboard')->with('success', 'Login sebagai Student');

    } catch (\Exception $e) {
        return redirect()->route('landing')->with('error', 'Login gagal, coba lagi.');
    }
}


    // === Logout ===
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
