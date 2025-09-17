<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Redirect otomatis berdasarkan role
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role_user === 'mentor') {
            return redirect()->route('mentor.dashboard');
        }

        if ($user->role_user === 'student') {
            return redirect()->route('student.dashboard');
        }

        return redirect()->route('landing')->with('error', 'Role tidak dikenali.');
    }

    /**
     * Dashboard Student
     */
    public function student()
    {
        $user = Auth::user();
        $courses = $user->courses; // kursus yang diikuti student

        return view('student.dashboard', compact('courses'));
    }

    /**
     * Dashboard Mentor
     */
    public function mentor()
    {
        $user = Auth::user();
        $courses = $user->createdCourses; // kursus yang dibuat mentor

        return view('mentor.dashboard', compact('courses'));
    }
}
