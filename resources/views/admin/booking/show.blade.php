@extends('layouts.app')
@section('content')
<section class="hero">
    <h2>Detail Booking 📋</h2>
    <p>Informasi lengkap booking</p>
</section>
<section class="container">
    <main>
        <section id="Welcome">
            <h2>Detail Booking #{{ $booking->id }}</h2>
            <div style="margin-top:20px;">
                <table>
                    <tbody>
                        <tr><td><b>Customer</b></td><td>{{ $booking->customer->name }}</td></tr>
                        <tr><td><b>Email</b></td><td>{{ $booking->customer->email }}</td></tr>
                        <tr><td><b>MUA</b></td><td>{{ $booking->mua->user->name }}</td></tr>
                        <tr><td><b>Layanan</b></td><td>{{ $booking->layanan->nama }}</td></tr>
                        <tr><td><b>Tanggal</b></td><td>{{ \Carbon\Carbon::parse($booking->tanggal)->format('d F Y') }}</td></tr>
                        <tr><td><b>Jam</b></td><td>{{ $booking->jam_mulai }} — {{ $booking->jam_selesai }}</td></tr>
                        <tr><td><b>Jumlah Orang</b></td><td>{{ $booking->jumlah_orang }} orang</td></tr>
                        <tr><td><b>Hairdo</b></td><td>{{ $booking->add_hairdo ? '✅ Ya' : '❌ Tidak' }}</td></tr>
                        <tr><td><b>Alamat</b></td><td>{{ $booking->alamat }}</td></tr>
                        <tr><td><b>Catatan</b></td><td>{{ $booking->catatan ?? '-' }}</td></tr>
                        <tr><td><b>Total</b></td><td><strong style="color:var(--deep)">Rp {{ number_format($booking->total_harga,0,',','.') }}</strong></td></tr>
                        <tr><td><b>Status</b></td><td><span class="badge-status badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td></tr>
                    </tbody>
                </table>

                <div style="margin-top:24px;">
                    <h3 style="font-family:'Playfair Display',serif;color:var(--deep);margin-bottom:14px;">💳 Pembayaran</h3>
                    @if($booking->pembayaran)
                        <table>
                            <tbody>
                                <tr><td><b>Metode</b></td><td>{{ $booking->pembayaran->metode }}</td></tr>
                                <tr><td><b>Status</b></td><td><span class="badge-status badge-{{ $booking->pembayaran->status }}">{{ ucfirst($booking->pembayaran->status) }}</span></td></tr>
                                <tr><td><b>Bukti</b></td><td>
                                    @if($booking->pembayaran->bukti_foto)
                                        <a href="{{ asset('storage/'.$booking->pembayaran->bukti_foto) }}" target="_blank">
                                            <img src="{{ asset('storage/'.$booking->pembayaran->bukti_foto) }}"
                                                style="width:200px;border-radius:10px;margin-top:8px;">
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td></tr>
                            </tbody>
                        </table>
                        @if($booking->pembayaran->status === 'pending')
                            <form action="{{ route('admin.pembayaran.confirm', $booking->pembayaran->id) }}"
                                method="POST" style="margin-top:14px;">
                                @csrf
                                <button type="submit" class="btn-save"
                                    onclick="return confirm('Konfirmasi pembayaran ini?')">
                                    ✅ Konfirmasi Pembayaran
                                </button>
                            </form>
                        @endif
                    @else
                        <div class="flash-error" style="margin:0;">❌ Customer belum melakukan pembayaran.</div>
                    @endif
                </div>

                @if($booking->review)
                <div style="margin-top:24px;">
                    <h3 style="font-family:'Playfair Display',serif;color:var(--deep);margin-bottom:14px;">⭐ Review Customer</h3>
                    <div style="background:var(--warm);border-radius:12px;padding:16px;">
                        <div style="font-size:20px;margin-bottom:8px;">
                            @for($i=1;$i<=5;$i++)
                                {{ $i <= $booking->review->rating ? '⭐' : '☆' }}
                            @endfor
                            <strong>({{ $booking->review->rating }}/5)</strong>
                        </div>
                        <p style="font-size:14px;color:var(--text);">{{ $booking->review->komentar ?? 'Tidak ada komentar.' }}</p>
                    </div>
                </div>
                @endif

                <div class="factions" style="margin-top:24px;">
                    <a href="{{ route('admin.booking.index') }}" class="btn-cancel">← Kembali</a>
                    @if($booking->status === 'pending')
                        <form action="{{ route('admin.booking.confirm', $booking->id) }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit" class="btn-save"
                                onclick="return confirm('Konfirmasi booking ini?')">
                                ✅ Konfirmasi Booking
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </section>
    </main>
</section>
@endsection
