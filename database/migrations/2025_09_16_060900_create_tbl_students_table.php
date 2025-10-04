<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tbl_students', function (Blueprint $table) {
            $table->id('id_student');
            $table->string('name_student');
            $table->string('email_student')->unique();
            $table->string('img_student')->nullable();
            $table->string('password_student')->nullable();
            $table->text('access_token_student')->nullable();
            $table->string('refresh_token_student')->nullable();
            $table->timestamp('token_expires_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tbl_students');
    }
};
