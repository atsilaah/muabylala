<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\MuaController as AdminMuaController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Customer\PembayaranController as CustomerPembayaranController;
use App\Http\Controllers\Customer\ReviewController as CustomerReviewController;
use App\Http\Controllers\Mua\MuaDashboardController;
use App\Http\Controllers\Mua\JadwalController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\PreferensiController;

// Homepage publik
Route::get('/', fn() => view('home'))->name('home');

// Auth
Route::get('/login',         [AuthController::class, 'loginForm'])->name('login');
Route::post('/login',        [AuthController::class, 'login']);
Route::get('/register',      [AuthController::class, 'registerForm'])->name('register');
Route::post('/register',     [AuthController::class, 'register']);
Route::post('/logout',       [AuthController::class, 'logout'])->name('logout');
Route::get('/lupa-password', [AuthController::class, 'lupaPassword'])->name('lupa.password');
Route::post('/lupa-password',[AuthController::class, 'kirimReset'])->name('lupa.password.kirim');

// Admin
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',                 [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/preferensi',                [PreferensiController::class, 'index'])->name('preferensi');
    Route::put('/preferensi',                [PreferensiController::class, 'update'])->name('preferensi.update');
    Route::get('/profil',                    [ProfilController::class, 'show'])->name('profil');
    Route::put('/profil',                    [ProfilController::class, 'update'])->name('profil.update');
    Route::resource('customer',              AdminCustomerController::class);
    Route::resource('mua',                   AdminMuaController::class);
    Route::post('mua/{mua}/toggle',          [AdminMuaController::class, 'toggle'])->name('mua.toggle');
    Route::resource('layanan',               LayananController::class);
    Route::resource('booking',               AdminBookingController::class);
    Route::post('booking/{booking}/confirm', [AdminBookingController::class, 'confirm'])->name('booking.confirm');
    Route::resource('pembayaran',            AdminPembayaranController::class);
    Route::post('pembayaran/{p}/confirm',    [AdminPembayaranController::class, 'confirm'])->name('pembayaran.confirm');
    Route::get('review',                     [AdminReviewController::class, 'index'])->name('review.index');
    Route::get('/laporan',                   [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/chat',                      [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat',                     [ChatController::class, 'send'])->name('chat.send');
});

// Customer
Route::middleware(['auth','customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard',               [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/katalog',                 [CustomerDashboardController::class, 'katalog'])->name('katalog');
    Route::get('/preferensi',              [PreferensiController::class, 'index'])->name('preferensi');
    Route::put('/preferensi',              [PreferensiController::class, 'update'])->name('preferensi.update');
    Route::get('/profil',                  [ProfilController::class, 'show'])->name('profil');
    Route::put('/profil',                  [ProfilController::class, 'update'])->name('profil.update');
    Route::resource('booking',             CustomerBookingController::class);
    Route::get('booking/{booking}/bayar',  [CustomerPembayaranController::class, 'create'])->name('pembayaran.create');
    Route::post('booking/{booking}/bayar', [CustomerPembayaranController::class, 'store'])->name('pembayaran.store');
    Route::get('booking/{booking}/review', [CustomerReviewController::class, 'create'])->name('review.create');
    Route::post('booking/{booking}/review',[CustomerReviewController::class, 'store'])->name('review.store');
    Route::get('/get-slots',               [CustomerBookingController::class, 'getSlots'])->name('get.slots');
    Route::get('/chat',                    [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat',                   [ChatController::class, 'send'])->name('chat.send');
});

// MUA
Route::middleware(['auth','mua'])->prefix('mua')->name('mua.')->group(function () {
    Route::get('/dashboard',                [MuaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/preferensi',               [PreferensiController::class, 'index'])->name('preferensi');
    Route::put('/preferensi',               [PreferensiController::class, 'update'])->name('preferensi.update');
    Route::get('/profil',                   [ProfilController::class, 'show'])->name('profil');
    Route::put('/profil',                   [ProfilController::class, 'update'])->name('profil.update');
    Route::get('/jadwal',                   [JadwalController::class, 'index'])->name('jadwal');
    Route::get('/jadwal/{booking}',         [JadwalController::class, 'show'])->name('jadwal.show');
    Route::post('/jadwal/{booking}/status', [JadwalController::class, 'updateStatus'])->name('jadwal.status');
    Route::get('/klien',                    [MuaDashboardController::class, 'klien'])->name('klien');
    Route::get('/review',                   [MuaDashboardController::class, 'review'])->name('review');
    Route::get('/chat',                     [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat',                    [ChatController::class, 'send'])->name('chat.send');
});
