<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class CustomerController extends Controller {
    public function index() {
        $customers = User::where('role','customer')
            ->withCount('bookings')
            ->latest()
            ->paginate(15);
        return view('admin.customer.index', compact('customers'));
    }

    public function show(User $customer) {
        $bookings = $customer->bookings()->with(['layanan','mua.user','review'])->latest()->get();
        return view('admin.customer.show', [
            'user' => $customer,
            'bookings' => $bookings,
        ]);
    }
}
