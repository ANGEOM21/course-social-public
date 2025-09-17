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
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('file_path'); // simpan nama file sertifikat
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id_user')->on('tbl_user')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_certificate');
    }
};
