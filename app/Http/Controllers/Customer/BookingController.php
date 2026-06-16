<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Layanan;
use App\Models\Mua;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller {
    public function index() {
        $bookings = auth()->user()->bookings()
            ->with(['layanan','mua.user','pembayaran','review'])
            ->latest()->paginate(10);
        return view('customer.booking.index', compact('bookings'));
    }

    public function create(Request $request) {
        $layanans = Layanan::where('is_active', true)->get();
        $muas     = Mua::where('is_active', true)->with('user')->get();
        $layanan  = $request->layanan_id ? Layanan::find($request->layanan_id) : null;
        return view('customer.booking.create', compact('layanans','muas','layanan'));
    }

    public function store(Request $request) {
        $request->validate([
            'layanan_id'   => 'required|exists:layanans,id',
            'mua_id'       => 'required|exists:muas,id',
            'tanggal'      => 'required|date|after:today',
            'jam_mulai'    => 'required',
            'jumlah_orang' => 'required|integer|min:1',
            'alamat'       => 'required',
        ]);

        $layanan    = Layanan::findOrFail($request->layanan_id);
        $jamMulai   = Carbon::parse($request->tanggal . ' ' . $request->jam_mulai);
        $jamSelesai = $jamMulai->copy()->addMinutes($layanan->durasi);

        $bentrok = Booking::where('mua_id', $request->mua_id)
            ->where('tanggal', $request->tanggal)
            ->whereNotIn('status', ['cancelled'])
            ->where(function($q) use ($request, $jamSelesai) {
                $q->whereBetween('jam_mulai', [$request->jam_mulai, $jamSelesai->format('H:i')])
                  ->orWhereBetween('jam_selesai', [$request->jam_mulai, $jamSelesai->format('H:i')]);
            })->exists();

        if ($bentrok) {
            return back()->withErrors(['jam_mulai' => 'MUA tidak tersedia di jam tersebut!'])->withInput();
        }

        $total = $layanan->harga * $request->jumlah_orang;
        if ($request->add_hairdo) $total += $layanan->harga_hairdo * $request->jumlah_orang;

        $booking = Booking::create([
            'customer_id'  => auth()->id(),
            'mua_id'       => $request->mua_id,
            'layanan_id'   => $request->layanan_id,
            'tanggal'      => $request->tanggal,
            'jam_mulai'    => $request->jam_mulai,
            'jam_selesai'  => $jamSelesai->format('H:i'),
            'jumlah_orang' => $request->jumlah_orang,
            'add_hairdo'   => $request->boolean('add_hairdo'),
            'total_harga'  => $total,
            'alamat'       => $request->alamat,
            'catatan'      => $request->catatan,
            'status'       => 'pending',
        ]);

        return redirect()->route('customer.pembayaran.create', $booking)
            ->with('success', 'Booking berhasil! Silakan lakukan pembayaran.');
    }

    public function show(Booking $booking) {
        abort_if($booking->customer_id !== auth()->id(), 403);
        $booking->load(['layanan','mua.user','pembayaran','review']);
        return view('customer.booking.show', compact('booking'));
    }

    public function getSlots(Request $request) {
        $mua     = Mua::findOrFail($request->mua_id);
        $layanan = Layanan::findOrFail($request->layanan_id);
        $tanggal = $request->tanggal;

        $bookings = Booking::where('mua_id', $mua->id)
            ->where('tanggal', $tanggal)
            ->whereNotIn('status', ['cancelled'])
            ->get(['jam_mulai','jam_selesai']);

        $slots = [];
        for ($h = 8; $h <= 18; $h++) {
            $jam = sprintf('%02d:00', $h);
            $jamSelesai = Carbon::parse($tanggal . ' ' . $jam)
                ->addMinutes($layanan->durasi)->format('H:i');

            $available = $bookings->every(function($b) use ($jam, $jamSelesai) {
                return $jamSelesai <= $b->jam_mulai || $jam >= $b->jam_selesai;
            });

            $slots[] = ['jam' => $jam, 'available' => $available];
        }

        return response()->json($slots);
    }
}
