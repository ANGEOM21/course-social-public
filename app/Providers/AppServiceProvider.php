<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
        //     $message = new MailMessage();
        //     return $message->subject('Verify Email Address')->view('mail.verify-email', [
        //         'url' => $url,
        //         'subject' => 'Verify Email Address',
        //         'name' => $notifiable?->name ?? 'User',
        //     ]);
        // });

        // // Customize Paswword Reset ui
        // ResetPassword::toMailUsing(function (User $notifiable, string $token) {
        //     $name_user = $notifiable->full_name ?? $notifiable->username ?? 'User';
        //     $url = URL::temporarySignedRoute('auth.password.reset', now()->addMinutes(60), ['token' => $token]);
        //     $message = new MailMessage();
        //     return $message->subject('Reset Password')->view('mail.password-reset', [
        //         'url' => $url,
        //         'subject' => 'Reset Password',
        //         'name' => $name_user,
        //     ]);
        // });

        Blade::anonymousComponentPath(resource_path('views/livewire/components'), 'components');

        // Set Global variables
        view()->share([
            'app_name' => str_replace('_', ' ', config('app.name')) ?? 'Project-Web',
            'logo' => asset('logo.png'),
        ]);
    }
}
