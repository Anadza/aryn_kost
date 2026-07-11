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

            // Data Tagihan
            $table->string('bulan_tagihan');
            $table->decimal('jumlah_tagihan', 12, 2);
            $table->date('tanggal_jatuh_tempo');
            $table->string('nomor_tagihan')->unique();

            // Status Pembayaran
            $table->string('status_pembayaran')->default('Belum Dibayar');

            // Data Unggahan Pembayaran
            $table->string('bukti_pembayaran_path')->nullable();
            $table->timestamp('tanggal_upload_bukti')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
