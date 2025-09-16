<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tbl_course', function (Blueprint $table) {
            $table->id('id_course');
            $table->string('name_course');
            $table->text('desc_course')->nullable();
            $table->unsignedBigInteger('mentor_course'); // FK -> user
            $table->unsignedBigInteger('category_course'); // FK -> category
            $table->timestamps();

            $table->foreign('mentor_course')->references('id_user')->on('tbl_user')->onDelete('cascade');
            $table->foreign('category_course')->references('id_category')->on('tbl_category')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('tbl_course');
    }
};
