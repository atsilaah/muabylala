<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Carbon\Carbon;

class PembayaranController extends Controller {

    public function index() {
        $pembayarans = Pembayaran::with(['booking.customer','booking.layanan'])
            ->latest()->paginate(15);
        return view('admin.pembayaran.index', compact('pembayarans'));
    }

    public function show(Pembayaran $pembayaran) {
        $pembayaran->load(['booking.customer', 'booking.layanan', 'booking.mua.user']);
        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    public function confirm(Pembayaran $p) {
        $p->update([
            'status'       => 'confirmed',
            'confirmed_at' => Carbon::now(),
        ]);
        $p->booking->update(['status' => 'confirmed']);
        return back()->with('success', 'Pembayaran dikonfirmasi!');
    }
}
