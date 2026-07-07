<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['no_kamar', 'tipe', 'harga', 'status'])]
class Kamar extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'harga' => 'integer',
        ];
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'kosong' => 'Kosong',
            'terisi' => 'Terisi',
            'booking' => 'Booking',
            default => ucfirst($this->status),
        };
    }

    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            'kosong' => 'bg-gray-100 text-gray-600',
            'terisi' => 'bg-green-100 text-green-700',
            'booking' => 'bg-yellow-100 text-yellow-700',
            default => 'bg-gray-100 text-gray-600',
        };
    }

    public function statusDotClass(): string
    {
        return match ($this->status) {
            'kosong' => 'bg-gray-400',
            'terisi' => 'bg-green-500',
            'booking' => 'bg-yellow-500',
            default => 'bg-gray-400',
        };
    }

    public function hargaFormatted(): string
    {
        return 'Rp'.number_format((float) $this->harga, 0, ',', '.');
    }
}
