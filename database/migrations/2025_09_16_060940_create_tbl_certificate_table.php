<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_certificates', function (Blueprint $table) {
            $table->id('id_certificate');
            $table->foreignId('student_id')
                  ->constrained('tbl_students', 'id_student')
                  ->cascadeOnDelete();
            $table->foreignId('course_id')
                  ->constrained('tbl_courses', 'id_course')
                  ->cascadeOnDelete();
            $table->string('title');
            $table->string('file_path');
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_certificate');
    }
};
