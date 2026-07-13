<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bulan_tagihan',
        'jumlah_tagihan',
        'tanggal_jatuh_tempo',
        'nomor_tagihan',
        'nama_penghuni',
        'status_pembayaran',
        'bukti_pembayaran_path',
        'tanggal_upload_bukti',
    ];

    protected $casts = [
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_upload_bukti' => 'datetime',
    ];

    public function jumlahTagihanFormatted(): string
    {
        return 'Rp ' . number_format($this->jumlah_tagihan, 0, ',', '.');
    }
}
