<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class BookingController extends Controller {
    public function index() {
        $bookings = Booking::with(['customer','mua.user','layanan','pembayaran'])
            ->latest()->paginate(15);
        return view('admin.booking.index', compact('bookings'));
    }

    public function show(Booking $booking) {
        $booking->load(['customer','mua.user','layanan','pembayaran','review']);
        return view('admin.booking.show', compact('booking'));
    }

    public function confirm(Booking $booking) {
        $booking->update(['status' => 'confirmed']);
        return back()->with('success', 'Booking berhasil dikonfirmasi!');
    }

    public function destroy(Booking $booking) {
        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Booking dibatalkan!');
    }
}
