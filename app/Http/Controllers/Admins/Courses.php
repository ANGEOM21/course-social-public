<?php

namespace App\Http\Controllers\Admins;

use App\Models\TblAdmin;
use App\Models\TblCategory;
use App\Models\TblCourse;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Masmerise\Toaster\Toastable;

class Courses extends Component
{
    use WithPagination, Toastable;

    // Properti untuk state & UI
    #[Url(as: 'q', history: true)]
    public string $search = '';

    #[Url(history: true)]
    public int $perPage = 10;

    public bool $courseModal = false;
    public bool $isEdit = false;
    public ?TblCourse $editingCourse = null;

    #[Rule('required|string|max:255')]
    public string $name_course = '';

    #[Rule('nullable')]
    public string $desc_course = '';

    #[Rule('required|exists:tbl_categories,id_category')]
    public $category_id;

    #[Rule('required|exists:tbl_admins,id_admin')]
    public $mentor_id;

    // Hook untuk mereset paginasi saat pencarian berubah
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = TblCategory::orderBy('name_category')->get();
        $mentors = TblAdmin::where('role', 'mentor')->orderBy('name_admin')->get();

        $query = TblCourse::query()
            ->with(['tbl_category', 'tbl_admin']);

        $query->when($this->search, function ($q) {
            $q->where('name_course', 'like', "%{$this->search}%")
                ->orWhereHas('tbl_category', fn($sub) => $sub->where('name_category', 'like', "%{$this->search}%"))
                ->orWhereHas('tbl_admin', fn($sub) => $sub->where('name_admin', 'like', "%{$this->search}%"));
        });

        $courses = $query->latest()->paginate($this->perPage);

        return view('pages.admin.course.index', [
            'title' => 'Courses',
            'courses' => $courses,
            'categories' => $categories,
            'mentors' => $mentors,
        ]);
    }

    public function create()
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->courseModal = true;
    }

    public function store()
    {
        $validated = $this->validate();
        TblCourse::create($validated);
        $this->success('Kursus baru berhasil ditambahkan!');
        $this->courseModal = false;
        $this->resetForm();
    }

    public function edit($course_id)
    {
        $course = TblCourse::findOrFail($course_id);
        $this->resetForm();
        $this->isEdit = true;
        $this->editingCourse = $course;
        $this->name_course = $course->name_course;
        $this->desc_course = $course->desc_course;
        $this->category_id = $course->category_id;
        $this->mentor_id = $course->mentor_id;

        $this->courseModal = true;
    }

    public function update()
    {
        $validated = $this->validate();
        $this->editingCourse->update($validated);
        $this->success('Data kursus berhasil diperbarui!');
        $this->courseModal = false;
        $this->resetForm();
    }

    // Satu fungsi untuk save atau update
    public function save()
    {
        if ($this->isEdit) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function delete($course_id)
    {
        $course = TblCourse::findOrFail($course_id);
        $course->delete();
        $this->success('Kursus berhasil dihapus!');
    }

    public function resetForm()
    {
        $this->reset(['name_course', 'desc_course', 'category_id', 'mentor_id', 'isEdit', 'editingCourse']);
        $this->resetErrorBag();
    }
}
