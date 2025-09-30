<div class="p-4">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <input wire:model.debounce.300ms="search" type="text" placeholder="Search categories..." class="input input-bordered" />
            <button wire:click="create" class="btn btn-primary">New Category</button>
        </div>
        <div>
            <select wire:model="perPage" class="select select-bordered">
                <option value="6">6</option>
                <option value="9">9</option>
                <option value="12">12</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @foreach($categories as $category)
            <div class="card bg-base-100 shadow-lg">
                <div class="card-body">
                    <h2 class="card-title">{{ $category->name_category }}</h2>
                    <p class="text-sm text-muted">Created: {{ $category->created_at?->format('Y-m-d') }}</p>
                    <div class="card-actions justify-end mt-2">
                        <button wire:click="edit({{ $category->id_category }})" class="btn btn-sm">Edit</button>
                        <button wire:click="delete({{ $category->id_category }})" class="btn btn-sm btn-error">Delete</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $categories->links('vendor.pagination.daisyui') }}
    </div>

    <!-- Modal (simple) -->
    <div x-data="{open:false}" x-on:open-category-modal.window="open = true" x-on:notify.window="(e) => { open = false; }">
        <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="modal-box w-11/12 max-w-lg">
                <h3 class="font-bold text-lg">{{ $isEdit ? 'Edit' : 'Create' }} Category</h3>
                <div class="py-4">
                    <input wire:model.defer="name_category" type="text" placeholder="Name" class="input input-bordered w-full" />
                    @error('name_category') <span class="text-error text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="modal-action">
                    <button x-on:click="open = false" class="btn">Cancel</button>
                    @if($isEdit)
                        <button wire:click="update" class="btn btn-primary">Update</button>
                    @else
                        <button wire:click="store" class="btn btn-primary">Save</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
