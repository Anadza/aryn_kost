<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('nomor_tagihan')->unique();
            $table->integer('jumlah_tagihan');
            $table->string('bulan_tagihan');
            $table->string('status_pembayaran')->default('Belum Dibayar');
            $table->string('bukti_pembayaran_path')->nullable();
            $table->string('nama_penghuni')->nullable(); // Kolom dari file alter sebelumnya
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->timestamp('tanggal_upload_bukti')->nullable();

            $table->timestamps(); 

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihans'); {
        };
    }
};
