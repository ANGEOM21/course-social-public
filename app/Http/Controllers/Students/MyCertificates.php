<?php
namespace App\Http\Controllers\Students;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyCertificates extends Component
{
    public function render()
    {
        /** @var \App\Models\TblStudent $student */
        $student = Auth::user();

        // Ambil semua sertifikat milik siswa ini
        $certificates = $student->tbl_certificates()->with('tbl_course')->latest()->get();

        return view('pages.students.certificate.index', [
            'certificates' => $certificates,
            'title' => 'Sertifikat Saya',
        ]);
    }
}