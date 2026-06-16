@extends('layouts.app')
@section('content')

<div class="page-hero-title">
    <h1>Booking Saya 📅</h1>
    <p>Riwayat dan status booking kamu</p>
</div>

<section id="Inventory">
    <h2>📅 Daftar Booking</h2>
    <div class="inv-topbar">
        <a href="{{ route('customer.katalog') }}" class="btn-tambah">+ Booking Baru</a>
    </div>
    <div class="inv-table-wrap">
        <table id="inv-table">
            <thead>
                <tr>
                    <th>Layanan</th><th>MUA</th><th>Tanggal</th>
                    <th>Jam</th><th>Total</th><th>Status</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                <tr>
                    <td>{{ $b->layanan->nama }}</td>
                    <td>{{ $b->mua->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($b->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $b->jam_mulai }}</td>
                    <td>Rp {{ number_format($b->total_harga,0,',','.') }}</td>
                    <td><span class="badge-status badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                    <td>
                        <a href="{{ route('customer.booking.show', $b->id) }}" class="btn-edit-row">Detail</a>
                        @if(!$b->pembayaran)
                            <a href="{{ route('customer.pembayaran.create', $b->id) }}" class="btn-tambah" style="font-size:12px;padding:5px 12px;">Bayar</a>
                        @endif
                        @if($b->status === 'done' && !$b->review)
                            <a href="{{ route('customer.review.create', $b->id) }}" class="btn-edit-row">Review</a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="inv-empty">
                        <span>📅</span>
                        Belum ada booking. <a href="{{ route('customer.katalog') }}">Booking sekarang!</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:20px;">{{ $bookings->links() }}</div>
</section>

@endsection
