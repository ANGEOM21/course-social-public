<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\TblStudent;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // bikin 10 mahasiswa dummy
        for ($i = 0; $i < 10; $i++) {
            TblStudent::create([
                'name_student'     => $faker->name,
                'email_student'    => $faker->unique()->safeEmail,
                'password_student' => Hash::make('password123'), // 
                'img_student'      => null,
                'access_token_student' => null,
            ]);
        }
    }
}
