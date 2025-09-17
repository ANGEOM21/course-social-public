<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom img_category ke tabel tbl_category.
     */
    public function up(): void
    {
        Schema::table('tbl_category', function (Blueprint $table) {
            $table->string('img_category')->nullable()->after('name_category');
        });
    }

    /**
     * Hapus kolom img_category jika di-rollback.
     */
    public function down(): void
    {
        Schema::table('tbl_category', function (Blueprint $table) {
            $table->dropColumn('img_category');
        });
    }
};
