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

    #[Rule('required|in:Y,N')]
    public string $showing = 'N';

    /**
     * Reset pagination to the first page when the search query changes.
     *
     * @return void
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Membuka modal untuk membuat kursus baru.
     * Method ini akan mereset form, mengatur nilai `$this->isEdit` menjadi `false`,
     * dan nilai `$this->courseModal` menjadi `true`.
     * 
     * @return void
     */
    public function create()
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->courseModal = true;
    }

    /**
     * Membuat kursus baru dengan data yang divalidasi.
     * Method ini akan mengirimkan validasi terhadap inputan form, kemudian
     * membuat kursus baru dengan data yang divalidasi dan mengatur nilai
     * `$this->courseModal` menjadi `false`, mengembalikan pesan sukses dengan
     * isi `'Kursus baru berhasil ditambahkan!'`, mereset form, dan mengupdate
     * daftar kursus yang ada di halaman ini.
     *
     * @return void
     */
    public function store()
    {
        $validated = $this->validate();
        TblCourse::create($validated);
        $this->success('Kursus baru berhasil ditambahkan!');
        $this->courseModal = false;
        $this->resetForm();
    }

    /**
     * Membuka modal untuk mengedit kursus yang sudah ada.
     * Method ini akan mereset form, mengatur nilai `$this->isEdit` menjadi `true`,
     * mengatur nilai `$this->editingCourse` dengan objek kursus yang ingin diedit,
     * mengatur nilai `$this->name_course`, `$this->desc_course`, `$this->category_id`, dan
     * `$this->mentor_id` dengan nilai yang sesuai dengan objek kursus yang ingin diedit,
     * dan mengatur nilai `$this->courseModal` menjadi `true`.
     * 
     * @param int $course_id ID kursus yang ingin diedit
     * @return void
     */
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

    /**
     * Mengupdate data kursus yang sudah ada dengan data yang divalidasi.
     * Method ini akan mengirimkan validasi terhadap inputan form, kemudian
     * mengupdate data kursus yang sudah ada dengan data yang divalidasi dan mengatur nilai
     * `$this->courseModal` menjadi `false`, mengembalikan pesan sukses dengan
     * isi `'Data kursus berhasil diperbarui!'`, mereset form, dan mengupdate
     * daftar kursus yang ada di halaman ini.
     *
     * @return void
     */
    public function update()
    {
        $validated = $this->validate();
        $this->editingCourse->update($validated);
        $this->success('Data kursus berhasil diperbarui!');
        $this->courseModal = false;
        $this->resetForm();
    }

    /**
     * Simpan data kursus yang sudah ada atau membuat kursus baru.
     * Jika nilai `$this->isEdit` bernilai `true`, maka method ini akan mengupdate data kursus yang sudah ada.
     * Jika nilai `$this->isEdit` bernilai `false`, maka method ini akan membuat kursus baru dengan data yang divalidasi.
     * 
     * @return void
     */
    public function save()
    {
        if ($this->isEdit) {
            $this->update();
        } else {
            $this->store();
        }
    }


    /**
     * Menghapus kursus yang sudah ada dengan ID yang diberikan.
     *
     * Method ini akan menghapus kursus yang sesuai dengan ID yang diberikan dan
     * mengembalikan pesan sukses dengan isi `'Kursus berhasil dihapus!'`.
     *
     * @param int $course_id ID kursus yang ingin dihapus
     * @return void
     */
    public function delete($course_id)
    {
        $course = TblCourse::findOrFail($course_id);
        $course->delete();
        $this->success('Kursus berhasil dihapus!');
    }

    /**
     * Mengubah status menampilkan atau menyembunyikan kursus yang sudah ada dengan ID yang diberikan.
     *
     * Method ini akan mengubah status menampilkan atau menyembunyikan kursus yang sesuai dengan ID yang diberikan dan
     * mengembalikan pesan sukses dengan isi `'Course {nama_kursus} berhasil {ditampilkan/disembunyikan}!'`.
     *
     * @param int $course_id ID kursus yang ingin diubah statusnya
     * @return void
     */
    public function toggleShowing($course_id)
    {
        $course = TblCourse::findOrFail($course_id);

        $course->showing = ($course->showing === 'Y') ? 'N' : 'Y';
        $course->save();

        $status = ($course->showing === 'Y') ? 'ditampilkan' : 'disembunyikan';
        $this->success("Course '{$course->name_course}' berhasil {$status}.");
    }

    /**
     * Reset form and error bag
     *
     * Method ini akan mereset form dan mengatur nilai error bag menjadi kosong.
     *
     * @return void
     */
    public function resetForm()
    {
        $this->reset(['name_course', 'showing', 'desc_course', 'category_id', 'mentor_id', 'isEdit', 'editingCourse']);
        $this->resetErrorBag();
    }

    /**
     * Render Courses Index Page
     *
     * Method ini akan mengambil data kursus yang ada di database dan menampilkan
     * data tersebut di halaman index course admin.
     *
     * @return \Illuminate\Contracts\View\View
     */
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
}
