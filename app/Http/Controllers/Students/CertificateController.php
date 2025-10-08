<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\TblCourse;
use App\Models\TblProgress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;

class CertificateController extends Controller
{
    public function __invoke(TblCourse $course)
    {
        /** @var \App\Models\TblStudent $student */
        $student = Auth::user();

        // Verifikasi
        $isEnrolled = $student->tbl_courses()->where('tbl_courses.id_course', $course->id_course)->exists();
        if (!$isEnrolled) {
            abort(403, 'Anda tidak terdaftar di kursus ini.');
        }
        $totalModules = $course->tbl_modules()->count();
        $completedModules = TblProgress::where('student_id', $student->id_student)->where('course_id', $course->id_course)->distinct('module_id')->count();
        $isCompleted = ($totalModules > 0 && $completedModules >= $totalModules) || $totalModules == 0;
        if (!$isCompleted) {
            abort(403, 'Anda belum menyelesaikan kursus ini.');
        }

        try {
            // Siapkan Data Teks & Gambar Base64
            $replace = [
                '{logo}' => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('logo-sertifikat.png'))),
                '{ttd_siraj}' => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('ttd-siraj.png'))),
                '{ttd_angeom}' => 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('ttd-angeom.png'))),
                '{nama_student}' => $student->name_student,
                '{course}' => $course->name_course,
                '{tanggal}' => now()->translatedFormat('d F Y'),
                '{mentor}' => $course->tbl_admin->name_admin ?? 'Manajemen',
                '{kode_course}' => 'SR-' . strtoupper(substr($course->slug, 0, 4)) . '-' . $course->id_course,
            ];

            $template = file_get_contents(public_path('template/sertifikat.html'));
            $html = str_replace(array_keys($replace), array_values($replace), $template);

            // Konfigurasi mPDF
            $defaultConfig = (new ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];
            $defaultFontConfig = (new FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4-L',
                'margin_left' => 0,
                'margin_right' => 0,
                'margin_top' => 0,
                'margin_bottom' => 0,
                'tempDir' => storage_path('app/temp/mpdf'),
                'fontDir' => array_merge($fontDirs, [
                    public_path('fonts/Great_Vibes'),
                    public_path('fonts/Alex_Brush')
                ]),
                'fontdata' => $fontData + [
                    'alexbrush' => ['R' => 'AlexBrush-Regular.ttf'],
                    'greatvibes' => [
                        'R' => 'GreatVibes-Regular.ttf',
                    ],
                ],
                'default_font' => 'timesnewroman',
            ]);

            $mpdf->WriteHTML($html);

            // [PERBAIKAN UTAMA DI SINI]
            // 1. Simpan PDF ke file sementara
            $tempPath = storage_path('app/temp/certificates');
            if (!File::isDirectory($tempPath)) {
                File::makeDirectory($tempPath, 0755, true, true);
            }
            $fileName = 'sertifikat-' . $course->slug . '-' . uniqid() . '.pdf';
            $filePath = $tempPath . '/' . $fileName;

            $mpdf->Output($filePath, 'F'); // 'F' untuk menyimpan ke file

            // 2. Kirim file untuk diunduh dan hapus setelahnya
            return response()->download($filePath, 'sertifikat-' . $course->slug . '.pdf')->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return response('Gagal membuat sertifikat PDF: ' . $e->getMessage(), 500);
        }
    }
}
