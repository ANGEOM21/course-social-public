<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google login gagal: ' . $e->getMessage());
        }

        $user = User::updateOrCreate(
            ['email_user' => $googleUser->getEmail()],
            [
                'name_user' => $googleUser->getName(),
                'img_user' => $googleUser->getAvatar(),
                'role_user' => 'student'
            ]
        );

        Auth::login($user);

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        Auth::logout();

        return redirect()->route('landing');
    }

    public function profile(Request $request)
    {
        return view('profile', ['user' => $request->user()]);
    }
}
