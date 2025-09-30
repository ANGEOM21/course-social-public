<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use LaravelSocialite\GoogleOneTap\LaravelGoogleOneTapServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;

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
        Event::listen(function (SocialiteWasCalled  $event) {
            $event->extendSocialite('laravel-google-one-tap', LaravelGoogleOneTapServiceProvider::class);
        });

        Blade::anonymousComponentPath(resource_path('views/livewire/components'), 'components');

        // Set Global variables
        view()->share([
            'app_name' => str_replace('_', ' ', config('app.name')) ?? 'Project-Web',
            'logo' => asset('logo.png'),
        ]);
    }
}
