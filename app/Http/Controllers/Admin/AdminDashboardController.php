<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Mua;
use App\Models\Pembayaran;
use Carbon\Carbon;

class AdminDashboardController extends Controller {
    public function index() {
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $totalBookingBulanIni = Booking::whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)->count();

        $pendapatanBulanIni = Pembayaran::where('pembayarans.status', 'confirmed')
            ->whereMonth('pembayarans.confirmed_at', $bulanIni)
            ->whereYear('pembayarans.confirmed_at', $tahunIni)
            ->join('bookings', 'bookings.id', '=', 'pembayarans.booking_id')
            ->sum('bookings.total_harga');

        $totalCustomer  = User::where('role', 'customer')->count();
        $totalMua       = Mua::where('is_active', true)->count();
        $bookingPending = Booking::where('status', 'pending')->count();

        $bookingTerbaru = Booking::with(['customer', 'mua.user', 'layanan'])
            ->latest()->take(5)->get();

        $bookingTerlaris = Booking::selectRaw('layanan_id, count(*) as total')
            ->groupBy('layanan_id')
            ->with('layanan')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBookingBulanIni',
            'pendapatanBulanIni',
            'totalCustomer',
            'totalMua',
            'bookingPending',
            'bookingTerbaru',
            'bookingTerlaris'
        ));
    }
}
