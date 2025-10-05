<?php

namespace App\Http\Controllers\Students;

use App\Models\TblProgress;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Courses extends Component
{
    use WithPagination;

    public function render()
    {
        /** @var \App\Models\TblStudent $student */
        $student = Auth::user();

        $enrolledCourses = $student->tbl_enrollments()
            ->with(['tbl_admin', 'tbl_modules', 'tbl_category'])
            ->paginate(6);

        $progressData = [];
        $courseIdsOnPage = $enrolledCourses->pluck('id_course')->toArray();

        if (!empty($courseIdsOnPage)) {
            $completedModules = TblProgress::where('student_id', $student->id_student)
                ->whereIn('course_id', $courseIdsOnPage)
                ->selectRaw('course_id, count(distinct module_id) as completed_count')
                ->groupBy('course_id')
                ->get()
                ->keyBy('course_id');

            foreach ($enrolledCourses as $course) {
                $totalModules = $course->tbl_modules->count();
                $completedCount = $completedModules->get($course->id_course)->completed_count ?? 0;

                $progressData[$course->id_course] = round(($completedCount / ($totalModules ?? 1)) * 100);
            }
        }

        return view('pages.students.courses.index', [
            'enrolledCourses' => $enrolledCourses,
            'progressData' => $progressData,
            'title' => 'Kursus Saya',
        ]);
    }
}
