<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['tanggal', 'penyewa', 'kamar', 'kategori', 'deskripsi', 'bukti', 'status'])]
class Pengaduan extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            default => ucfirst($this->status),
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-700',
            'diproses' => 'bg-blue-100 text-blue-700',
            'selesai' => 'bg-green-100 text-green-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    public function statusDotClass(): string
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-500',
            'diproses' => 'bg-blue-500',
            'selesai' => 'bg-green-500',
            default => 'bg-gray-500',
        };
    }
}
