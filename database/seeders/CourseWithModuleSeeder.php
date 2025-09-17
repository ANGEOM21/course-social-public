<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Module;

class CourseWithModuleSeeder extends Seeder
{
    public function run(): void
    {
        // Buat course contoh
        $course = Course::create([
            'name_course'     => 'Belajar Laravel Dasar',
            'desc_course'     => 'Kursus pengantar Laravel untuk pemula.',
            'mentor_course'   => 1, // pastikan ada user dengan id_user=1 sebagai mentor
            'category_course' => 1, // pastikan ada kategori dengan id_category=1
        ]);

        // Buat module pertama
        Module::create([
            'course_id'   => $course->id_course,
            'title_module'=> 'Pengenalan Laravel',
            'desc_module' => 'Dasar-dasar framework Laravel.',
            'video_url'   => 'https://www.youtube.com/watch?v=Mz2syNhgFng',
        ]);

        // Buat module kedua
        Module::create([
            'course_id'   => $course->id_course,
            'title_module'=> 'Routing & Controller',
            'desc_module' => 'Belajar routing dan controller di Laravel.',
            'video_url'   => 'https://www.youtube.com/watch?v=WhzN9mXsI2o',
        ]);
    }
}
