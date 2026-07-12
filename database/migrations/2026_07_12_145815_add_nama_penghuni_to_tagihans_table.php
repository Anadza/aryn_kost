<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tagihans', function (Blueprint $table) {
            // dipakai untuk menentukan penghuni mana yang harus menerima notifikasi tagihan
            $table->string('nama_penghuni')->nullable()->after('nomor_tagihan');
        });
    }

    public function down(): void
    {
        Schema::table('tagihans', function (Blueprint $table) {
            $table->dropColumn('nama_penghuni');
        });
    }
};
