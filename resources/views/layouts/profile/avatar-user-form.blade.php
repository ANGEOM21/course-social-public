<?php
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toastable;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

new class extends Component {
    use WithFileUploads, Toastable;
    public $avatar, $avatarFile, $name;
		public bool $showModal = false;


    public function mount()
    {
        $this->name = Auth::guard('admins')->user()->name_admin;
        $this->avatar = Auth::guard('admins')->user()->img_admin;
    }

    public function rules()
    {
        return [
            'avatarFile' => 'nullable|image|max:10240', // max 10MB
        ];
    }

	public function updated($propertyName)
	{
			$this->validateOnly($propertyName);

			if ($propertyName === 'avatarFile' && $this->avatarFile) {
					$this->showModal = true;
			}
	}


    public function updateProfileAvatar(): void
    {
        $this->validate();

        $user = Auth::guard('admins')->user();
        // Cek upload avatar
        if ($this->avatarFile instanceof TemporaryUploadedFile) {
            // Hapus avatar lama
            if ($user->img_admin && Storage::disk('public')->exists($user->img_admin)) {
                Storage::disk('public')->delete($user->img_admin);
            }
            // Simpan avatar baru
            $avatarPath = $this->avatarFile->store('profile-pictures', 'public');
        } else {
            $avatarPath = $user->img_admin;
        }

				$user->img_admin = $avatarPath;
				$this->avatar = $avatarPath;
				$user->save();

				// Update session

				// Reset state
				$this->showModal = false; // nutup modal
				$this->avatarFile = null; // reset file input
				$this->success('success update avatar');
    }
};
?>

<div class="relative w-28 h-28">
  {{-- Avatar Preview --}}
  <div class="w-28 h-28 rounded-full overflow-hidden bg-gray-200 border shadow">
    @if ($avatar)
      {{-- Avatar lama dari database --}}
      <img src="{{ asset("storage/$avatar") }}" alt="Avatar" class="w-full h-full object-cover">
    @else
      {{-- Default avatar --}}
      <img src="https://ui-avatars.com/api/?name={{ urlencode($name ?? 'User') }}" class="w-full h-full object-cover"
        alt="Default Avatar">
    @endif
  </div>

  {{-- Camera Button --}}
  <label for="avatar"
    class="w-10 h-10 flex items-center justify-center absolute bottom-0 right-0 bg-white rounded-full border shadow p-1 cursor-pointer hover:bg-gray-100 transition">
    <i class="fa fa-camera text-sm"></i>
  </label>

  {{-- Hidden File Input --}}
  <input wire:model="avatarFile" type="file" id="avatar" accept="image/*" class="hidden">

	{{-- Modal Component --}}
	<div  x-data="{ showModal: false }" x-init="$watch('$wire.avatarFile', val => showModal = !!val)" x-show="showModal"
		x-transition:enter="transition ease-out duration-300"
		x-transition:enter-start="opacity-0"
		x-transition:enter-end="opacity-100"
		x-transition:leave="transition ease-in duration-200"
		x-transition:leave-start="opacity-100"
		x-transition:leave-end="opacity-0"
		class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50"
		x-cloak
		@keydown.escape.window="$wire.set('showModal', false)">
		<div @click.outside="$wire.set('showModal', false)"
			class="bg-white dark:bg-base-100 rounded-xl shadow-xl w-full max-w-md mx-auto p-6"
			x-transition:enter="transition ease-out duration-300"
			x-transition:enter-start="scale-90 opacity-0"
			x-transition:enter-end="scale-100 opacity-100"
			x-transition:leave="transition ease-in duration-200"
			x-transition:leave-start="scale-100 opacity-100"
			x-transition:leave-end="scale-90 opacity-0">
			
			<h2 class="text-lg font-semibold mb-4">Konfirmasi Ganti Avatar</h2>

			<div class="w-32 h-32 rounded-full overflow-hidden mx-auto mb-4 border shadow">
				@if ($avatarFile)
					<img src="{{ $avatarFile->temporaryUrl() }}" class="w-full h-full object-cover" alt="Preview Avatar Baru">
				@endif
			</div>

			<div class="flex justify-end gap-2">
				<button @click="$wire.set('showModal', false)" class="btn btn-sm">Batal</button>
				<button wire:click="updateProfileAvatar" class="btn btn-sm btn-primary">Simpan</button>
			</div>
		</div>
	</div>


</div>
