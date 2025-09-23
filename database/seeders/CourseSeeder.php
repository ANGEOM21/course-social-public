<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TblCourse;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        TblCourse::create([
            'name_course'   => 'Laravel for Beginners',
            'desc_course'   => 'Belajar dasar-dasar Laravel.',
            'mentor_id'     => 2, // id_admin mentor
            'category_id'   => 1, // id_category Programming
        ]);

        TblCourse::create([
            'name_course'   => 'UI/UX Design Fundamentals',
            'desc_course'   => 'Belajar desain user experience.',
            'mentor_id'     => 2,
            'category_id'   => 2,
        ]);
    }
}
