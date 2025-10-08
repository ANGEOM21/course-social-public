<?php

namespace App\Http\Controllers\Admins;

use App\Models\TblCourse;
use App\Models\TblModule;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class CourseDetailVidio extends Component
{
    public TblCourse $course;
    public TblModule $activeModule;
    /** @var Collection<int, TblModule> */
    public Collection $allModules;

    /**
     * Method `mount` akan dipanggil sekali saat komponen dimuat
     * 
     * @param TblCourse $slug_course
     * @param string $slug_module
     * 
     * @return void
     */
    public function mount(TblCourse $slug_course, $slug_module): void
    {
        $this->course = $slug_course->load(['tbl_category', 'tbl_admin']);
        $this->activeModule = TblModule::where('slug', $slug_module)->where('course_id', $this->course->id_course)->firstOrFail();
        $this->allModules = $this->course->tbl_modules()->orderBy('created_at', 'asc')->get();
    }

    /**
     * Mengambil ID video YouTube dari URL video YouTube yang diberikan.
     * 
     * Method ini akan mengembalikan ID video YouTube jika URL video YouTube yang diberikan valid.
     * Jika URL video YouTube yang diberikan tidak valid, maka method ini akan mengembalikan null.
     * 
     * @param string|null $url URL video YouTube yang ingin diambil ID-nya.
     * @return string|null ID video YouTube jika URL video YouTube yang diberikan valid, null jika tidak valid.
     */
    public function getYoutubeId(?string $url): ?string
    {
        if (!$url) return null;
        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|v/|shorts/))([A-Za-z0-9_-]{6,})~', $url, $m)) {
            return $m[1];
        }
        return null;
    }


    /**
     * Summary of render
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('pages.admin.course.detail-vidio', [
            'title' => 'Menonton: ' . $this->activeModule->title,
        ]);
    }
}
