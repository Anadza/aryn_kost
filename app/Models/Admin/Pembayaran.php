<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use hasFactory;

    protected $fillable = [
        'penghuni_id',
        'no_kamar',
        'jumlah_bayar',
        'tanggal_bayar',
        'status',
    ];
}
