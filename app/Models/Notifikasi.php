<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['jenis', 'judul', 'pesan', 'pengirim', 'kamar', 'data', 'status'])]
class Notifikasi extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }

    public function scopeBelumDibaca(Builder $query): Builder
    {
        return $query->where('status', 'belum_dibaca');
    }

    public function scopeJenis(Builder $query, ?string $jenis): Builder
    {
        return $jenis && $jenis !== 'semua'
            ? $query->where('jenis', $jenis)
            : $query;
    }

    public function isBelumDibaca(): bool
    {
        return $this->status === 'belum_dibaca';
    }

    public function jenisLabel(): string
    {
        return match ($this->jenis) {
            'pembayaran' => 'Pembayaran',
            'keluhan' => 'Keluhan',
            'booking' => 'Booking',
            default => ucfirst($this->jenis),
        };
    }

    public function jenisBadgeClass(): string
    {
        return match ($this->jenis) {
            'pembayaran' => 'bg-green-100 text-green-700',
            'keluhan' => 'bg-red-100 text-red-700',
            'booking' => 'bg-blue-100 text-blue-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    public function jenisIconBgClass(): string
    {
        return match ($this->jenis) {
            'pembayaran' => 'bg-green-500',
            'keluhan' => 'bg-red-500',
            'booking' => 'bg-blue-500',
            default => 'bg-gray-500',
        };
    }

    public function jenisIcon(): string
    {
        return match ($this->jenis) {
            'pembayaran' => 'wallet',
            'keluhan' => 'alert',
            'booking' => 'calendar',
            default => 'bell',
        };
    }

    public function waktuRelatif(): string
    {
        return $this->created_at?->diffForHumans() ?? '-';
    }
}
