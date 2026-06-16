<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller {
    public function index() {
        $reviews = Review::with(['customer','mua.user','booking.layanan'])
            ->latest()->paginate(15);
        return view('admin.review.index', compact('reviews'));
    }
}
