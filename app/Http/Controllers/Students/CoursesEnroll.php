<?php

namespace App\Http\Controllers\Students;

use App\Models\TblCourse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Masmerise\Toaster\Toastable;

class CoursesEnroll extends Component
{
    use Toastable;

    public TblCourse $course;
    public $modules;

    /**
     * Method `mount` akan dipanggil sekali saat komponen dimuat
     * 
     * @param \App\Models\TblCourse $course
     * @return void
     */
    public function mount(TblCourse $course): void
    {
        // Load semua relasi yang diperlukan untuk ditampilkan
        $this->course = $course->load(['tbl_category', 'tbl_admin', 'tbl_modules']);
        $this->modules = $this->course->tbl_modules()->orderBy('created_at', 'asc')->get();
    }

    /**
     * Mendaftarkan kursus yang dipilih
     *
     * Method ini akan memeriksa apakah user sudah terdaftar di kursus yang dipilih.
     * Jika user sudah terdaftar, maka akan munculkan peringatan.
     * Jika user belum terdaftar, maka akan mendaftarkan user ke kursus yang dipilih.
     * Setelah itu, maka akan mengarahkan user ke halaman pertama modul atau ke halaman daftar kursus
     *
     * @return void
     */
    public function enroll(): void
    {
        /** @var \App\Models\TblStudent $student */
        $student = Auth::user();

        $isEnrolled = $student->tbl_courses()->where('tbl_courses.id_course', $this->course->id_course)->exists();

        if ($isEnrolled) {
            $this->warning('Anda sudah terdaftar di kursus ini.');
            return;
        }

        $student->tbl_courses()->attach($this->course->id_course);

        $this->success('Anda berhasil mendaftar di kursus ini!');

        $firstModule = $this->course->tbl_modules()->orderBy('created_at', 'asc')->first();

        if ($firstModule) {
            $this->redirect(route('student.courses.watch', [
                'course' => $this->course->slug,
                'module' => $firstModule->slug
            ]), navigate: true);
        } else {
            $this->redirect(route('student.courses'), navigate: true);
        }
    }

    public function render()
    {
        return view('pages.students.courses.enroll', [
            'title' => 'Detail Kursus: ' . $this->course->name_course,
        ]);
    }
}
