<?php

use App\Models\Perdes;
use App\Models\Perkades;
use App\Models\SkKades;
use App\Models\RegisterBpd; // PASTIKAN NAMA MODEL BPD INI BENAR
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Masmerise\Toaster\Toastable;

new class extends Component {
    use WithPagination, WithFileUploads, Toastable;

    // --- STATE UTAMA ---
    public string $activeTab = 'PERDES';
    public ?int $editingId = null; // Menyimpan ID dari record yang sedang diedit
    public ?string $existingFilePath = null;

    // --- FORM PROPERTIES ---
    #[Rule('required|string|max:100')]
    public string $nomor_peraturan = '';

    #[Rule('required|string')]
    public string $tentang = '';

    #[Rule('required|date')]
    public string $tanggal_dikeluarkan = '';

    #[Rule('nullable|file|mimes:pdf,jpg,jpeg|max:2048')]
    public $file; // Tipe mixed untuk file upload

    public function mount(): void
    {
        $this->resetForm();
    }

    // --- COMPUTED PROPERTIES ---
    #[Computed]
    public function peraturan()
    {
        $modelClass = $this->getModelClass();

        return $modelClass
            ::query()
            ->orderBy('tanggal', 'desc') // Sesuaikan dengan nama kolom tanggal di DB lo
            ->orderBy('id', 'desc')
            ->paginate(10, ['*'], 'peraturanPage'); // Beri nama unik untuk paginator
    }

    #[Computed]
    public function title(): string
    {
        return match ($this->activeTab) {
            'PERDES' => 'Peraturan Desa (PERDES)',
            'PERKADES' => 'Peraturan Kepala Desa (PERKADES)',
            'SK_KADES' => 'Surat Keputusan Kepala Desa (SK KADES)',
            'BPD' => 'Register BPD',
            default => 'Register Peraturan',
        };
    }

    // --- HELPER METHOD ---
    protected function getModelClass(): string
    {
        return match ($this->activeTab) {
            'PERDES' => Perdes::class,
            'PERKADES' => Perkades::class,
            'SK_KADES' => SkKades::class,
            'BPD' => RegisterBpd::class,
        };
    }

    // --- AKSI / METHODS ---
    public function changeTab(string $tabName): void
    {
        $this->activeTab = $tabName;
        $this->resetPage('peraturanPage');
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->reset('nomor_peraturan', 'tentang', 'file', 'editingId', 'existingFilePath');
        $this->tanggal_dikeluarkan = now()->format('Y-m-d');
        $this->resetErrorBag();
    }

    public function edit(int $id): void
    {
        $modelClass = $this->getModelClass();
        $peraturan = $modelClass::find($id);

        if ($peraturan) {
            $this->editingId = $peraturan->id;
            $this->nomor_peraturan = $peraturan->nomor; // Sesuai kode native: 'nomor'
            $this->tentang = $peraturan->tentang;
            $this->tanggal_dikeluarkan = $peraturan->tanggal; // Sesuai kode native: 'tanggal'
            $this->existingFilePath = $peraturan->file_path;
            $this->reset('file');
            $this->resetErrorBag();
        }
    }

    public function save(): void
    {
        // Validasi, file wajib hanya jika membuat record baru (editingId null)
        $this->validate([
            'file' => $this->editingId ? 'nullable|file|mimes:pdf,jpg,jpeg|max:2048' : 'required|file|mimes:pdf,jpg,jpeg|max:2048',
        ]);

        $modelClass = $this->getModelClass();

        $data = [
            'nomor' => $this->nomor_peraturan,
            'tentang' => $this->tentang,
            'tanggal' => $this->tanggal_dikeluarkan,
        ];

        if ($this->file) {
            // Hapus file lama jika ada saat update
            if ($this->editingId && $this->existingFilePath) {
                Storage::disk('public')->delete($this->existingFilePath);
            }
            // Simpan file ke storage/app/public/peraturan-desa/[jenis_peraturan]
            $data['file_path'] = $this->file->store('peraturan-desa/' . strtolower($this->activeTab), 'public');
        }

        // updateOrCreate menangani INSERT dan UPDATE
        $modelClass::updateOrCreate(['id' => $this->editingId], $data);

        $this->success($this->editingId ? 'Data berhasil diperbarui.' : 'Data berhasil ditambahkan.');
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        $modelClass = $this->getModelClass();
        $peraturan = $modelClass::find($id);

        if ($peraturan) {
            if ($peraturan->file_path) {
                Storage::disk('public')->delete($peraturan->file_path);
            }
            $peraturan->delete();
            $this->success('Data berhasil dihapus.');
        } else {
            $this->error('Data tidak ditemukan.');
        }
    }
}; ?>

<div>
  <title>Register Peraturan {{ $app_name }}</title>
  <div class="md:p-4 sm:p-2 px-1 py-2">
    <div class="sm:flex sm:items-center sm:justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-800">
          <i class="fa fa-file-alt mr-2"></i>
          Register Peraturan Desa
        </h1>
        <p class="mt-1 text-sm text-gray-600">
          Manajemen Peraturan Desa, Peraturan Kepala Desa, SK Kades, dan Register BPD.
        </p>
      </div>
    </div>

    <div class="mt-6">
      {{-- TABS NAVIGASI --}}
      <div class="tabs tabs-boxed">
        <a @class(['tab text-xs sm:text-sm', 'tab-active' => $activeTab === 'PERDES']) wire:click="changeTab('PERDES')">PERDES</a>
        <a @class(['tab text-xs sm:text-sm', 'tab-active' => $activeTab === 'PERKADES']) wire:click="changeTab('PERKADES')">PERKADES</a>
        <a @class(['tab text-xs sm:text-sm', 'tab-active' => $activeTab === 'SK_KADES']) wire:click="changeTab('SK_KADES')">SK KADES</a>
        <a @class(['tab text-xs sm:text-sm', 'tab-active' => $activeTab === 'BPD']) wire:click="changeTab('BPD')">BPD</a>
      </div>

      <div class="mt-6 grid grid-cols-1 gap-6">
        {{-- KOLOM FORM INPUT --}}
        <div class="col-span-1">
          <div class="card bg-base-100 shadow-lg">
            <form wire:submit="save" class="card-body">
              <h2 class="card-title text-base">
                <i class="fa fa-plus-circle text-primary"></i>
                {{ $editingId ? 'Edit Data ' . str_replace('_', ' ', $activeTab) : 'Tambah Data ' . str_replace('_', ' ', $activeTab) }}
              </h2>

              <div class="form-control">
                <label class="label"><span class="label-text">Nomor Peraturan</span></label>
                <input type="text" wire:model="nomor_peraturan" class="input input-bordered"
                  placeholder="Contoh: 01/{{ str_replace('_', ' ', $activeTab) }}/2024">
                @error('nomor_peraturan')
                  <span class="text-error text-xs mt-1">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-control">
                <label class="label"><span class="label-text">Tentang</span></label>
                <textarea wire:model="tentang" class="textarea textarea-bordered" rows="3" placeholder="Judul/Perihal Peraturan"></textarea>
                @error('tentang')
                  <span class="text-error text-xs mt-1">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-control">
                <label class="label"><span class="label-text">Tanggal Dikeluarkan</span></label>
                <input type="date" wire:model="tanggal_dikeluarkan" class="input input-bordered">
                @error('tanggal_dikeluarkan')
                  <span class="text-error text-xs mt-1">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-control">
                <label class="label"><span class="label-text">Upload File (PDF/JPG)</span></label>
                <input type="file" wire:model="file" class="file-input file-input-bordered file-input-sm w-full">
                <div wire:loading wire:target="file" class="text-sm mt-1">Mengunggah...</div>
                @if ($existingFilePath && !$file)
                  <div class="text-xs mt-2">File saat ini: <a href="{{ Storage::url($existingFilePath) }}"
                      target="_blank" class="link link-primary">Lihat File</a></div>
                @endif
                @error('file')
                  <span class="text-error text-xs mt-1">{{ $message }}</span>
                @enderror
              </div>

              <div class="card-actions justify-end mt-4">
                @if ($editingId)
                  <button type="button" wire:click="resetForm" class="btn btn-ghost">Batal Edit
                  </button>
                @endif
                <button type="submit" class="btn btn-primary">
                  <span wire:loading.remove wire:target="save"><i class="fa fa-save"></i> Simpan</span>
                  <span wire:loading wire:target="save" class="loading loading-spinner loading-xs"></span>
                </button>
              </div>
            </form>
          </div>
        </div>

        {{-- KOLOM TABEL DATA --}}
        <div class="col-span-1">
          <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
              <h2 class="card-title text-base mb-4">
                <i class="fa fa-list"></i> Daftar {{ $this->title }}
              </h2>
              <div class="overflow-x-auto">
                <table class="table table-zebra table-sm">
                  <thead class="bg-base-200">
                    <tr>
                      <th>No</th>
                      <th>Nomor</th>
                      <th>Tentang</th>
                      <th>Tanggal</th>
                      <th>File</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($this->peraturan as $item)
                      <tr wire:key="{{ $activeTab }}-{{ $item->id }}">
                        <td>{{ $loop->iteration + $this->peraturan->firstItem() - 1 }}</td>
                        {{-- Sesuaikan nama kolom dengan yang ada di model/DB --}}
                        <td>{{ $item->nomor }}</td>
                        <td>{{ Str::limit($item->tentang, 50) }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                        <td>
                          @if ($item->file_path)
                            <a href="{{ Storage::url($item->file_path) }}" target="_blank"
                              class="btn btn-xs btn-outline btn-info">Lihat</a>
                          @else
                            -
                          @endif
                        </td>
                        <td>
                          <div class="flex gap-1">
                            <button wire:click="edit({{ $item->id }})" class="btn btn-xs btn-warning">Edit</button>
                            <button wire:click="delete({{ $item->id }})"
                              wire:confirm="Anda yakin ingin menghapus data ini?"
                              class="btn btn-xs btn-error">Hapus</button>
                          </div>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="6" class="text-center">Belum ada data untuk kategori ini.</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <div class="mt-4">{{ $this->peraturan->links('pagination::daisyui') }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
