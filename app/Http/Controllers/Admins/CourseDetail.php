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

    // Properti untuk Modal Modul (disesuaikan dengan model)
    public bool $moduleModal = false;
    public bool $isEditModule = false;
    public ?TblModule $editingModule = null;

    #[Rule('required|string|max:255')]
    public string $title = ''; // Sebelumnya: name_module

    #[Rule('nullable|string')]
    public string $description = '';

    #[Rule('required|url')] // Validasi untuk memastikan ini adalah URL yang valid
    public string $video_url = '';

    public function mount($id)
    {
        $idCourse = (int) base64_decode($id);
        $this->course = TblCourse::with(['tbl_category', 'tbl_admin'])->findOrFail($idCourse);
        $this->loadModules();
    }

    public function loadModules()
    {
        $this->modules = $this->course->tbl_modules()->orderBy('created_at', 'asc')->get();
    }

    public function render()
    {
        return view('pages.admin.course.detail', [
            'title' => 'Detail Kursus: ' . $this->course->name_course,
        ]);
    }

    // --- FUNGSI UNTUK MANAJEMEN MODUL (DIPERBARUI) ---

    public function createModule()
    {
        $this->resetForm();
        $this->isEditModule = false;
        $this->moduleModal = true;
        $this->dispatch('trix-update-module', value: ''); // Kosongkan Trix
    }
    
    public function storeModule()
    {
        $validated = $this->validate();
        
        $this->course->tbl_modules()->create($validated);

        $this->success('Modul baru berhasil ditambahkan!');
        $this->moduleModal = false;
        $this->resetForm();
        $this->loadModules();
    }

    public function editModule(TblModule $module)
    {
        $this->resetForm();
        $this->isEditModule = true;
        $this->editingModule = $module;
        
        // Isi form dengan data yang ada
        $this->title = $module->title;
        $this->description = $module->description;
        $this->video_url = $module->video_url;
        
        $this->moduleModal = true;
        $this->dispatch('trix-update-module', value: $module->description); // Isi Trix
    }

    public function updateModule()
    {
        $validated = $this->validate();
        $this->editingModule->update($validated);

        $this->success('Modul berhasil diperbarui!');
        $this->moduleModal = false;
        $this->resetForm();
        $this->loadModules();
    }
    
    public function saveModule()
    {
        if ($this->isEditModule) {
            $this->updateModule();
        } else {
            $this->storeModule();
        }
    }

    public function deleteModule(TblModule $module)
    {
        $module->delete();
        $this->success('Modul berhasil dihapus!');
        $this->loadModules();
    }

    public function resetForm()
    {
        $this->reset(['title', 'description', 'video_url', 'isEditModule', 'editingModule']);
        $this->resetErrorBag();
    }
}