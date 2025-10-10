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
    public bool $categoryModal = false;


    /**
     * Reset the pagination to the first page when the search query changes.
     * 
     * @return void
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Buka modal untuk membuat kategori baru.
     *
     * Method ini akan mereset form dan mengubah state $categoryModal menjadi true.
     *
     * @return void
     */
    public function create()
    {
        $this->resetForm();
        $this->categoryModal = true;
    }

    /**
     * Method untuk membuat kategori baru.
     *
     * Method ini akan membuat kategori baru berdasarkan data yang diisi pada form.
     * Jika berhasil, maka akan menampilkan pesan sukses dan menutup modal.
     *
     * @return void
     */
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
        $this->categoryModal = false;
        $this->resetForm();
    }


    /**
     * Summary of edit
     * @description Buka modal untuk mengedit kategori
     * @description Memperbarui data kategori
     * 
     * @param \Illuminate\Http\Request $request
     * @param mixed $id
     * @return void
     */
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


    /**
     * Method untuk mengedit kategori yang sudah ada.
     *
     * Method ini akan memperbarui data kategori yang sudah ada berdasarkan data yang diisi pada form.
     * Jika berhasil, maka akan menampilkan pesan sukses dan menutup modal.
     *
     * @return void
     */
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
        $this->categoryModal = false;
        $this->resetForm();
    }

    /**
     * Method untuk menyimpan kategori
     *
     * Jika $isEdit == true, maka akan memanggil method update()
     * Jika $isEdit == false, maka akan memanggil method store()
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
     * Hapus kategori dengan ID yang diberikan
     *
     * Method ini akan menghapus kategori dengan ID yang diberikan
     * Jika kategori memiliki gambar, maka akan dihapus juga
     *
     * @param int $id ID kategori yang akan dihapus
     *
     * @return void
     */
    public function delete($id)
    {
        $cat = TblCategory::findOrFail($id);

        if ($cat->img_category) {
            Storage::disk('public')->delete($cat->img_category);
        }

        $cat->delete();
        $this->success('Kategori berhasil dihapus!');
    }
    

    public function toggleShowing(TblCategory $category)
    {
        // Ubah status: jika 'Y' menjadi 'N', jika 'N' menjadi 'Y'
        $category->showing = ($category->showing === 'Y') ? 'N' : 'Y';
        $category->save();

        $status = ($category->showing === 'Y') ? 'ditampilkan' : 'disembunyikan';
        $this->success("Kategori '{$category->name_category}' berhasil {$status}.");
    }


    /**
     * Summary of resetForm
     * @description Mereset form
     * 
     * @return void
     */
    public function resetForm()
    {
        $this->reset(['name_category', 'categoryId', 'isEdit', 'img_category', 'existing_img_category']);
        $this->resetErrorBag();
    }




    /**
     * Renders the categories index page.
     *
     * This method will render the categories index page with pagination and search functionality.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        $query = TblCategory::query();
        $query->when($this->search, fn($q) => $q->where('name_category', 'like', "%{$this->search}%"));

        $categories = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('pages.admin.categories.index', [
            'categories' => $categories,
            'title' => 'Kategori',
        ]);
    }
}
