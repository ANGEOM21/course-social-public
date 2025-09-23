<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tbl_courses', function (Blueprint $table) {
            $table->id('id_course');
            $table->string('name_course');
            $table->text('desc_course')->nullable();

            // relasi ke mentor/admin
            $table->foreignId('mentor_id')
                ->constrained('tbl_admins', 'id_admin')
                ->cascadeOnDelete();

            // relasi ke kategori
            $table->foreignId('category_id')
                ->constrained('tbl_categories', 'id_category')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_course');
    }
};
