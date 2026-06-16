<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Layanan;

class CustomerDashboardController extends Controller {
    public function index() {
        $bookings = auth()->user()->bookings()
            ->with(['layanan','mua.user','pembayaran','review'])
            ->latest()->take(5)->get();
        return view('customer.dashboard', compact('bookings'));
    }

    public function katalog() {
        $layanans = Layanan::where('is_active', true)->get();
        return view('customer.katalog', compact('layanans'));
    }
}
