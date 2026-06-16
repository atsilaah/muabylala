<?php
namespace App\Http\Controllers\Mua;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class JadwalController extends Controller {
    public function index() {
        $mua = auth()->user()->mua;

        $bookings = Booking::where('mua_id', $mua->id)
            ->whereIn('status', ['confirmed', 'done', 'cancelled'])  // ← tidak tampilkan pending
            ->with(['customer','layanan'])
            ->orderBy('tanggal')->orderBy('jam_mulai')
            ->paginate(15);

        return view('mua.jadwal.index', compact('bookings'));
    }

    public function show(Booking $booking) {
        abort_if($booking->mua_id !== auth()->user()->mua->id, 403);

        abort_if($booking->status === 'pending', 403);

        $booking->load(['customer','layanan','pembayaran','review']);
        return view('mua.jadwal.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking) {
        abort_if($booking->mua_id !== auth()->user()->mua->id, 403);

        abort_if($booking->status === 'pending', 403);

        $request->validate(['status' => 'required|in:done,cancelled']);

        $booking->update(['status' => $request->status]);
        return back()->with('success', 'Status booking berhasil diupdate!');
    }
}
