<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    public function show($courseId, $moduleId = null)
    {
        $course = Course::with('category')->findOrFail($courseId);
        $modules = Module::where('course_id', $courseId)->get();

        // Kalau tidak ada moduleId, ambil modul pertama
        $currentModule = $moduleId 
            ? Module::findOrFail($moduleId)
            : $modules->first();

        return view('learning.show', compact('course', 'modules', 'currentModule'));
    }
}
