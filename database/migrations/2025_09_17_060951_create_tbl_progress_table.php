<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tbl_progress', function (Blueprint $table) {
            $table->id('id_progress');
            $table->foreignId('course_id')
                  ->constrained('tbl_courses', 'id_course')
                  ->cascadeOnDelete();
            $table->foreignId('module_id')
                  ->constrained('tbl_modules', 'id_module')
                  ->cascadeOnDelete();
            $table->foreignId('student_id')
                  ->constrained('tbl_students', 'id_student')
                  ->cascadeOnDelete();
            $table->timestamps();
        });
        
    }

    public function down(): void {
        Schema::dropIfExists('tbl_progress');
    }
};
