<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penghunis', function (Blueprint $table) {

            $table->date('tanggal_lahir')->nullable()->after('nama');

            $table->enum('jenis_kelamin', [
                'Laki-laki',
                'Perempuan'
            ])->nullable()->after('tanggal_lahir');

            $table->text('alamat')->nullable()->after('no_hp');

            $table->string('foto')->nullable()->after('alamat');

        });
    }

    public function down(): void
    {
        Schema::table('penghunis', function (Blueprint $table) {

            $table->dropColumn([
                'tanggal_lahir',
                'jenis_kelamin',
                'alamat',
                'foto',
            ]);

        });
    }
};