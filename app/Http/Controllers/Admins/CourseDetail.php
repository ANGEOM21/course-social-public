<?php

namespace App\Http\Controllers\Admins;

use App\Models\TblCourse;
use App\Models\TblModule;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Masmerise\Toaster\Toastable;

class CourseDetail extends Component
{
    use Toastable;

    public TblCourse $course;
    public $modules;

    // Properti untuk Modal Modul
    public bool $moduleModal = false;
    public bool $isEditModule = false;
    public ?TblModule $editingModule = null;

    #[Rule('required|string|max:255')]
    public string $title = '';

    #[Rule('nullable|string')]
    public string $description = '';

    // Validasi URL YouTube
    #[Rule('required', message: 'URL video wajib diisi.')]
    #[Rule('url', message: 'Format URL tidak valid.')]
    #[Rule('regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/', message: 'URL harus berupa link YouTube yang valid.')]
    public string $video_url = '';

    /**
     * Method `mount` akan dipanggil sekali saat komponen dimuat
     * 
     * @param \App\Models\TblCourse $slug_course
     * 
     * @return void
     */
    public function mount(TblCourse $slug_course)
    {
        $this->course = $slug_course->load(['tbl_category', 'tbl_admin']);
        $this->loadModules();
    }

    /**
     * Mengambil daftar modul di kursus ini
     * 
     * Method ini akan mengambil daftar modul yang ada di kursus ini dan
     * mengatur nilai `$this->modules`.
     * 
     * @return void
     */
    public function loadModules()
    {
        $this->modules = $this->course->tbl_modules()->orderBy('created_at', 'asc')->get();
    }

    /**
     * Membuka modal untuk membuat modul baru
     * Method ini akan mereset form dan mengatur nilai `$this->isEditModule` menjadi `false`
     * dan nilai `$this->moduleModal` menjadi `true`.
     * Kemudian, method ini akan mengirimkan event `trix-update-module` dengan nilai string kosong.
     * 
     * @return void
     */
    public function createModule()
    {
        $this->resetForm();
        $this->isEditModule = false;
        $this->moduleModal = true;
        $this->dispatch('trix-update-module', value: '');
    }

    /**
     * Menyimpan modul baru di kursus ini
     * 
     * Method ini akan mengirimkan validasi terhadap inputan form, kemudian
     * membuat modul baru dengan data yang divalidasi dan mengatur nilai
     * `$this->moduleModal` menjadi `false`, mengembalikan pesan sukses dengan
     * isi `'Modul baru berhasil ditambahkan!'`, mereset form, dan mengupdate
     * daftar modul yang ada di kursus ini.
     * 
     * @return void
     */
    public function storeModule()
    {
        $validated = $this->validate();
        $this->course->tbl_modules()->create($validated);

        $this->success('Modul baru berhasil ditambahkan!');
        $this->moduleModal = false;
        $this->resetForm();
        $this->loadModules();
    }

    /**
     * Membuka modal untuk mengedit modul yang sudah ada di kursus ini
     * Method ini akan mereset form, mengatur nilai `$this->isEditModule` menjadi `true`,
     * mengatur nilai `$this->editingModule` dengan nilai objek modul yang ingin diedit,
     * mengatur nilai `$this->title`, `$this->description`, dan `$this->video_url` dengan nilai
     * yang sesuai dengan objek modul yang ingin diedit, mengatur nilai
     * `$this->moduleModal` menjadi `true`, dan mengirimkan event `trix-update-module`
     * dengan nilai string deskripsi modul yang ingin diedit.
     *
     * @param int $module_id ID modul yang ingin diedit
     * @return void
     */
    public function editModule($module_id)
    {
        $module = TblModule::findOrFail($module_id);
        $this->resetForm();
        $this->isEditModule = true;
        $this->editingModule = $module;
        $this->title = $module->title;
        $this->description = $module->description;
        $this->video_url = $module->video_url;
        $this->moduleModal = true;
        $this->dispatch('trix-update-module', value: $module->description);
    }

    /**
     * Mengupdate modul yang sudah ada di kursus ini
     * Method ini akan mengupdate informasi modul yang sudah ada di kursus ini
     * berdasarkan data yang dikirimkan melalui form.
     * 
     * @return void
     */
    public function updateModule()
    {
        // Slug tidak perlu diupdate di sini
        $validated = $this->validate();
        $this->editingModule->update($validated);

        $this->success('Modul berhasil diperbarui!');
        $this->moduleModal = false;
        $this->resetForm();
        $this->loadModules();
    }

    /**
     * Menyimpan modul yang sudah diedit atau membuat modul baru
     * Jika `$this->isEditModule` bernilai `true`, maka method ini akan
     * mengupdate informasi modul yang sudah ada di kursus ini
     * berdasarkan data yang dikirimkan melalui form.
     * Jika `$this->isEditModule` bernilai `false`, maka method ini akan
     * membuat modul baru dengan data yang divalidasi dan mengatur nilai
     * `$this->moduleModal` menjadi `false`, mengembalikan pesan sukses dengan
     * isi `'Modul baru berhasil ditambahkan!'`, mereset form, dan mengupdate
     * daftar modul yang ada di kursus ini
     *
     * @return void
     */
    public function saveModule()
    {
        if ($this->isEditModule) {
            $this->updateModule();
        } else {
            $this->storeModule();
        }
    }


    /**
     * Summary of deleteModule
     * @description Menghapus modul yang sudah ada di kursus ini
     * berdasarkan ID modul
     * 
     * @param mixed $module_id
     * @return void
     */
    public function deleteModule($module_id)
    {
        $module = TblModule::findOrFail($module_id);
        $module->delete();
        $this->success('Modul berhasil dihapus!');
        $this->loadModules();
    }

    /**
     * Mereset form dan mengosongkan error bag
     * Method ini akan mengatur nilai-nilai properti di atas menjadi kosong
     * dan mengosongkan error bag
     */
    public function resetForm()
    {
        $this->reset(['title', 'description', 'video_url', 'isEditModule', 'editingModule']);
        $this->resetErrorBag();
    }

    /**
     * Mengembalikan view halaman detail kursus
     *
     * Method ini akan mengembalikan view halaman detail kursus
     * dengan mengirimkan data berupa judul halaman
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('pages.admin.course.detail', [
            'title' => 'Detail Kursus: ' . $this->course->name_course,
        ]);
    }
}
