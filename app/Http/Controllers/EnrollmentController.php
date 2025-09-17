<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;
use App\Models\Course;

class EnrollmentController extends Controller
{
    /**
     * Daftar ke kursus
     */
    public function enroll($courseId)
    {
        $userId = Auth::id();

        // Cek apakah user sudah daftar
        $check = Enrollment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->first();

        if ($check) {
            return redirect()->back()->with('info', 'Anda sudah terdaftar di kursus ini.');
        }

        Enrollment::create([
            'user_id'   => $userId,
            'course_id' => $courseId,
        ]);

        return redirect()->route('my.courses')->with('success', 'Berhasil mendaftar kursus!');
    }

    /**
     * Lihat daftar kursus saya
     * (student = kursus yang diikuti, mentor = kursus yang dibuat)
     */
    public function myCourses()
    {
        $user = Auth::user();

        if ($user->role_user === 'mentor') {
            // Mentor: kursus yang dia buat
            $courses = Course::where('mentor_course', $user->id_user)->get();
            return view('mentor.courses.my-courses', compact('courses'));
        }

        // Student: kursus yang dia ikuti
        $courses = $user->courses()->get();
        return view('courses.my-courses', compact('courses'));
    }
}
