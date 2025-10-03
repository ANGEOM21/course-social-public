<?php

namespace App\Http\Controllers\Auth\Admin\Utils;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke(): void
    {
        Auth::guard('admins')->logout();
        Session::invalidate();
        Session::regenerateToken();
    }
}
