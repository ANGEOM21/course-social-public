<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TblEnrollment;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        TblEnrollment::create([
            'student_id' => 1,
            'course_id'  => 1,
        ]);

        TblEnrollment::create([
            'student_id' => 2,
            'course_id'  => 2,
        ]);
    }
}
