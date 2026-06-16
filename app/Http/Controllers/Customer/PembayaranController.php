<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller {
    public function create(Booking $booking) {
        abort_if($booking->customer_id !== auth()->id(), 403);
        return view('customer.pembayaran.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking) {
        abort_if($booking->customer_id !== auth()->id(), 403);

        $request->validate([
            'metode'     => 'required',
            'bukti_foto' => 'required|image|mimes:jpg,png|max:2048',
        ]);

        $bukti = $request->file('bukti_foto')->store('bukti', 'public');

        Pembayaran::create([
            'booking_id' => $booking->id,
            'metode'     => $request->metode,
            'bukti_foto' => $bukti,
            'status'     => 'pending',
        ]);

        return redirect()->route('customer.booking.show', $booking)
            ->with('success', 'Bukti pembayaran berhasil diupload! Menunggu konfirmasi admin.');
    }
}
