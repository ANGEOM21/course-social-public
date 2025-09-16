<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::where('student_certificate', Auth::id())->get();
        return view('certificates.index', compact('certificates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file'  => 'nullable|file|mimes:pdf,png,jpg,jpeg',
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('certificates', 'public');
        }

        Certificate::create([
            'student_certificate' => Auth::id(),
            'title' => $request->title,
            'file'  => $path,
        ]);

        return redirect()->route('certificates.index')
                         ->with('success', 'Sertifikat berhasil ditambahkan!');
    }
}
