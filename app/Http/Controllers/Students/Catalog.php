<?php

namespace App\Http\Controllers\Students;

use App\Models\TblCategory;
use App\Models\TblCourse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class Catalog extends Component
{
    use WithPagination;

    #[Url(as: 'q', history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $category = '';

    // properti isFiltered
    public bool $isFiltered = false;

    public function updated($property)
    {
        if (in_array($property, ['search', 'category'])) {
            $this->resetPage();
        }
    }

    public function resetFilters()
    {
        $this->reset('search', 'category');
        $this->resetPage();
    }

    public function render()
    {
        $categories = TblCategory::orderBy('name_category')->get();
        /** @var \App\Models\TblStudent $student */
        $student = Auth::user();

        $enrolledCourseIds = $student->tbl_courses()->pluck('tbl_courses.id_course')->toArray();

        $query = TblCourse::query()
            ->with(['tbl_category', 'tbl_admin', 'tbl_modules', 'tbl_feedbacks'])
            ->whereNotIn('id_course', $enrolledCourseIds)
            ->withAvg('tbl_feedbacks as average_rating', 'rating');

        $this->isFiltered = !empty($this->search) || !empty($this->category);

        $query->when($this->search, function ($q) {
            $q->where('name_course', 'like', "%{$this->search}%")->orWhereHas('tbl_admin', fn($sub) => $sub->where('name_admin', 'like', "%{$this->search}%"));
        });

        $query->when($this->category, function ($q) {
            $q->whereHas('tbl_category', fn($sub) => $sub->where('slug', $this->category));
        });
        $courses = $query->orderByDesc('average_rating')->latest()->paginate(9);

        return view('pages.students.catalog.index', [
            'courses' => $courses,
            'categories' => $categories,
            'title' => 'Katalog Kursus',
        ]);
    }
}
