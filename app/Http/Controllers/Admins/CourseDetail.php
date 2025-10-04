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

    public function mount(TblCourse $slug_course)
    {
        $this->course = $slug_course->load(['tbl_category', 'tbl_admin']);
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

    public function createModule()
    {
        $this->resetForm();
        $this->isEditModule = false;
        $this->moduleModal = true;
        $this->dispatch('trix-update-module', value: '');
    }

    public function storeModule()
    {
        // Slug tidak perlu dibuat di sini, model akan menanganinya secara otomatis
        $validated = $this->validate();
        $this->course->tbl_modules()->create($validated);

        $this->success('Modul baru berhasil ditambahkan!');
        $this->moduleModal = false;
        $this->resetForm();
        $this->loadModules();
    }

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

    public function saveModule()
    {
        if ($this->isEditModule) {
            $this->updateModule();
        } else {
            $this->storeModule();
        }
    }

    public function deleteModule($module_id)
    {
        $module = TblModule::findOrFail($module_id);
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
