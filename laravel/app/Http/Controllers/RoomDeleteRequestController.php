<?php

namespace App\Http\Controllers;

use App\Models\RoomDeleteRequest;
use Illuminate\Http\RedirectResponse;

class RoomDeleteRequestController extends Controller
{
    /**
     * Penghuni menyetujui permintaan penghapusan kamar.
     */
    public function approve(RoomDeleteRequest $roomDeleteRequest): RedirectResponse
    {
        if ($roomDeleteRequest->user_id !== auth()->id()) {
            abort(403);
        }

        if ($roomDeleteRequest->status !== 'pending') {
            return back()->with(
                'error',
                'Permintaan ini sudah diproses.'
            );
        }

        $roomDeleteRequest->update([
            'status' => 'approved',
            'responded_at' => now(),
        ]);

        return back()->with(
            'success',
            'Permintaan penghapusan kamar telah disetujui.'
        );
    }

    /**
     * Penghuni menolak permintaan penghapusan kamar.
     */
    public function reject(RoomDeleteRequest $roomDeleteRequest): RedirectResponse
    {
        if ($roomDeleteRequest->user_id !== auth()->id()) {
            abort(403);
        }

        if ($roomDeleteRequest->status !== 'pending') {
            return back()->with(
                'error',
                'Permintaan ini sudah diproses.'
            );
        }

        $roomDeleteRequest->update([
            'status' => 'rejected',
            'responded_at' => now(),
        ]);

        return back()->with(
            'success',
            'Permintaan penghapusan kamar telah ditolak.'
        );
    }
}