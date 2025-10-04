<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tbl_admins', function (Blueprint $table) {
            $table->id('id_admin');
            $table->string('name_admin');
            $table->string('email_admin')->unique();
            $table->string('img_admin')->nullable();
            $table->string('password_admin')->nullable();
            $table->text('access_token_admin')->nullable();
            $table->enum('role', ['admin', 'mentor'])->default('mentor'); 
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tbl_admins');
    }
};
