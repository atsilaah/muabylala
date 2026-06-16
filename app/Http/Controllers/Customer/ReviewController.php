<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller {
    public function create(Booking $booking) {
        abort_if($booking->customer_id !== auth()->id(), 403);
        abort_if($booking->status !== 'done', 403);
        return view('customer.review.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking) {
        abort_if($booking->customer_id !== auth()->id(), 403);

        $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        Review::create([
            'booking_id'  => $booking->id,
            'customer_id' => auth()->id(),
            'mua_id'      => $booking->mua_id,
            'rating'      => $request->rating,
            'komentar'    => $request->komentar,
        ]);

        return redirect()->route('customer.booking.show', $booking)
            ->with('success', 'Review berhasil dikirim!');
    }
}
