<?php

namespace App\Http\Controllers\Students;

use App\Models\TblCertificate;
use App\Models\TblCourse;
use App\Models\TblFeedback;
use App\Models\TblModule;
use App\Models\TblProgress;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Mpdf\Mpdf;

class CourseWatch extends Component
{
    use Toastable;
    /** @var \App\Models\TblCourse $course */
    public TblCourse $course;

    /** @var \App\Models\TblModule $activeModule */
    public TblModule $activeModule;

    /** @var Collection<int, TblModule> */
    public Collection $allModules;

    /** @var Collection<int, TblModule> */
    public Collection $completedModules;

    /** @var array<int> */
    public array $completedModulesIds = [];

    /** @var bool */
    public bool $isCourseCompleted = false;

    /** @var ?TblModule $nextModule */
    public ?TblModule $nextModule = null;

    // melacak apakah siswa sudah memberi feedback
    public bool $hasGivenFeedback = false;

    public string $link_sertifkat = '';

    // Properti untuk menyimpan rating dan deskripsi feedback
    #[Rule('required|integer|between:1,5')]
    public int $rating = 0;

    #[Rule('nullable|string|max:500')]
    public string $feedback_description = '';


    /**
     * Method `mount` akan dipanggil sekali saat komponen dimuat
     * 
     * @param \App\Models\TblCourse $course
     * @param string $module
     * @return void
     */
    public function mount(TblCourse $course, $module): void
    {

        $module = TblModule::where('slug', $module)->where('course_id', $course->id_course)->firstOrFail();

        $this->course = $course->load(['tbl_category', 'tbl_admin']);
        $this->activeModule = $module;

        /** @var \App\Models\TblStudent $user */
        $user = Auth::guard('web')->user();

        if (!$user->tbl_courses()->where('tbl_courses.id_course', $this->course->id_course)->exists()) {
            abort(403, 'Anda tidak terdaftar di kursus ini.');
        }

        $this->loadPlaylistAndProgress();
        $this->checkIfHasFeedback();
    }

    /**
     * Mengambil daftar modul dan progres penyelesaian modul siswa di kursus ini
     * 
     * Method ini akan mengambil daftar modul yang ada di kursus ini dan
     * mengumpulkan ID modul yang sudah diselesaikan siswa di kursus ini.
     * Kemudian, method ini akan mencari modul berikutnya yang belum diselesaikan
     * dan mengatur nilai `$this->nextModule`.
     * 
     * @return void
     */
    public function loadPlaylistAndProgress(): void
    {
        /** @var \App\Models\TblStudent $student */
        $student = Auth::user();

        $this->allModules = $this->course->tbl_modules()->orderBy('created_at', 'asc')->get();

        // Ambil semua ID modul yang sudah diselesaikan siswa di kursus ini
        $this->completedModulesIds = TblProgress::where('student_id', $student->id_student)
            ->where('course_id', $this->course->id_course)
            ->pluck('module_id')
            ->toArray();

        // Cari modul berikutnya
        $currentModuleIndex = $this->allModules->search(fn($m) => $m->id_module == $this->activeModule->id_module);
        if ($currentModuleIndex !== false && $currentModuleIndex + 1 < $this->allModules->count()) {
            $this->nextModule = $this->allModules[$currentModuleIndex + 1];
        } else {
            $this->nextModule = null;
        }

        $this->checkIfCourseCompleted();
    }

    /**
     * Menandai modul yang sedang diakses sebagai sudah diselesaikan
     *
     * Method ini akan menandai modul yang sedang diakses sebagai sudah diselesaikan
     * dan mengupdate nilai `$this->completedModulesIds` dengan ID modul yang sedang diakses.
     *
     * @return void
     */
    #[On('markAsComplete')]
    public function markAsComplete(): void
    {
        /** @var \App\Models\TblStudent $student */
        $student = Auth::guard('web')->user();

        TblProgress::firstOrCreate([
            'student_id' => $student->id_student,
            'course_id' => $this->course->id_course,
            'module_id' => $this->activeModule->id_module,
        ]);

        if (!in_array($this->activeModule->id_module, $this->completedModulesIds)) {
            $this->completedModulesIds[] = $this->activeModule->id_module;
            $this->checkIfCourseCompleted();
        }

        $this->success("Modul " . $this->activeModule->title . " telah ditandai sebagai selesai.");
    }

    public function checkIfCourseCompleted(): void
    {
        $totalModulesCount = $this->allModules->count();
        $completedModulesCount = count($this->completedModulesIds);

        // Kursus dianggap selesai jika jumlah modul > 0 dan semua sudah diselesaikan
        if ($totalModulesCount > 0 && $totalModulesCount === $completedModulesCount) {
            $this->isCourseCompleted = true;
            $this->generateAndSaveCertificate();
            $this->checkIfHasFeedback();
        } else {
            $this->isCourseCompleted = false;
        }
    }


    public function checkIfHasFeedback(): void
    {
        $this->hasGivenFeedback = TblFeedback::where('student_id', Auth::id())
            ->where('course_id', $this->course->id_course)
            ->exists();
    }

    public function submitFeedback(): void
    {
        $this->validate();

        TblFeedback::updateOrCreate(
            [
                'student_id' => Auth::id(),
                'course_id' => $this->course->id_course,
            ],
            [
                'rating' => $this->rating,
                'description' => $this->feedback_description,
            ]
        );

        $this->hasGivenFeedback = true; // Langsung update UI
        $this->success('Terima kasih atas ulasan Anda!');
    }


    public function generateAndSaveCertificate(): void
    {
        /** @var \App\Models\TblStudent $student */
        $student = Auth::user();
        $course = $this->course;

        // Cek dulu apakah sertifikat sudah ada untuk menghindari duplikat
        $sertifikat = TblCertificate::where('student_id', $student->id_student)
            ->where('course_id', $course->id_course);
        $existingCertificate = $sertifikat->exists();

        if ($existingCertificate) {
            $this->link_sertifkat = $sertifikat->first()->file_path;
            return;
        }

        try {
            // Siapkan data untuk template
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

            // Inisialisasi mPDF
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4-L',
                'margin_left' => 0,
                'margin_right' => 0,
                'margin_top' => 0,
                'margin_bottom' => 0,
                'tempDir' => storage_path('app/temp/mpdf'),
                'fontDir' => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], [public_path('fonts/Alex_Brush')]),
                'fontdata' => (new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'] + ['alexbrush' => ['R' => 'AlexBrush-Regular.ttf']],
                'default_font' => 'timesnewroman',
            ]);

            $mpdf->WriteHTML($html);

            $fileName = 'cert-' . $student->id_student . '-' . $course->slug . '.pdf';
            $filePath = 'certificates/' . $fileName;

            Storage::disk('public')->put($filePath, $mpdf->Output($fileName, 'S'));

            // Catat sertifikat di database
            TblCertificate::create([
                'student_id' => $student->id_student,
                'course_id' => $course->id_course,
                'title' => 'Sertifikat Penyelesaian: ' . $course->name_course,
                'file_path' => $filePath,
            ]);

            // Beri notifikasi ke siswa
            $this->success('Selamat! Sertifikat untuk kursus ini telah dibuat.');
        } catch (\Exception $e) {
            // Tangani error jika terjadi
            $this->error('Gagal membuat sertifikat: ' . $e->getMessage());
        }
    }


    /**
     * Redirect ke halaman berikutnya setelah menyelesaikan modul saat ini
     *
     * Method ini akan meredirect ke halaman berikutnya setelah menyelesaikan modul saat ini.
     * Jika modul berikutnya tidak ada, maka tidak akan terjadi redirect.
     *
     * @return void
     */
    public function goToNextModule(): void
    {
        $param = [
            'course' => $this->course->slug,
            'module' => $this->nextModule->slug,
        ];
        if ($this->nextModule) {
            $this->redirect(route('student.courses.watch', $param), navigate: true);
        }
    }

    /**
     * Mengambil ID video YouTube dari URL video YouTube yang diberikan.
     * 
     * Method ini akan mengembalikan ID video YouTube jika URL video YouTube yang diberikan valid.
     * Jika URL video YouTube yang diberikan tidak valid, maka method ini akan mengembalikan null.
     * 
     * @param string|null $url URL video YouTube yang ingin diambil ID-nya.
     * @return string|null ID video YouTube jika URL video YouTube yang diberikan valid, null jika tidak valid.
     */
    public function getYoutubeId(?string $url): ?string
    {
        if (!$url) return null;
        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|v/|shorts/))([A-Za-z0-9_-]{6,})~', $url, $m)) {
            return $m[1];
        }
        return null;
    }


    public function render()
    {
        return view('pages.students.courses.watch', [
            'title' => 'Menonton: ' . $this->activeModule->title
        ]);
    }
}
