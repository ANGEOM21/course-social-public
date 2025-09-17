<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Course;

class ExampleDataSeeder extends Seeder
{
    /**
     * Jalankan seeder contoh data
     */
    public function run(): void
    {
        // === USER ===
        $mentor = User::create([
            'name_user'  => 'Mentor Satu',
            'email_user' => 'mentor@example.com',
            'role_user'  => 'mentor',
            'password'   => bcrypt('password'),
        ]);

        $student = User::create([
            'name_user'  => 'Student Satu',
            'email_user' => 'student@example.com',
            'role_user'  => 'student',
            'password'   => bcrypt('password'),
        ]);

        // === CATEGORY ===
        $programming = Category::create([
            'name_category' => 'Programming',
            'img_category'  => 'https://via.placeholder.com/150?text=Programming',
        ]);

        $design = Category::create([
            'name_category' => 'Design',
            'img_category'  => 'https://via.placeholder.com/150?text=Design',
        ]);

        // === COURSE ===
        Course::create([
            'name_course'     => 'Belajar Laravel Dasar',
            'desc_course'     => 'Kursus untuk mempelajari dasar framework Laravel.',
            'mentor_course'   => $mentor->id_user,   // 🔑 pakai mentor_course
            'category_course' => $programming->id_category,
        ]);

        Course::create([
            'name_course'     => 'UI/UX Design Pemula',
            'desc_course'     => 'Belajar dasar-dasar desain UI/UX untuk aplikasi.',
            'mentor_course'   => $mentor->id_user,
            'category_course' => $design->id_category,
        ]);
    }
}
