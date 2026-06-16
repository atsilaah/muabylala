<?php
namespace App\Http\Controllers\Mua;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Carbon\Carbon;

class MuaDashboardController extends Controller {
    public function index() {
        $mua = auth()->user()->mua;

        $jadwalHariIni = Booking::where('mua_id', $mua->id)
            ->where('tanggal', Carbon::today())
            ->whereIn('status', ['confirmed', 'done']) 
            ->with(['customer','layanan'])->get();

        $pendapatanBulanIni = Booking::where('mua_id', $mua->id)
            ->where('status', 'done')
            ->whereMonth('tanggal', Carbon::now()->month)
            ->sum('total_harga');

        $totalKlien = Booking::where('mua_id', $mua->id)
            ->whereIn('status', ['confirmed','done'])
            ->distinct('customer_id')->count('customer_id');

        $ratingRata = Review::where('mua_id', $mua->id)->avg('rating');

        return view('mua.dashboard', compact(
            'jadwalHariIni','pendapatanBulanIni','totalKlien','ratingRata'
        ));
    }

    public function klien() {
        $mua = auth()->user()->mua;
        $bookings = Booking::where('mua_id', $mua->id)
            ->whereIn('status', ['confirmed','done'])
            ->with(['customer','layanan'])->latest()->paginate(15);
        return view('mua.klien', compact('bookings'));
    }

    public function review() {
        $mua = auth()->user()->mua;
        $reviews = Review::where('mua_id', $mua->id)
            ->with(['customer','booking.layanan'])->latest()->paginate(15);
        return view('mua.review', compact('reviews'));
    }
}
