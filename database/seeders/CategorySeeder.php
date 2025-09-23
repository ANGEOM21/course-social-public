<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TblCategory;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        TblCategory::create(['name_category' => 'Programming', 'img_category' => null]);
        TblCategory::create(['name_category' => 'Design', 'img_category' => null]);
        TblCategory::create(['name_category' => 'Business', 'img_category' => null]);
    }
}
