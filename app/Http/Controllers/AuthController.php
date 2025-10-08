<?php

namespace App\Http\Controllers;

use App\Models\TblStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use LaravelSocialite\GoogleOneTap\Exceptions\InvalidIdTokenException;
use Masmerise\Toaster\Toastable;

class AuthController extends Controller
{
    use Toastable;
    public function redirectToGoogle(Request $req)
    {
        $req->session()->put('oauth_via_popup', $req->boolean('popup'));

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            /** @var \Laravel\Socialite\Two\User $googleUser */
            $googleUser = Socialite::driver('google')->user();

            $email = $googleUser->getEmail();
            if (!$email) {
                // Handle kasus di mana Google tidak mengembalikan email
                throw new \Exception('Google tidak memberikan akses email.');
            }

            // Cari pengguna berdasarkan email, atau buat instance baru jika tidak ada
            $user = TblStudent::firstOrNew(['email_student' => $email]);

            // Cek apakah pengguna ini baru dibuat (belum ada di database)
            if (!$user->exists) {
                // Jika BARU, isi semua data awal
                $user->name_student = $googleUser->getName() ?: 'Siswa Baru';
                $user->img_student = $googleUser->getAvatar();
            }

            // SELALU update token dan informasi sesi, baik pengguna baru maupun lama
            $user->access_token_student = $googleUser->token;
            $user->save();

            // Login-kan pengguna
            Auth::guard('web')->login($user, true);

            if (session()->pull('oauth_via_popup', false)) {
                $origin = url('/');
                return response(
                    '<script>
                    if (window.opener) {
                        window.opener.postMessage({ type:"oauth", provider:"google", ok:true }, "' . $origin . '");
                        window.close();
                    } else {
                        location = "' . route('student.dashboard') . '";
                    }
                    </script>',
                    200,
                    ['Content-Type' => 'text/html']
                );
            }

            return redirect()->intended(route('student.dashboard'))->with('success', 'Selamat datang kembali, ' . $user->name_student);
        } catch (\Exception $e) {
            Log::error('[Google OAuth Callback] ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            // Logika response error untuk popup (sudah benar)
            if (session('oauth_via_popup')) {
                $origin = url('/');
                return response(
                    '<script>
                    if (window.opener) {
                        window.opener.postMessage({ type:"oauth", provider:"google", ok:false }, "' . $origin . '");
                        window.close();
                    } else {
                        location = "' . route('landing.index') . '";
                    }
                    </script>',
                    200,
                    ['Content-Type' => 'text/html']
                );
            }

            return redirect()->route('landing.index')->with('error', 'Terjadi kesalahan saat login dengan Google. Silakan coba lagi.');
        }
    }

    public function googleOneTap(Request $request)
    {
        try {
            $googleUser = Socialite::driver('laravel-google-one-tap')->userFromToken($request->input('credential'));
        } catch (\Exception $exception) {
            Log::error("Google One Tap Login Failed: " . $exception->getMessage());
            return response()->json(['error' => 'Google authentication failed'], 400);
        }

        // Find existing user or create a new one
        $user = TblStudent::firstOrNew(['email_student' => $googleUser->getEmail()]);

        if (!$user->exists) {
            $user->name_student = $googleUser->getName();
            $user->password_student = bcrypt($googleUser->getId());
            $user->img_student = $googleUser->getAvatar();
            $user->access_token_student = $googleUser->token ?? null;
            $user->save();
        }

        // Ensure user_id exists
        if (!$user->id_student) {
            Log::error("Google One Tap Error: user_id is null for email: " . ($googleUser->getEmail() ?? 'unknown'));
            return response()->json(['error' => 'User not found or not created'], 400);
        }


        // Log in the user
        Auth::login($user, true);

        return redirect()->route('student.dashboard')->success('Selamat datang, ' . $user->name_student);
    }
}
