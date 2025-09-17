<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * List semua kursus (student + mentor bisa lihat)
     */
    public function listView(Request $request)
    {
        $query = Course::with(['category', 'mentor']);

        // Filter by search
        if ($request->filled('search')) {
            $query->where('name_course', 'like', '%' . $request->search . '%');
        }

        // Filter by kategori
        if ($request->filled('category')) {
            $query->where('category_course', $request->category);
        }

        $courses = $query->get();
        $categories = Category::all();

        return view('courses.list', compact('courses', 'categories'));
    }

    /**
     * Detail kursus
     */
    public function show($id)
    {
        $course = Course::with(['category', 'mentor'])->findOrFail($id);
        return view('courses.show', compact('course'));
    }

    /**
     * Form create kursus (hanya mentor)
     */
    public function create()
    {
        $categories = Category::all();
        return view('mentor.courses.create', compact('categories'));
    }

    /**
     * Simpan kursus baru (mentor)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_course'     => 'required|string|max:255',
            'desc_course'     => 'required|string',
            'category_course' => 'required|exists:tbl_category,id_category',
        ]);

        Course::create([
            'name_course'     => $request->name_course,
            'desc_course'     => $request->desc_course,
            'category_course' => $request->category_course,
            'mentor_course'   => Auth::user()->id_user,
        ]);

        return redirect()->route('mentor.dashboard')
                         ->with('success', 'Kursus berhasil dibuat!');
    }

    /**
     * Form edit kursus
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $categories = Category::all();

        return view('mentor.courses.edit', compact('course', 'categories'));
    }

    /**
     * Update kursus
     */
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'name_course'     => 'required|string|max:255',
            'desc_course'     => 'required|string',
            'category_course' => 'required|exists:tbl_category,id_category',
        ]);

        $course->update($request->only(['name_course', 'desc_course', 'category_course']));

        return redirect()->route('mentor.dashboard')
                         ->with('success', 'Kursus berhasil diperbarui!');
    }

    /**
     * Hapus kursus
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        // opsional: pastikan mentor hanya bisa hapus kursus miliknya
        if ($course->mentor_course != Auth::user()->id_user) {
            return redirect()->back()->with('error', 'Anda tidak berhak menghapus kursus ini.');
        }

        $course->delete();

        return redirect()->route('mentor.dashboard')
                         ->with('success', 'Kursus berhasil dihapus!');
    }
}
