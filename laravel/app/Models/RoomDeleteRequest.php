<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomDeleteRequest extends Model
{
    protected $fillable = [
        'kamar_id',
        'user_id',
        'admin_id',
        'status',
        'reason',
        'responded_at',
    ];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}