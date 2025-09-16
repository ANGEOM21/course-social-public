<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_certificate', function (Blueprint $table) {
            $table->id('id_certificate');
            $table->unsignedBigInteger('student_certificate'); // FK ke user
            $table->string('title')->nullable();
            $table->string('file')->nullable(); // path sertifikat PDF/IMG
            $table->timestamps();

            $table->foreign('student_certificate')
                  ->references('id_user')->on('tbl_user')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_certificate');
    }
};
