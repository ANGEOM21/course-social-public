<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Module;

class MentorCourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('mentor_course', Auth::id())->get();
        return view('mentor.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('mentor.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_course' => 'required|string|max:255',
            'desc_course' => 'nullable|string',
            'category_course' => 'required|integer',
        ]);

        Course::create([
            'name_course' => $request->name_course,
            'desc_course' => $request->desc_course,
            'mentor_course' => Auth::id(),
            'category_course' => $request->category_course,
        ]);

        return redirect()->route('mentor.courses.index')->with('success', 'Kursus berhasil ditambahkan!');
    }

    public function createModule(Course $course)
    {
        return view('mentor.modules.create', compact('course'));
    }

    public function storeModule(Request $request, Course $course)
    {
        $request->validate([
            'title_module' => 'required|string|max:255',
            'desc_module'  => 'nullable|string',
            'video_url'    => 'required|url',
        ]);

        Module::create([
            'course_id'    => $course->id_course,
            'title_module' => $request->title_module,
            'desc_module'  => $request->desc_module,
            'video_url'    => $request->video_url,
        ]);

        return redirect()->route('mentor.courses.index')->with('success', 'Module berhasil ditambahkan!');
    }
}
