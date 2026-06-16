<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // ✅ Ganti ke User

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalCustomer = User::where('role', 'customer')->count(); // ✅
        $customerAktif = User::where('role', 'customer')
                             ->where('is_active', true)->count(); // ✅

        $kunjungan = session('kunjungan', 0) + 1;
        session(['kunjungan' => $kunjungan]);

        if (!session('pertama_kunjung')) {
            session(['pertama_kunjung' => now()->format('d/m/Y H:i:s')]);
        }
        session(['terakhir_kunjung' => now()->format('d/m/Y H:i:s')]);

        return view('dashboard', compact(
            'totalCustomer',
            'customerAktif',
            'kunjungan'
        ));
    }

    public function resetKunjungan()
    {
        session()->forget(['kunjungan', 'pertama_kunjung', 'terakhir_kunjung']);
        return redirect()->route('dashboard')
            ->with('success', 'Hitungan kunjungan berhasil direset!');
    }
}
