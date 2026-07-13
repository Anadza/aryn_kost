<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kamars', function (Blueprint $table) {
            $table->id();
            $table->string('no_kamar')->unique();
            $table->string('tipe');
            $table->unsignedBigInteger('harga');
            $table->enum('status', ['kosong', 'terisi', 'booking'])->default('kosong');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kamars');
    }
};
