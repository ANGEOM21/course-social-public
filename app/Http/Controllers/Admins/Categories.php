<?php

namespace App\Http\Controllers\Admins;

use App\Models\TblCategory;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Masmerise\Toaster\Toastable;

class Categories extends Component
{
    use WithPagination, WithFileUploads, Toastable;

    #[Url(as: 'q')]
    public $search = '';

    #[Url]
    public $perPage = 10;

    #[Rule('required|string|max:255')]
    public $name_category;

    #[Rule('nullable|image|max:2048')]
    public $img_category;

    public $categoryId;
    public $isEdit = false;
    public $existing_img_category;

    // 1. Tambahkan properti ini untuk mengontrol modal
    public bool $categoryModal = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = TblCategory::query();
        $query->when($this->search, fn ($q) => $q->where('name_category', 'like', "%{$this->search}%"));

        $categories = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('pages.admin.categories.index', [
            'categories' => $categories,
            'title' => 'Kategori',
        ]);
    }

    public function create()
    {
        $this->resetForm();
        // 2. Buka modal dengan mengubah state
        $this->categoryModal = true;
    }

    public function store()
    {
        $this->validate();

        $imagePath = null;
        if ($this->img_category) {
            $imagePath = $this->img_category->store('categories', 'public');
        }

        TblCategory::create([
            'name_category' => $this->name_category,
            'img_category' => $imagePath,
        ]);

        $this->success('Kategori berhasil dibuat!');
        // 3. Tutup modal setelah berhasil
        $this->categoryModal = false;
        $this->resetForm();
    }

    public function edit($id)
    {
        $cat = TblCategory::findOrFail($id);
        $this->categoryId = $cat->id_category;
        $this->name_category = $cat->name_category;
        $this->existing_img_category = $cat->img_category;
        $this->isEdit = true;
        // 4. Buka modal dengan mengubah state
        $this->categoryModal = true;
    }

    public function update()
    {
        $this->validate();
        $cat = TblCategory::findOrFail($this->categoryId);

        $imagePath = $cat->img_category;

        if ($this->img_category) {
            if ($cat->img_category) {
                Storage::disk('public')->delete($cat->img_category);
            }
            $imagePath = $this->img_category->store('categories', 'public');
        }

        $cat->update([
            'name_category' => $this->name_category,
            'img_category' => $imagePath,
        ]);

        $this->success('Kategori berhasil diperbarui!');
        // 5. Tutup modal setelah berhasil
        $this->categoryModal = false;
        $this->resetForm();
    }

    public function save()
    {
        if ($this->isEdit) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function delete($id)
    {
        $cat = TblCategory::findOrFail($id);

        if ($cat->img_category) {
            Storage::disk('public')->delete($cat->img_category);
        }

        $cat->delete();
        $this->success('Kategori berhasil dihapus!');
    }

    public function resetForm()
    {
        $this->reset(['name_category', 'categoryId', 'isEdit', 'img_category', 'existing_img_category']);
        $this->resetErrorBag();
    }
}