@extends('layouts.app')
@section('content')
<section class="hero">
    <h2>Detail Customer 👤</h2>
    <p>Informasi lengkap customer</p>
</section>
<section class="container">
    <main>
        <section id="Welcome">
            <h2>{{ $user->name }}</h2>
            <div style="margin-top:20px;">
                <table>
                    <tbody>
                        <tr><td><b>Email</b></td><td>{{ $user->email }}</td></tr>
                        <tr><td><b>No HP</b></td><td>{{ $user->phone ?? '-' }}</td></tr>
                        <tr><td><b>Alamat</b></td><td>{{ $user->address ?? '-' }}</td></tr>
                        <tr><td><b>Bergabung</b></td><td>{{ $user->created_at ? $user->created_at->format('d F Y') : '-' }}</td></tr>
                        <tr><td><b>Status</b></td><td>
                            @if($user->is_active)
                                <span class="stok-aman">Aktif</span>
                            @else
                                <span class="stok-tipis">Nonaktif</span>
                            @endif
                        </td></tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="Inventory">
            <h2>📅 Riwayat Booking</h2>
            <div class="inv-table-wrap">
                <table id="inv-table">
                    <thead>
                        <tr>
                            <th>Layanan</th><th>MUA</th><th>Tanggal</th>
                            <th>Total</th><th>Status</th><th>Review</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $b)
                        <tr>
                            <td>{{ $b->layanan->nama }}</td>
                            <td>{{ $b->mua->user->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($b->tanggal)->format('d/m/Y') }}</td>
                            <td>Rp {{ number_format($b->total_harga,0,',','.') }}</td>
                            <td><span class="badge-status badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                            <td>
                                @if($b->review)
                                    @for($i=1;$i<=5;$i++)
                                        {{ $i <= $b->review->rating ? '⭐' : '☆' }}
                                    @endfor
                                @else
                                    <span style="color:var(--muted)">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="inv-empty">
                                <span>📅</span>Belum ada booking.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <div class="factions" style="padding:0 28px 28px;">
            <a href="{{ route('admin.customer.index') }}" class="btn-cancel">← Kembali</a>
        </div>
    </main>
</section>
@endsection
