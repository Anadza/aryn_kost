<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table -> id();

            $table -> foreignId('penghuni_id')->constrained('penghunis')->onDelete('cascade');
            $table -> foreignId('kamar_id')->constrained('kamars')->onDelete('cascade');
            $table -> decimal('jumlah_bayar', 10, 2);
            $table -> date('tanggal_bayar');
            $table -> enum('status', ['belum lunas', 'lunas'])->default('belum lunas');

            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
