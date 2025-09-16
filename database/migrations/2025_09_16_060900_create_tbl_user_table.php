<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tbl_user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('name_user');
            $table->string('email_user')->unique();
            $table->string('img_user')->nullable();
            $table->string('role_user')->default('student');
            $table->string('access_token_user')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tbl_user');
    }
};
