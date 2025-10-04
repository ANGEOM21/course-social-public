<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\TblStudent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Masmerise\Toaster\Toastable;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

new class extends Component {
    use WithPagination, WithFileUploads, Toastable;

    public ?TblStudent $editingStudent = null;
    public string $editingFullName = '';
    public string $editingEmail = '';
    public string $editingPassword = '';
    public string $editingPassword_confirmation = '';
    public $newProfilePicture;

    public ?TblStudent $resetingStudent = null;
    public string $resetPassword = '';
    public string $resetPassword_confirmation = '';

    public bool $showEditModal = false;
    public bool $showResetPasswordModal = false;

    public function edit(TblStudent $student)
    {
        $this->editingStudent = $student;
        $this->editingFullName = $student->name_student; // Menggunakan 'name_student'
        $this->editingEmail = $student->email_student; // Menggunakan 'email_student'
        $this->newProfilePicture = null;
        $this->reset('editingPassword', 'editingPassword_confirmation');
        $this->resetErrorBag();
        $this->showEditModal = true; // Lebih baik menggunakan true/false langsung
    }

    public function updateStudent()
    {
        $validated = $this->validate([
            'editingFullName' => ['required', 'string', 'max:255'],
            'editingEmail' => ['required', 'string', 'max:50', Rule::unique('tbl_students', 'email_student')->ignore($this->editingStudent->id_student, 'id_student')],
            'editingPassword' => ['nullable', 'string', 'confirmed', Password::min(6)],
            'newProfilePicture' => ['nullable', 'image', 'max:5120'], // 5MB
        ]);

        $filePath = $this->editingStudent->img_student;
        if ($this->newProfilePicture) {
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $this->newProfilePicture->store('profile-pictures/students', 'public');
        }

        // Update data
        $this->editingStudent->update([
            'name_student' => $validated['editingFullName'],
            'email_student' => $validated['editingEmail'],
            'img_student' => $filePath,
        ]);

        if ($validated['editingPassword']) {
            $this->editingStudent->update(['password_student' => Hash::make($validated['editingPassword'])]);
        }

        $this->success('Data siswa berhasil diperbarui!');
        $this->showEditModal = false;
    }

    public function resetPwd(TblStudent $student)
    {
        $this->resetingStudent = $student;
        $this->reset('resetPassword', 'resetPassword_confirmation');
        $this->resetErrorBag();
        $this->showResetPasswordModal = true;
    }

    public function doResetPassword()
    {
        $validated = $this->validate([
            'resetPassword' => ['required', 'string', 'confirmed', Password::min(6)],
        ]);

        // Update dengan nama kolom password
        $this->resetingStudent->update(['password_student' => Hash::make($validated['resetPassword'])]);
        $this->success("Password untuk siswa {$this->resetingStudent->email_student} berhasil direset!");
        $this->showResetPasswordModal = false;
    }

    public function delete(TblStudent $student)
    {
        // Nama parameter disesuaikan
        // Hapus profil jika ada
        if ($student->img_student) {
            Storage::disk('public')->delete($student->img_student);
        }
        $student->delete();
        $this->success('Siswa berhasil dihapus!');
    }

    public function with(): array
    {
        // Query disesuaikan dengan model dan kolom TblStudent
        $students = TblStudent::orderBy('name_student', 'asc')->paginate(5);
        return ['students' => $students];
    }
}; ?>
<div>
  <div class="space-y-6">
    <div class="card bg-base-100 shadow">
      <div class="card-body">
        <h2 class="card-title text-lg"><i class="fa fa-users mr-2"></i>Daftar Akun Siswa</h2>
        <div class="overflow-x-auto mt-4">
          <table class="table table-zebra">
            <thead>
              <tr>
                <th>Nama Siswa</th>
                <th>Tanggal Daftar</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($students as $student)
                <tr wire:key="{{ $student->id_student }}">
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="avatar">
                        <div class="mask mask-squircle w-12 h-12">
                          @php
                            $imageUrl = $student->img_student
                                ? "$student->img_student?sz=50"
                                : 'https://ui-avatars.com/api/?name=' .
                                    urlencode($student->name_student) .
                                    '&background=random';
                          @endphp
                          <img src="{{ $imageUrl }}" alt="Avatar" locading="lazy" referrerpolicy="no-referrer" decoding="async" />
                        </div>
                      </div>
                      <div>
                        <div class="font-bold">{{ $student->name_student }}</div>
                        <div class="text-sm opacity-50">{{ $student->email_student }}</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="text-sm">{{ $student->created_at->translatedFormat('d F Y') }}</span>
                  </td>
                  <td class="text-center">
                    <div class="flex justify-center gap-2">
                      <button class="btn btn-xs btn-info text-white" wire:click="edit({{ $student->id_student }})"
                        title="Edit Siswa">
                        <i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-xs btn-secondary" wire:click="resetPwd({{ $student->id_student }})"
                        title="Reset Password">
                        <i class="fa fa-key"></i>
                      </button>
                      <button class="btn btn-xs btn-error"
                        wire:confirm.prompt="Anda yakin ingin menghapus siswa {{ $student->name_student }}?.\n\nKetik 'HAPUS' untuk konfirmasi.|HAPUS"
                        wire:click="delete({{ $student->id_student }})" title="Hapus Siswa">
                        <i class="fa fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="3" class="text-center py-4">Tidak ada data siswa.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="mt-4">{{ $students->links('pagination::daisyui') }}</div>
      </div>
    </div>
  </div>

  {{-- MODAL UNTUK EDIT SISWA --}}
  <x-modal id="edit-student-modal" title="Edit Data Siswa" subtitle="Ubah data untuk {{ $editingFullName }}"
    :separator="true" boxClass="max-w-lg" wire:model="showEditModal">
    <form wire:submit="updateStudent" class="space-y-4">
      <div class="flex flex-col justify-center items-center">
        <div class="relative w-32 h-32">
          <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-200 border shadow">
            @if ($newProfilePicture)
              <img src="{{ $newProfilePicture->temporaryUrl() }}" class="w-full h-full object-cover">
            @elseif ($editingStudent?->img_student)
              <img src="{{ $student->img_student }}" class="w-full h-full object-cover">
            @else
              <img src="https://ui-avatars.com/api/?name={{ urlencode($editingFullName) }}"
                class="w-full h-full object-cover">
            @endif
          </div>
          <label for="newProfilePicture"
            class="w-10 h-10 flex items-center justify-center absolute bottom-0 right-0 bg-white rounded-full border shadow p-1 cursor-pointer hover:bg-gray-100 transition">
            <i class="fa fa-camera text-sm"></i>
          </label>
          <input wire:model="newProfilePicture" type="file" id="newProfilePicture" accept="image/*" class="hidden">
        </div>
        @error('newProfilePicture')
          <span class="text-sm text-error mt-1 block">{{ $message }}</span>
        @enderror
      </div>

      {{-- INPUT NAMA LENGKAP --}}
      <div class="form-control w-full">
        <label class="label"><span class="label-text">Nama Lengkap</span></label>
        <input type="text" class="input input-bordered w-full" wire:model="editingFullName" />
        @error('editingFullName')
          <span class="text-error text-xs mt-1">{{ $message }}</span>
        @enderror
      </div>

      {{-- INPUT EMAIL --}}
      <div class="form-control w-full">
        <label class="label"><span class="label-text">Email</span></label>
        <input type="email" class="input input-bordered w-full" wire:model="editingEmail" />
        @error('editingEmail')
          <span class="text-error text-xs mt-1">{{ $message }}</span>
        @enderror
      </div>

      {{-- INPUT PASSWORD BARU --}}
      <div class="form-control w-full">
        <label class="label"><span class="label-text">Password Baru (Opsional)</span></label>
        <input type="password" placeholder="Isi untuk mengubah" class="input input-bordered w-full"
          wire:model="editingPassword" />
        @error('editingPassword')
          <span class="text-error text-xs mt-1">{{ $message }}</span>
        @enderror
      </div>

      {{-- INPUT KONFIRMASI PASSWORD --}}
      <div class="form-control w-full">
        <label class="label"><span class="label-text">Konfirmasi Password Baru</span></label>
        <input type="password" placeholder="Ulangi password baru" class="input input-bordered w-full"
          wire:model="editingPassword_confirmation" />
      </div>

      <x-slot:actions>
        <button type="button" class="btn" @click="$wire.set('showEditModal', false)">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </x-slot:actions>
    </form>
  </x-modal>

  {{-- MODAL UNTUK RESET PASSWORD --}}
  <x-modal id="reset-password-modal" title="Reset Password"
    subtitle="Reset password untuk siswa {{ $resetingStudent?->email_student }}" :separator="true" boxClass="max-w-md"
    wire:model="showResetPasswordModal">
    <form wire:submit="doResetPassword" class="space-y-4">

      {{-- INPUT PASSWORD BARU --}}
      <div class="form-control w-full">
        <label class="label"><span class="label-text">Password Baru</span></label>
        <input type="password" placeholder="Minimal 6 karakter" class="input input-bordered w-full"
          wire:model="resetPassword" />
        @error('resetPassword')
          <span class="text-error text-xs mt-1">{{ $message }}</span>
        @enderror
      </div>

      {{-- INPUT KONFIRMASI PASSWORD BARU --}}
      <div class="form-control w-full">
        <label class="label"><span class="label-text">Konfirmasi Password Baru</span></label>
        <input type="password" placeholder="Ulangi password baru" class="input input-bordered w-full"
          wire:model="resetPassword_confirmation" />
      </div>

      <x-slot:actions>
        <button type="button" class="btn" @click="$wire.set('showResetPasswordModal', false)">Batal</button>
        <button type="submit" class="btn btn-primary">Reset Password</button>
      </x-slot:actions>
    </form>
  </x-modal>
</div>
