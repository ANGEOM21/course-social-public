<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TblProgress;

class ProgressSeeder extends Seeder
{
    public function run(): void
    {
        TblProgress::create([
            'student_id' => 1,
            'course_id'  => 1,
            'module_id' => 1,
        ]);

        TblProgress::create([
            'student_id' => 2,
            'course_id'  => 2,
            'module_id' => 2,
        ]);
    }
}
