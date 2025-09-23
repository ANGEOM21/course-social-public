<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\TblAdmin;
use App\Models\TblStudent;

class AdminStudentSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        // Admin
        TblAdmin::create([
            'name_admin'       => 'Super Admin',
            'email_admin'      => 'admin@example.com',
            'password_admin'   => Hash::make('password123'),
            'role'             => 'admin',
            'img_admin'        => null,
            'access_token_admin' => null,
        ]);

        // Mentor
        TblAdmin::create([
            'name_admin'       => 'John Mentor',
            'email_admin'      => 'mentor@example.com',
            'password_admin'   => Hash::make('password123'),
            'role'             => 'mentor',
            'img_admin'        => null,
            'access_token_admin' => null,
        ]);

        // Students
        TblStudent::create([
            'name_student'     => 'Alice Student',
            'email_student'    => 'alice@example.com',
            'password_student' => Hash::make('password123'),
            'img_student'      => null,
            'access_token_student' => null,
        ]);

        TblStudent::create([
            'name_student'     => 'Bob Student',
            'email_student'    => 'bob@example.com',
            'password_student' => Hash::make('password123'),
            'img_student'      => null,
            'access_token_student' => null,
        ]);
    }
}
