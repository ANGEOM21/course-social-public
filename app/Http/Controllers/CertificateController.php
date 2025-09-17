<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    /**
     * Tampilkan semua sertifikat milik user login
     */
    public function index()
    {
        $certificates = Certificate::where('student_certificate', Auth::id())->get();

        // ✅ konsisten pakai "certificates.index"
        return view('certificates.index', compact('certificates'));
    }

    /**
     * Simpan sertifikat baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file'  => 'required|mimes:pdf,jpg,png|max:2048',
        ]);

        // Upload file ke storage/app/public/certificates
        $path = $request->file('file')->store('certificates', 'public');

        Certificate::create([
            'student_certificate'  => Auth::id(),
            'course_certificate'   => $request->course_certificate ?? null,
            'category_certificate' => $request->category_certificate ?? null,
            'title'                => $request->title,
            'file_path'            => $path,
        ]);

        return redirect()->route('certificates.index')
                         ->with('success', 'Sertifikat berhasil ditambahkan!');
    }

    /**
     * Download sertifikat milik user login
     */
    public function download($id)
    {
        $certificate = Certificate::findOrFail($id);

        // Cegah akses oleh user lain
        if ($certificate->student_certificate !== Auth::id()) {
            abort(403);
        }

        return response()->download(
            storage_path('app/public/' . $certificate->file_path)
        );
    }
}
