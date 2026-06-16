@extends('layouts.app')
@section('content')
<section class="hero">
    <h2>Detail Jadwal 📋</h2>
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
                        <tr><td><b>No HP</b></td><td>{{ $booking->customer->phone ?? '-' }}</td></tr>
                        <tr><td><b>Layanan</b></td><td>{{ $booking->layanan->nama }}</td></tr>
                        <tr><td><b>Tanggal</b></td><td>{{ \Carbon\Carbon::parse($booking->tanggal)->format('d F Y') }}</td></tr>
                        <tr><td><b>Jam</b></td><td>{{ $booking->jam_mulai }} — {{ $booking->jam_selesai }}</td></tr>
                        <tr><td><b>Jumlah Orang</b></td><td>{{ $booking->jumlah_orang }} orang</td></tr>
                        <tr><td><b>Hairdo</b></td><td>{{ $booking->add_hairdo ? '✅ Ya' : '❌ Tidak' }}</td></tr>
                        <tr><td><b>Alamat</b></td><td>{{ $booking->alamat }}</td></tr>
                        <tr><td><b>Catatan</b></td><td>{{ $booking->catatan ?? '-' }}</td></tr>
                        <tr><td><b>Total</b></td><td><strong style="color:var(--deep)">Rp {{ number_format($booking->total_harga,0,',','.') }}</strong></td></tr>
                        <tr><td><b>Pembayaran</b></td><td>
                            @if($booking->pembayaran)
                                <span class="badge-status badge-{{ $booking->pembayaran->status }}">
                                    {{ ucfirst($booking->pembayaran->status) }} via {{ $booking->pembayaran->metode }}
                                </span>
                            @else
                                <span class="stok-tipis">Belum Bayar</span>
                            @endif
                        </td></tr>
                        <tr><td><b>Status</b></td><td>
                            <span class="badge-status badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                        </td></tr>
                    </tbody>
                </table>

                <div style="margin-top:24px;">
                    <h3 style="font-family:'Playfair Display',serif;color:var(--deep);margin-bottom:14px;">Update Status</h3>
                    <form action="{{ route('mua.jadwal.status', $booking->id) }}" method="POST" style="display:flex;gap:10px;flex-wrap:wrap;">
                        @csrf
                        <select name="status" class="inv-filter-select">
                            <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="done"      {{ $booking->status === 'done'      ? 'selected' : '' }}>Done</option>
                            <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="btn-save" onclick="return confirm('Update status booking ini?')">
                            💾 Update Status
                        </button>
                    </form>
                </div>

                @if($booking->review)
                <div style="margin-top:24px;">
                    <h3 style="font-family:'Playfair Display',serif;color:var(--deep);margin-bottom:14px;">Review Customer</h3>
                    <div style="background:var(--warm);border-radius:12px;padding:16px;">
                        <div style="font-size:20px;margin-bottom:8px;">
                            @for($i=1;$i<=5;$i++)
                                {{ $i <= $booking->review->rating ? '⭐' : '☆' }}
                            @endfor
                            <strong>({{ $booking->review->rating }}/5)</strong>
                        </div>
                        <p style="color:var(--text);font-size:14px;">{{ $booking->review->komentar ?? 'Tidak ada komentar.' }}</p>
                    </div>
                </div>
                @endif

                <div class="factions" style="margin-top:24px;">
                    <a href="{{ route('mua.jadwal') }}" class="btn-cancel">← Kembali</a>
                </div>
            </div>
        </section>
    </main>
</section>
@endsection
