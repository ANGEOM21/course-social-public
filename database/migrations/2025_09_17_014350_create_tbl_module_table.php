<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tbl_module', function (Blueprint $table) {
            $table->id('id_module');
            $table->unsignedBigInteger('course_id');
            $table->string('title_module');
            $table->text('desc_module')->nullable();
            $table->string('video_url'); // link YouTube
            $table->timestamps();

            $table->foreign('course_id')
                  ->references('id_course')
                  ->on('tbl_course')
                  ->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('tbl_module');
    }
};
