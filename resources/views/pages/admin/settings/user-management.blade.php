<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\TblAdmin as User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Masmerise\Toaster\Toastable;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithPagination, WithFileUploads, Toastable;

    // Properti untuk form "Tambah User"
    public string $full_name = '';
    public string $email = '';
    public string $role = 'mentor';
    public string $password = '';
    public string $password_confirmation = '';
    public $profile_picture;

    // Properti untuk modal "Edit User"
    public ?User $editingUser = null;
    public string $editingFullName = '';
    public string $editingEmail = '';
    public string $editingRole = '';
    public string $editingPassword = '';
    public string $editingPassword_confirmation = '';
    public $newProfilePicture;

    // Properti untuk modal "Reset Password"
    public ?User $resetingUser = null;
    public string $resetPassword = '';
    public string $resetPassword_confirmation = '';

    public bool $showEditModal = false;
    public bool $showResetPasswordModal = false;

    protected function rules()
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:50', 'unique:tbl_admins,email_admin'],
            'role' => ['required', Rule::in(['admin', 'mentor'])],
            'password' => ['required', 'string', 'confirmed', Password::min(6)],
            'profile_picture' => ['nullable'],
        ];
    }

    public function saveUser()
    {
        $validated = $this->validate();
        $filePath = $this->profile_picture?->store('profile-pictures', 'public');
        
        User::create([
          'name_admin' => $validated['full_name'],
          'email_admin' => $validated['email'],
          'role' => $validated['role'],
          'password_admin' => bcrypt($validated['email']),
          'img_admin' => $filePath,
        ]);
        $this->success('User baru berhasil dibuat!');
        $this->reset('full_name', 'email', 'role', 'password', 'password_confirmation', 'profile_picture');
    }

    public function edit(User $user)
    {
        $this->editingUser = $user;
        $this->editingFullName = $user->name_admin;
        $this->editingEmail = $user->email_admin;
        $this->editingRole = $user->role;
        $this->newProfilePicture = null;
        $this->reset('editingPassword', 'editingPassword_confirmation');
        $this->resetErrorBag();
        $this->showEditModal = !$this->showEditModal;
    }

    public function updateUser()
    {
        $validated = $this->validate([
            'editingFullName' => ['required', 'string', 'max:255'],
            'editingEmail' => ['required', 'string', 'max:50', Rule::unique('tbl_admins', 'email_admin')->ignore($this->editingUser->id_admin, 'id_admin')],
            'editingRole' => ['required', Rule::in(['admin', 'mentor'])],
            'editingPassword' => ['nullable', 'string', 'confirmed', Password::min(6)],
            'newProfilePicture' => ['nullable', 'image', 'max:5120'],
        ]);
        $filePath = $this->editingUser->img_admin;
        if ($this->newProfilePicture) {
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $this->newProfilePicture->store('profile-pictures', 'public');
        }
        $this->editingUser->update([
            'name_admin' => $validated['editingFullName'],
            'email_admin' => $validated['editingEmail'],
            'role' => $validated['editingRole'],
            'img_admin' => $filePath,
        ]);
        if ($validated['editingPassword']) {
            $this->editingUser->update(['password_admin' => bcrypt($validated['editingPassword'])]);
        }
        $this->success('Data user berhasil diperbarui!');
        $this->showEditModal = !$this->showEditModal;
    }

    public function resetPwd(User $user)
    {
        $this->resetingUser = $user;
        $this->reset('resetPassword', 'resetPassword_confirmation');
        $this->resetErrorBag();
        $this->showResetPasswordModal = !$this->showResetPasswordModal;
    }

    public function doResetPassword()
    {
        $validated = $this->validate([
            'resetPassword' => ['required', 'string', 'confirmed', Password::min(6)],
        ]);
        $this->resetingUser->update(['password_admin' => bcrypt($validated['resetPassword'])]);
        $this->success("Password untuk user {$this->resetingUser->email_admin} berhasil direset!");
        $this->showResetPasswordModal = !$this->showResetPasswordModal;
    }

    public function delete(User $user)
    {
        $user->delete();
        $this->success('User berhasil dihapus!');
    }

    public function with(): array
    {
        $users = User::where('id_admin', '!=', auth('admins')->user()->id)
            ->orderBy('name_admin', 'asc')
            ->paginate(10);
        return ['users' => $users];
    }
}; ?>

<div> {{-- Pembungkus utama, jangan hapus --}}
  <div class="space-y-6">
    {{-- BAGIAN 1: FORM BUAT AKUN BARU --}}
    <div class="card bg-base-100 shadow">
      <form class="card-body" wire:submit="saveUser">
        <h2 class="card-title text-lg"><i class="fa fa-user-plus mr-2"></i>Buat Akun Admin / mentor</h2>

        {{-- Menggunakan Grid dengan 3 kolom untuk layout yang lebih fleksibel --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

          {{-- Kolom 1: Foto Profil --}}
          <div class="md:col-span-1 flex flex-col items-center justify-center space-y-2">
            <label class="label cursor-pointer" for="profile_picture">
              <span class="label-text font-semibold">Foto Profil (Opsional)</span>
            </label>
            <div class="relative w-40 h-40">
              {{-- Preview --}}
              <div class="w-40 h-40 rounded-full overflow-hidden bg-gray-200 border shadow">
                @if ($profile_picture)
                  <img src="{{ $profile_picture->temporaryUrl() }}" alt="Avatar Preview"
                    class="w-full h-full object-cover">
                @else
                  {{-- Avatar default dinamis berdasarkan input nama --}}
                  <img
                    src="https://ui-avatars.com/api/?name={{ urlencode($full_name ?: 'U') }}&background=random&color=fff"
                    class="w-full h-full object-cover" alt="Default Avatar">
                @endif
              </div>
              {{-- Tombol Kamera --}}
              <label for="profile_picture"
                class="w-10 h-10 flex items-center justify-center absolute bottom-1 right-1 bg-white rounded-full border shadow p-1 cursor-pointer hover:bg-gray-100 transition">
                <i class="fa fa-camera text-sm"></i>
              </label>
              {{-- Input File Tersembunyi --}}
              <input wire:model="profile_picture" type="file" id="profile_picture" accept="image/*" class="hidden">
            </div>
            <div wire:loading wire:target="profile_picture" class="text-sm text-info">Uploading...</div>
            @error('profile_picture')
              <span class="text-sm text-error mt-1 block">{{ $message }}</span>
            @enderror
          </div>

          {{-- Kolom 2 & 3: Detail User --}}
          <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4 content-start">
            {{-- Nama Lengkap --}}
            <div class="form-control flex flex-col">
              <label class="label"><span class="label-text">Nama Lengkap</span></label>
              <input type="text" placeholder="Nama lengkap" class="input input-bordered w-full" wire:model="full_name"
                required />
              @error('full_name')
                <span class="text-error text-xs mt-1">{{ $message }}</span>
              @enderror
            </div>

            {{-- email --}}
            <div class="form-control flex flex-col">
              <label class="label"><span class="label-text">Email</span></label>
              <input type="email" placeholder="Email untuk login" class="input input-bordered w-full" wire:model="email"
                required />
              @error('email')
                <span class="text-error text-xs mt-1">{{ $message }}</span>
              @enderror
            </div>

            {{-- Role --}}
            <div class="form-control md:col-span-2 flex flex-col">
              <label class="label">
              <span class="label-text">Role</span>
              </label>
              <select class="select select-bordered w-full" wire:model="role" required>
                <option value="mentor">mentor</option>
                <option value="admin">Admin</option>
              </select>
              @error('role')
                <span class="text-error text-xs mt-1">{{ $message }}</span>
              @enderror
            </div>

            {{-- Password --}}
            <div class="form-control flex flex-col">
              <label class="label">
                <span class="label-text">Password</span>
              </label>
              <input type="password" placeholder="Minimal 6 karakter" class="input input-bordered w-full" wire:model="password"
                required />
              @error('password')
                <span class="text-error text-xs mt-1">{{ $message }}</span>
              @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="form-control flex flex-col">
              <label class="label"><span class="label-text">Konfirmasi Password</span></label>
              <input type="password" placeholder="Ulangi password" class="input input-bordered w-full"
                wire:model="password_confirmation" required />
            </div>
          </div>
        </div>

        <div class="card-actions justify-end mt-4">
          <button type="submit" class="btn btn-primary">
            <span wire:loading.remove wire:target="saveUser">Buat Akun</span>
            <span wire:loading wire:target="saveUser" class="loading loading-spinner"></span>
          </button>
        </div>
      </form>
    </div>

    {{-- BAGIAN 2: DAFTAR AKUN --}}
    <div class="card bg-base-100 shadow">
      <div class="card-body">
        <h2 class="card-title text-lg"><i class="fa fa-users mr-2"></i>Daftar Akun Sistem</h2>
        <div class="overflow-x-auto mt-4">
          <table class="table table-zebra">
            <thead>
              <tr>
                <th>Nama Pengguna</th>
                <th>Role</th>
                <th class="text-center">Terakhir Login</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @php
                $badge = [
                    'superadmin' => 'bg-base-content',
                    'admin' => 'bg-lime-600',
                    'mentor' => 'bg-red-600',
                    'user' => 'bg-warning',
                ];
              @endphp
              @forelse ($users as $user)
                <tr wire:key="{{ $user->id_admin }}">
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="avatar {{ $user->online_status }}">
                        <div class="mask mask-squircle w-12 h-12">
                          <img
                            src="{{ $user->img_admin ? asset('storage/' . $user->img_admin) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name_admin).'&background=random' }}"
                            alt="Avatar" />
                        </div>
                      </div>
                      <div>
                        <div class="font-bold">{{ $user->name_admin }}</div>
                        <div class="text-sm opacity-50">{{ $user->email_admin }}</div>
                      </div>
                    </div>
                  </td>

                  <td>
                    <span
                      class="px-2 py-1 rounded-badge text-sm text-base-100 rounded {{ $badge[$user->role] }}">{{ ucfirst($user->role) }}</span>
                  </td>
                  <td class="text-center">
                    @if ($user->last_login_at)
                      <span class="text-sm">
                        {{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans(['parts' => 2]) }}
                      </span>
                    @else
                      <span class="text-sm italic text-gray-400">Belum Pernah</span>
                    @endif
                  </td>


                  <td class="text-center">
                    <div class="flex justify-center gap-2">
                    @if ($user->role != 'admin')
                      <button class="btn btn-xs btn-warning" wire:click="edit({{ $user->id_admin }})" title="Edit User">
                        <i class="fa fa-edit"></i>
                      </button>
                    @endif
                      <button class="btn btn-xs btn-secondary" wire:click="resetPwd({{ $user->id_admin }})"
                        title="Reset Password"><i class="fa fa-key"></i></button>
                    @if ($user->role != 'admin')
                      <button class="btn btn-xs btn-error" 
                      wire:confirm.prompt="Anda yakin ingin menghapus user {{ $user->full_name }}?.\nJika iya, ketik 'KONFIRMASI' untuk konfirmasi.|KONFIRMASI"
                      wire:click="delete({{ $user->id_admin }})" title="Hapus User">
                        <i class="fa fa-trash"></i>
                      </button>
                    @endif
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="3" class="text-center">Tidak ada user admin atau mentor.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="mt-4">{{ $users->links('pagination::daisyui') }}</div>
      </div>
    </div>
  </div>

  {{-- MODAL UNTUK EDIT USER --}}
  <x-modal id="edit-user-modal" title="Edit User" subtitle="Ubah data pengguna {{ $editingFullName ?: 'User' }}"
    :separator="true" boxClass="max-w-2xl" :persistent="false" wire:model="showEditModal">
    <form wire:submit="updateUser" class="space-y-4">
      {{-- Komponen Avatar Edit --}}
      <div class="flex flex-col justify-center items-center">
        <div class="relative w-40 h-40">
          <div class="w-40 h-40 rounded-full overflow-hidden bg-gray-200 border shadow">
            @if ($newProfilePicture)
              <img src="{{ $newProfilePicture->temporaryUrl() }}" class="w-full h-full object-cover">
            @elseif ($editingUser?->profile_picture_url)
              <img src="{{ Storage::url($editingUser->profile_picture_url) }}" class="w-full h-full object-cover">
            @else
              <img src="https://ui-avatars.com/api/?name={{ urlencode($editingFullName ?: 'User') }}"
                class="w-full h-full object-cover">
            @endif
          </div>
          <label for="newProfilePicture"
            class="w-10 h-10 flex items-center justify-center absolute bottom-1 right-1 bg-white rounded-full border shadow p-1 cursor-pointer hover:bg-gray-100 transition">
            <i class="fa fa-camera text-sm"></i>
          </label>
          <input wire:model="newProfilePicture" type="file" id="newProfilePicture" accept="image/*"
            class="hidden">
        </div>
        @error('newProfilePicture')
          <span class="text-sm text-error mt-1 block">{{ $message }}</span>
        @enderror
      </div>
      {{-- Form Lainnya --}}
      <div class="space-y-4">
      <div class="form-control flex flex-col w-full">
        <label class="label">
          <span class="label-text">Nama Lengkap</span>
        </label>
        <input type="text" class="input input-bordered w-full" wire:model="editingFullName" />
        @error('editingFullName')
          <span class="text-error text-xs mt-1">{{ $message }}</span>
        @enderror
      </div>
      <div class="form-control flex flex-col w-full">
        <label class="label"><span class="label-text">email</span></label>
        <input type="text" class="input input-bordered w-full" wire:model="editingEmail" />
        @error('editingEmail')
          <span class="text-error text-xs mt-1">{{ $message }}</span>
        @enderror
      </div>
      <div class="form-control flex flex-col w-full">
        <label class="label"><span class="label-text">Role</span></label>
        <select class="select select-bordered w-full" wire:model="editingRole">
          <option value="mentor">mentor</option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <div class="form-control flex flex-col w-full">
        <label class="label">
          <span class="label-text">Password Baru (Opsional)</span>
        </label>
        <input type="password" placeholder="Isi untuk mengubah" class="input input-bordered w-full"
          wire:model="editingPassword" />
        @error('editingPassword')
          <span class="text-error text-xs mt-1">{{ $message }}</span>
        @enderror
      </div>
      <div class="form-control flex flex-col w-full">
        <label class="label">
          <span class="label-text">Konfirmasi Password Baru</span>
        </label>
        <input type="password" placeholder="Ulangi password baru" class="input input-bordered w-full"
          wire:model="editingPassword_confirmation" />
      </div>
      <div class="modal-action">
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <button type="button" class="btn" @click="$wire.showEditModal = false">Batal</button>
      </div>
      </div>
    </form>
  </x-modal>

  {{-- MODAL UNTUK RESET PASSWORD --}}
  <x-modal id="reset-password-modal" title="Reset Password"
    subtitle="Reset password untuk user {{ $resetingUser?->email }}" :separator="true" boxClass="max-w-md"
    :persistent="false" wire:model="showResetPasswordModal">
    <form wire:submit="doResetPassword" class="space-y-4">
      <div class="form-control flex flex-col">
        <label class="label">
          <span class="label-text">Password Baru</span>
        </label>
        <input type="password" placeholder="Minimal 6 karakter" class="input input-bordered w-full"
          wire:model="resetPassword" />
        @error('resetPassword')
          <span class="text-error text-xs mt-1">{{ $message }}</span>
        @enderror
      </div>
      <div class="form-control flex flex-col">
        <label class="label">
          <span class="label-text">Konfirmasi Password Baru</span>
        </label>
        <input type="password" placeholder="Ulangi password baru" class="input input-bordered w-full"
          wire:model="resetPassword_confirmation" />
      </div>
      <div class="modal-action">
        <button type="submit" class="btn btn-primary">Reset Password</button>
        <button type="button" class="btn" @click="$wire.showResetPasswordModal = false">Batal</button>
      </div>
    </form>
  </x-modal>
</div>
