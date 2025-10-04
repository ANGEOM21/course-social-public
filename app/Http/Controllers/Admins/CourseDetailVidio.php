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

    public function mount(TblCourse $slug_course, $slug_module): void
    {
        $this->course = $slug_course->load(['tbl_category', 'tbl_admin']);
        $this->activeModule = TblModule::where('slug', $slug_module)->where('course_id', $this->course->id_course)->firstOrFail();
        $this->allModules = $this->course->tbl_modules()->orderBy('created_at', 'asc')->get();
    }

    public function getYoutubeId(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        $p = parse_url($url);
        if (!is_array($p)) {
            return null;
        }

        if (isset($p['host']) && str_ends_with($p['host'], 'youtu.be')) {
            return isset($p['path']) ? ltrim($p['path'], '/') : null;
        }

        if (!empty($p['query'])) {
            parse_str($p['query'], $q);
            if (!empty($q['v'])) {
                return $q['v'];
            }
        }

        if (!empty($p['path']) && preg_match('~/(embed|v|shorts)/([A-Za-z0-9_-]{6,})~', $p['path'], $m)) {
            return $m[2] ?? null;
        }

        return null;
    }

    public function render()
    {
        return view('pages.admin.course.detail-vidio', [
            'title' => 'Menonton: ' . $this->activeModule->title,
        ]);
    }
}
