<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasi_penghunis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penghuni'); // nama penghuni penerima notifikasi (cocok dgn users.name)
            $table->enum('jenis', ['booking', 'tagihan', 'pengaduan']);
            $table->string('judul');
            $table->text('pesan');
            $table->string('kamar')->nullable();
            $table->json('data')->nullable(); // info tambahan, mis. jumlah tagihan / tanggal check-in
            $table->enum('status', ['belum_dibaca', 'dibaca'])->default('belum_dibaca');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasi_penghunis');
    }
};
