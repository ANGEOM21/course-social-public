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
            'title'        => 'Pengenalan dan Penggunaan Termux',
            'description'  => 'Di video ini, kita bakal bahas:  
                            Apa itu Termux dan cara instalasinya  
                            ৹ Perintah dasar Termux yang wajib kamu tahu  
                            ৹ Instalasi paket & tools keren di Termux  
                            ৹ Tips & trik biar makin jago pakai Termux  ',
            'video_url'    => 'https://www.youtube.com/watch?v=g45tb8xiAMc&list=PLZdIFbZaon3_xkw5D6m7RDphMwHUsT1cL',
        ]);
        TblModule::create([
            'course_id'    => 1,
            'title'        => 'Setup Termux dan Instalasi tools yang lain',
            'description'  => 'Termux adalah aplikasi emulator terminal yang bisa mengubah HP Android kamu jadi mesin Linux mini! Dengan Termux, kamu bisa menjalankan perintah Linux, install berbagai tools keren, bahkan belajar pentesting & ethical hacking langsung dari genggaman!',
            'video_url'    => 'https://www.youtube.com/watch?v=OsmojMva7RE&list=PLZdIFbZaon3_xkw5D6m7RDphMwHUsT1cL&index=2',
        ]);
        TblModule::create([
            'course_id'    => 1,
            'title'        => 'Installasi web server apache di termux beserta php include phpmyadmin',
            'description'  => 'Tutorial ini menjelaskan langkah-langkah instalasi web server Apache di Termux secara lengkap di Android. Sangat cocok buat kamu yang ingin belajar web development langsung dari HP tanpa perlu laptop atau PC. Cukup dengan Termux, kamu bisa menjalankan server lokal dan mulai belajar HTML, PHP, dan lainnya.',
            'video_url'    => 'https://www.youtube.com/watch?v=Yx69aVCDAtA&list=PLZdIFbZaon3_xkw5D6m7RDphMwHUsT1cL&index=3',
        ]);

        TblModule::create([
            'course_id'    => 2,
            'title'        => 'UI Basics',
            'description'  => 'Dasar-dasar User Interface.',
            'video_url'    => 'https://youtube.com/example2',
        ]);
    }
}
