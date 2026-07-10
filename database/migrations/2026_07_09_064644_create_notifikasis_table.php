<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasis', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', ['pembayaran', 'keluhan', 'booking']);
            $table->string('judul');
            $table->text('pesan');
            $table->string('pengirim'); // nama penghuni pengirim notifikasi
            $table->string('kamar')->nullable();
            $table->json('data')->nullable(); // info tambahan, mis. jumlah pembayaran / tanggal booking
            $table->enum('status', ['belum_dibaca', 'dibaca'])->default('belum_dibaca');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};
