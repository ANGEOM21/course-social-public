<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tbl_progress', function (Blueprint $table) {
            $table->id('id_progress');
            $table->unsignedBigInteger('course_progress');  // FK -> course
            $table->unsignedBigInteger('student_progress'); // FK -> user
            $table->timestamps();

            $table->foreign('course_progress')->references('id_course')->on('tbl_course')->onDelete('cascade');
            $table->foreign('student_progress')->references('id_user')->on('tbl_user')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('tbl_progress');
    }
};
