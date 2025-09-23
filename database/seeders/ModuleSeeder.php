<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TblModule;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        TblModule::create([
            'course_id'    => 1,
            'title'        => 'Intro to Laravel',
            'description'  => 'Pengenalan framework Laravel.',
            'video_url'    => 'https://youtube.com/example1',
        ]);

        TblModule::create([
            'course_id'    => 2,
            'title'        => 'UI Basics',
            'description'  => 'Dasar-dasar User Interface.',
            'video_url'    => 'https://youtube.com/example2',
        ]);
    }
}
