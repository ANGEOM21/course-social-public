<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan hanya ExampleDataSeeder
        $this->call([
            AdminSeeder::class,
        ]);
    }
}
