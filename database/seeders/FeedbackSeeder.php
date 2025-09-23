<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TblFeedback;

class FeedbackSeeder extends Seeder
{
    public function run(): void
    {
        TblFeedback::create([
            'student_id'   => 1,
            'course_id'    => 1,
            'rating'       => 5,
            'description'  => 'Mantap, jelas banget!',
        ]);

        TblFeedback::create([
            'student_id'   => 2,
            'course_id'    => 2,
            'rating'       => 4,
            'description'  => 'Bagus tapi perlu lebih banyak contoh.',
        ]);
    }
}
