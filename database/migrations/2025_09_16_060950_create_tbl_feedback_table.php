<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tbl_feedback', function (Blueprint $table) {
            $table->id('id_feedback');
            $table->unsignedBigInteger('user_feedback');   // FK -> user
            $table->unsignedBigInteger('course_feedback'); // FK -> course
            $table->tinyInteger('rating_feedback')->default(0);
            $table->text('desc_feedback')->nullable();
            $table->timestamps();

            $table->foreign('user_feedback')->references('id_user')->on('tbl_user')->onDelete('cascade');
            $table->foreign('course_feedback')->references('id_course')->on('tbl_course')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('tbl_feedback');
    }
};
