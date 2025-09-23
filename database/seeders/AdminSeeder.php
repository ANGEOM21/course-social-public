<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\TblAdmin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        TblAdmin::create([
            'name_admin'       => 'Super Admin',
            'email_admin'      => 'admin@mail.com',
            'password_admin'   => bcrypt("Admin_123"),
            'role'             => 'admin',
        ]);

        TblAdmin::create([
            'name_admin'       => 'Angeom',
            'email_admin'      => 'angeom212@gmail.com',
            'password_admin'   => bcrypt("Angeom_123"),
            'role'             => 'mentor',
        ]);
    }
}
