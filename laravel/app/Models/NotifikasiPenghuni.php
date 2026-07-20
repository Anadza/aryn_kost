<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_penghuni', 'jenis', 'judul', 'pesan', 'kamar', 'data', 'status'])]
class NotifikasiPenghuni extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }

    public function scopeUntukPenghuni(Builder $query, string $nama): Builder
    {
        return $query->where('nama_penghuni', $nama);
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
            'booking' => 'Booking',
            'tagihan' => 'Tagihan',
            'pengaduan' => 'Pengaduan',
            'hapus_kamar' => 'Persetujuan Hapus Kamar',
            default => ucfirst($this->jenis),
        };
    }

    public function jenisBadgeClass(): string
    {
        return match ($this->jenis) {
            'booking' => 'bg-blue-100 text-blue-700',
            'tagihan' => 'bg-green-100 text-green-700',
            'pengaduan' => 'bg-amber-100 text-amber-700',
            'hapus_kamar' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    public function jenisIconBgClass(): string
    {
        return match ($this->jenis) {
            'booking' => 'bg-blue-500',
            'tagihan' => 'bg-green-500',
            'pengaduan' => 'bg-amber-500',
            'hapus_kamar' => 'bg-red-500',
            default => 'bg-gray-500',
        };
    }

    public function jenisIcon(): string
    {
        return match ($this->jenis) {
            'booking' => 'calendar',
            'tagihan' => 'wallet',
            'pengaduan' => 'alert',
            'hapus_kamar' => 'trash',
            default => 'bell',
        };
    }

    public function waktuRelatif(): string
    {
        return $this->created_at?->diffForHumans() ?? '-';
    }

    /**
     * Ambil RoomDeleteRequest terkait notifikasi ini berdasarkan ID
     * yang tersimpan pada kolom data (bukan query latest()).
     */
    public function roomDeleteRequest(): ?RoomDeleteRequest
    {
        $id = $this->data['room_delete_request_id'] ?? null;

        return $id ? RoomDeleteRequest::find($id) : null;
    }
}