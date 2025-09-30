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
    // Redirect ke Google
    public function redirectToGoogle(Request $req)
    {
        // tandai kalau via popup
        $req->session()->put('oauth_via_popup', $req->boolean('popup'));

        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->with(['prompt' => 'select_account']) // opsional
            ->redirect();
    }


    // Callback dari Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->scopes(['openid', 'profile', 'email'])
                ->user();

            $email = $googleUser->getEmail();
            if (!$email) {
                return redirect()->route('landing.index')->with('error', 'Google tidak mengembalikan email.');
            }

            $user = TblStudent::updateOrCreate(
                ['email_student' => $email],
                [
                    'name_student'          => $googleUser->getName() ?: 'Student',
                    'img_student'           => $googleUser->getAvatar(),
                    'access_token_student'  => $googleUser->token ?? null,
                    'refresh_token_student' => property_exists($googleUser, 'refreshToken') ? $googleUser->refreshToken : null,
                    'token_expires_at'      => property_exists($googleUser, 'expiresIn') && $googleUser->expiresIn
                        ? now()->addSeconds($googleUser->expiresIn) : null,
                ]
            );

            // pake guard student kalau ada
            Auth::guard()->login($user, true);

            // kalau dipanggil via popup -> kirim postMessage & tutup
            if (session()->pull('oauth_via_popup', false)) {
                $origin = url('/');
                return response(
                    '<script>
                   if (window.opener) {
                     window.opener.postMessage({type:"oauth",provider:"google",ok:true},"' . $origin . '");
                     window.close();
                   } else {
                     location = "' . route('student.dashboard') . '";
                   }
                 </script>',
                    200,
                    ['Content-Type' => 'text/html']
                );
            }

            return redirect()->route('student.dashboard')->with('success', 'Selamat datang, ' . $user->name_student);
        } catch (\Throwable $e) {
            Log::error('[Google OAuth] ' . $e->getMessage());
            if (session('oauth_via_popup')) {
                $origin = url('/');
                return response(
                    '<script>
                   if (window.opener) {
                     window.opener.postMessage({type:"oauth",provider:"google",ok:false},"' . $origin . '");
                     window.close();
                   } else { location = "' . route('landing.index') . '"; }
                 </script>',
                    200,
                    ['Content-Type' => 'text/html']
                );
            }
            return redirect()->route('landing.index')->with('error', 'Login gagal, coba lagi.');
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

        return redirect()->route('student.dashboard')->success( 'Selamat datang, ' . $user->name_student);
    }
}
