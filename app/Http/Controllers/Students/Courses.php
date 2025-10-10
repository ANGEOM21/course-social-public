<?php

namespace App\Http\Controllers\Students;

use App\Models\TblProgress;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Courses extends Component
{
    use WithPagination;

    /**
     * Render Courses Index Page
     *
     * Method ini mengambil data kursus yang diikuti oleh siswa yang sedang login,
     * menghitung progres penyelesaian modul untuk setiap kursus, dan menentukan
     * tautan untuk melanjutkan kursus dari modul pertama yang belum diselesaikan.
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        /** @var \App\Models\TblStudent $student */
        $student = Auth::guard('web')->user();

        $enrolledCourses = $student->tbl_courses()
            ->whereHas('tbl_modules', fn($sub) => $sub->where('showing', 'Y'))
            ->with(['tbl_admin', 'tbl_modules', 'tbl_category'])
            ->latest('tbl_enrollments.created_at')
            ->paginate(6);

        $progressData = [];

        /** @var \Illuminate\Pagination\LengthAwarePaginator<\App\Models\TblCourse> $enrolledCourses */
        $courseIdsOnPage = $enrolledCourses->pluck('id_course')->toArray();
        
        $resumeLinks = [];
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

                $allModules = $course->tbl_modules->sortBy('created_at');
                $firstUncompletedModule = $allModules->first(function ($module) use ($student, $course) {
                    return !TblProgress::where('student_id', $student->id_student)
                        ->where('course_id', $course->id_course)
                        ->where('module_id', $module->id_module)
                        ->exists();
                });

                if ($firstUncompletedModule) {
                    $resumeLinks[$course->id_course] = $firstUncompletedModule->slug;
                } elseif ($allModules->isNotEmpty()) {
                    $resumeLinks[$course->id_course] = $allModules->first()->slug;
                } else {
                    $resumeLinks[$course->id_course] = null;
                }
            }
        }

        return view('pages.students.courses.index', [
            'enrolledCourses' => $enrolledCourses,
            'progressData' => $progressData,
            'resumeLinks' => $resumeLinks,
            'title' => 'Kursus Saya',
        ]);
    }
}
