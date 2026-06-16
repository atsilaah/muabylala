<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', Carbon::now()->year);
        $bulan = $request->get('bulan', null);

        $pendapatanPerBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $total = Pembayaran::join('bookings', 'bookings.id', '=', 'pembayarans.booking_id')
                ->where('pembayarans.status', 'confirmed')
                ->whereYear('pembayarans.confirmed_at', $tahun)
                ->whereMonth('pembayarans.confirmed_at', $i)
                ->sum('bookings.total_harga');

            $pendapatanPerBulan[] = [
                'bulan' => Carbon::create()->month($i)->format('M'),
                'total' => $total,
            ];
        }

        $queryBooking = Booking::with(['customer', 'mua.user', 'layanan', 'pembayaran'])
            ->whereYear('tanggal', $tahun);

        if ($bulan) {
            $queryBooking->whereMonth('tanggal', $bulan);
        }

        $bookings = $queryBooking->latest()->paginate(15);

        $totalBookingQuery = Booking::whereYear('tanggal', $tahun);
        if ($bulan) $totalBookingQuery->whereMonth('tanggal', $bulan);
        $totalBooking = $totalBookingQuery->count();

        $totalPendapatanQuery = Pembayaran::join('bookings', 'bookings.id', '=', 'pembayarans.booking_id')
            ->where('pembayarans.status', 'confirmed')
            ->whereYear('bookings.tanggal', $tahun);
        if ($bulan) $totalPendapatanQuery->whereMonth('bookings.tanggal', $bulan);
        $totalPendapatan = $totalPendapatanQuery->sum('bookings.total_harga');

        $totalCustomer = User::where('role', 'customer')->count();

        $layananTerlaris = Booking::selectRaw('layanan_id, count(*) as total')
            ->whereYear('tanggal', $tahun);
        if ($bulan) $layananTerlaris->whereMonth('tanggal', $bulan);
        $layananTerlaris = $layananTerlaris
            ->groupBy('layanan_id')
            ->with('layanan')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $maxPendapatan = max(array_column($pendapatanPerBulan, 'total')) ?: 1;

        return view('admin.laporan.index', compact(
            'pendapatanPerBulan',
            'bookings',
            'totalPendapatan',
            'totalBooking',
            'totalCustomer',
            'layananTerlaris',
            'maxPendapatan',
            'tahun',
            'bulan'
        ));
    }
}
