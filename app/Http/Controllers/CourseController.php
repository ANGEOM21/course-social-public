<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return response()->json(Course::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_course'     => 'required|string|max:255',
            'category_course' => 'required|integer',
            'mentor_course'   => 'required|integer',
        ]);

        $course = Course::create($request->all());
        return response()->json($course, 201);
    }

    public function show($id)
    {
        return response()->json(Course::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'name_course'     => 'sometimes|string|max:255',
            'category_course' => 'sometimes|integer',
            'mentor_course'   => 'sometimes|integer',
        ]);

        $course->update($request->all());

        return response()->json($course);
    }

    public function listView(Request $request)
    {
        $query = Course::with(['category', 'mentor']);

        if ($request->filled('search')) {
            $query->where('name_course', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_course', $request->category);
        }

        $courses = $query->get();
        $categories = Category::all();

        return view('courses-list', compact('courses', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $mentors = User::where('role_user', 'mentor')->get();

        return view('courses-create', compact('categories', 'mentors'));
    }

    public function destroy($id)
    {
        Course::destroy($id);
        return response()->json(null, 204);
    }
}
