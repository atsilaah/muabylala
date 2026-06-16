@extends('layouts.app')
@section('content')
<section class="hero">
    <h2>Jadwal Saya 📅</h2>
    <p>Daftar semua jadwal booking kamu</p>
</section>
<section class="container">
    <main>
        <section id="Inventory">
            <h2>📅 Semua Jadwal</h2>
            <div class="inv-table-wrap">
                <table id="inv-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th><th>Jam</th><th>Customer</th>
                            <th>Layanan</th><th>Total</th><th>Status</th><th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $b)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($b->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $b->jam_mulai }} — {{ $b->jam_selesai }}</td>
                            <td>{{ $b->customer->name }}</td>
                            <td>{{ $b->layanan->nama }}</td>
                            <td>Rp {{ number_format($b->total_harga,0,',','.') }}</td>
                            <td><span class="badge-status badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                            <td>
                                <a href="{{ route('mua.jadwal.show', $b->id) }}" class="btn-edit-row">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="inv-empty">
                                <span>📅</span>Belum ada jadwal.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="margin-top:20px;">{{ $bookings->links() }}</div>
        </section>
    </main>
</section>
@endsection
