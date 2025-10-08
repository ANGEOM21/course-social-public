<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Storage;
use Masmerise\Toaster\Toastable;

new class extends Component {
    use WithFileUploads, Toastable;

    // Properti untuk data binding
    public $student;

    #[Rule('required|string|max:255')]
    public string $name_student = ''; // Maksimal 2MB

    // Properti untuk upload foto baru
    #[Rule('nullable|image|max:2048')]
    public $newProfilePicture;

    // Method `mount` dijalankan sekali saat komponen dimuat
    public function mount(): void
    {
        $this->student = Auth::user();
        $this->name_student = $this->student->name_student;
    }

    // Method untuk menyimpan perubahan
    public function saveChanges(): void
    {
        $this->validate();

        $filePath = $this->student->img_student;

        // Cek jika ada foto baru yang diupload
        if ($this->newProfilePicture) {
            // Hapus foto lama jika ada
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            // Simpan foto baru dan dapatkan path-nya
            $filePath = $this->newProfilePicture->store('profile-pictures/students', 'public');
        }

        // Update data di database
        $this->student->update([
            'name_student' => $this->name_student,
            'img_student' => $filePath,
        ]);

        // Reset state upload dan kirim notifikasi
        $this->newProfilePicture = null;
        $this->success('Profil berhasil diperbarui!');

        // Dispatch event untuk me-refresh komponen lain jika perlu (misal, navbar)
        $this->dispatch('profile-updated');
    }
}; ?>

<div>
  <title>Profil Saya - {{ $app_name ?? 'Kursus Online' }}</title>

  {{-- Header Halaman --}}
  <section class="py-20 bg-gradient-to-l from-primary to-secondary text-base-100">
    <div class="container mx-auto px-4">
      <h1 class="text-3xl font-bold">Profil Saya</h1>
      <p class="text-lg lg:text-xl text-base-100/70 mt-2">Kelola informasi akun dan preferensi Anda di sini.</p>
    </div>
  </section>

  {{-- Konten Utama --}}
  <div class="container mx-auto -mt-14 p-4">
    <div class="card bg-base-100 relative shadow-lg border border-base-300 max-w-2xl mx-auto rounded-2xl">
      <div class="card-body -mt-16">
        <form wire:submit="saveChanges" class="space-y-6">
          {{-- [BAGIAN UPLOAD FOTO PROFIL] --}}
          <div class="flex flex-col items-center gap-4">
            <div class="relative">
              <div class="avatar">
                <div class="w-32 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                  {{-- Tampilkan preview jika ada foto baru, jika tidak, tampilkan foto yang ada --}}
                  @if ($newProfilePicture)
                    <img src="{{ $newProfilePicture->temporaryUrl() }}" />
                  @else
                    @php
                      $imageUrl =
                          $student->img_student ??
                          'https://ui-avatars.com/api/?name=' .
                              urlencode($student->name_student ?? ($student->name ?? 'stude$student')) .
                              '&size=50';
                      $fallback =
                          'https://ui-avatars.com/api/?name=' .
                          urlencode($student->name_student ?? ($student->name ?? 'stude$student'));
                    @endphp
                    <img src="{{ $imageUrl }}" alt="User Avatar" loading="lazy" referrerpolicy="no-referrer"
                      decoding="async" onerror="this.onerror=null;this.src='{{ $fallback }}';" @endif
                      />
                </div>
              </div>
              {{-- Tombol upload dengan ikon kamera --}}
              <label for="profile-picture-upload"
                class="btn btn-sm btn-circle btn-primary absolute bottom-0 right-0 shadow-md cursor-pointer">
                <i class="fa-solid fa-camera"></i>
              </label>
              {{-- Input file yang disembunyikan --}}
              <input type="file" id="profile-picture-upload" wire:model="newProfilePicture" class="hidden">
            </div>
            <div wire:loading wire:target="newProfilePicture" class="text-sm text-primary">Mengunggah...</div>
            @error('newProfilePicture')
              <span class="text-error text-xs">{{ $message }}</span>
            @enderror
          </div>

          {{-- Divider --}}
          <div class="divider">Informasi Akun</div>

          {{-- Form Nama --}}
          <div class="form-control w-full">
            <label class="label"><span class="label-text font-semibold">Nama Lengkap</span></label>
            <input type="text" wire:model="name_student" class="input input-bordered w-full" />
            @error('name_student')
              <span class="text-error text-xs mt-1">{{ $message }}</span>
            @enderror
          </div>

          {{-- Info Email (tidak bisa diubah) --}}
          <div class="form-control w-full">
            <label class="label"><span class="label-text font-semibold">Alamat Email</span></label>
            <input type="email" value="{{ $student->email_student }}" class="input input-bordered w-full bg-base-200"
              disabled />
            <label class="label"><span class="label-text-alt">Email tidak dapat diubah.</span></label>
          </div>

          {{-- Info Member Since --}}
          <div class="form-control w-full">
            <label class="label"><span class="label-text font-semibold">Bergabung Sejak</span></label>
            <input type="text" value="{{ $student->created_at->translatedFormat('d F Y') }}"
              class="input input-bordered w-full bg-base-200" disabled />
          </div>

          {{-- Tombol Simpan --}}
          <div class="card-actions justify-end pt-4">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
              <span wire:loading.remove>Simpan Perubahan</span>
              <span wire:loading class="loading loading-spinner loading-sm"></span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
