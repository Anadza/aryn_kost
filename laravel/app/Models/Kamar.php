<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        return 'Rp' . number_format((float) $this->harga, 0, ',', '.');
    }

    public function fasilitasArray(): array
    {
        if (blank($this->fasilitas)) {
            return [];
        }

        return collect(explode(',', $this->fasilitas))
            ->map(fn($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }

    public function fotoUrl(): string
    {
        return match (strtolower(trim($this->tipe))) {
            'standar' => asset('images/kamar/standar.png'),
            'deluxe'  => asset('images/kamar/deluxe.png'),
            'vip'     => asset('images/kamar/vip.png'),
            default   => asset('images/kamar/default-room.jpg'),
        };
    }

    /**
     * Semua booking milik kamar.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'kamar_id', 'id');
    }

    /**
     * Booking yang masih menunggu persetujuan.
     */
    public function pendingBooking(): HasOne
    {
        return $this->hasOne(Booking::class, 'kamar_id', 'id')
            ->where('status', Booking::STATUS_MENUNGGU);
    }

    /**
     * Booking terakhir.
     */
    public function latestBooking(): HasOne
    {
        return $this->hasOne(Booking::class, 'kamar_id', 'id')
            ->latestOfMany();
    }

    /**
     * Booking yang sedang aktif (sudah disetujui).
     */
    public function activeBooking(): HasOne
    {
        return $this->hasOne(Booking::class, 'kamar_id', 'id')
            ->where('status', Booking::STATUS_DISETUJUI);
    }

    /**
     * Seluruh riwayat permintaan penghapusan kamar.
     */
    public function deleteRequests(): HasMany
    {
        return $this->hasMany(RoomDeleteRequest::class);
    }

    /**
     * Permintaan penghapusan terbaru.
     */
    public function latestDeleteRequest(): HasOne
    {
        return $this->hasOne(RoomDeleteRequest::class)
            ->latestOfMany();
    }
}