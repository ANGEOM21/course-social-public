<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progress;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    // Tampilkan progress user untuk kursus tertentu
    public function show($courseId)
    {
        $progress = Progress::where('user_id', Auth::id())
                            ->where('course_id', $courseId)
                            ->first();

        return view('progress.show', compact('progress'));
    }

    // Update progress user
    public function update(Request $request, $courseId)
    {
        $progress = Progress::firstOrCreate(
            ['user_id' => Auth::id(), 'course_id' => $courseId],
            ['total' => $request->total, 'completed' => 0]
        );

        $progress->completed = min($progress->completed + 1, $progress->total);
        $progress->save();

        return back()->with('success', 'Progress berhasil diperbarui!');
    }
}
