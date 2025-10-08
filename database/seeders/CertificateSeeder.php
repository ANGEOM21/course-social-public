<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TblCertificate;

class CertificateSeeder extends Seeder
{
    public function run(): void
    {
        TblCertificate::create([
            'student_id' => 1,
            'course_id' => 1,
            'title'      => 'Completion Laravel Course',
            'file_path'  => 'certificates/laravel-alice.pdf',
        ]);

        TblCertificate::create([
            'student_id' => 2,
            'course_id' => 2,
            'title'      => 'Completion UI/UX Course',
            'file_path'  => 'certificates/uiux-bob.pdf',
        ]);
    }
}
