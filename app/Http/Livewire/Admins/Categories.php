<?php

namespace App\Http\Livewire\Admins;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TblCategory;

class Categories extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $perPage = 9;

    public $name_category;
    public $categoryId;
    public $isEdit = false;

    protected $rules = [
        'name_category' => 'required|string|max:255',
    ];

    protected $listeners = ['refreshCategories' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = TblCategory::query();

        if ($this->search) {
            $query->where('name_category', 'like', "%{$this->search}%");
        }

        $categories = $query->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admins.categories', compact('categories'));
    }

    public function create()
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->dispatchBrowserEvent('open-category-modal');
    }

    public function store()
    {
        $this->validate();

        TblCategory::create([
            'name_category' => $this->name_category,
        ]);

        $this->resetForm();
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Category created']);
        $this->emitSelf('refreshCategories');
    }

    public function edit($id)
    {
        $cat = TblCategory::findOrFail($id);
        $this->categoryId = $cat->id_category;
        $this->name_category = $cat->name_category;
        $this->isEdit = true;
        $this->dispatchBrowserEvent('open-category-modal');
    }

    public function update()
    {
        $this->validate();

        $cat = TblCategory::findOrFail($this->categoryId);
        $cat->update([
            'name_category' => $this->name_category,
        ]);

        $this->resetForm();
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Category updated']);
        $this->emitSelf('refreshCategories');
    }

    public function delete($id)
    {
        $cat = TblCategory::findOrFail($id);
        $cat->delete();
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Category deleted']);
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->reset(['name_category', 'categoryId', 'isEdit']);
    }
}
