<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tbl_enrollment', function (Blueprint $table) {
            $table->id('id_enrollment');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id_user')->on('tbl_user')->onDelete('cascade');
            $table->foreign('course_id')->references('id_course')->on('tbl_course')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('tbl_enrollment');
    }
};
