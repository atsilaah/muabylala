@extends('layouts.app')
@section('page-title', 'Detail Booking')
@section('content')

<div class="dash-welcome-bar">
    <div>
        <h1 class="dash-welcome-title">Detail Booking 📋</h1>
        <p class="dash-welcome-sub">Informasi lengkap booking kamu</p>
    </div>
</div>

<section id="Welcome">
    <h2>Detail Booking #{{ $booking->id }}</h2>
    <div style="margin-top:20px;">
        <table>
            <tbody>
                <tr><td><b>Layanan</b></td><td>{{ $booking->layanan->nama }}</td></tr>
                <tr>
                    <td><b>MUA</b></td>
                    <td>
                        {{ $booking->mua->user->name }}
                        <a href="{{ route('customer.chat.index', ['with' => $booking->mua->user_id]) }}"
                           class="btn-edit-row" style="margin-left:8px;font-size:11px;">
                            💬 Chat MUA
                        </a>
                    </td>
                </tr>
                <tr><td><b>Tanggal</b></td><td>{{ \Carbon\Carbon::parse($booking->tanggal)->format('d F Y') }}</td></tr>
                <tr><td><b>Jam</b></td><td>{{ $booking->jam_mulai }} — {{ $booking->jam_selesai }}</td></tr>
                <tr><td><b>Jumlah Orang</b></td><td>{{ $booking->jumlah_orang }} orang</td></tr>
                <tr><td><b>Hairdo</b></td><td>{{ $booking->add_hairdo ? 'Ya' : 'Tidak' }}</td></tr>
                <tr><td><b>Alamat</b></td><td>{{ $booking->alamat }}</td></tr>
                <tr><td><b>Catatan</b></td><td>{{ $booking->catatan ?? '-' }}</td></tr>
                <tr><td><b>Total Harga</b></td>
                    <td><strong style="color:var(--deep)">Rp {{ number_format($booking->total_harga,0,',','.') }}</strong></td>
                </tr>
                <tr><td><b>Status</b></td>
                    <td><span class="badge-status badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top:24px;">
            @if($booking->pembayaran)
                <div class="flash-success" style="margin:0 0 16px;">
                    ✅ Pembayaran via {{ $booking->pembayaran->metode }}
                    — Status: <strong>{{ ucfirst($booking->pembayaran->status) }}</strong>
                </div>
            @elseif($booking->status !== 'cancelled')
                <a href="{{ route('customer.pembayaran.create', $booking->id) }}" class="btn-tambah">
                    💳 Lakukan Pembayaran
                </a>
            @endif
        </div>

        @if($booking->status === 'done')
        <div style="margin-top:16px;">
            @if($booking->review)
                <div class="flash-success" style="margin:0;">
                    ⭐ Kamu sudah memberikan rating {{ $booking->review->rating }}/5
                    @if($booking->review->komentar) — "{{ $booking->review->komentar }}" @endif
                </div>
            @else
                <a href="{{ route('customer.review.create', $booking->id) }}" class="btn-edit-row">
                    ⭐ Beri Review
                </a>
            @endif
        </div>
        @endif

        <div class="factions" style="margin-top:24px;">
            <a href="{{ route('customer.booking.index') }}" class="btn-cancel">← Kembali</a>
            @php $admin = \App\Models\User::where('role','admin')->first(); @endphp
            @if($admin)
            <a href="{{ route('customer.chat.index', ['with' => $admin->id]) }}" class="btn-edit-row">
                💬 Chat Admin
            </a>
            @endif
        </div>
    </div>
</section>

@endsection
