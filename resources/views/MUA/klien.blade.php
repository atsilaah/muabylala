@extends('layouts.app')
@section('content')
<section class="hero">
    <h2>List Klien 👰</h2>
    <p>Daftar customer yang pernah booking kamu</p>
</section>
<section class="container">
    <main>
        <section id="Inventory">
            <h2>👰 Daftar Klien</h2>
            <div class="inv-table-wrap">
                <table id="inv-table">
                    <thead>
                        <tr>
                            <th>Customer</th><th>Layanan</th><th>Tanggal</th>
                            <th>Total</th><th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $b)
                        <tr>
                            <td>
                                <strong>{{ $b->customer->name }}</strong><br>
                                <small style="color:var(--muted)">{{ $b->customer->phone ?? '-' }}</small>
                            </td>
                            <td>{{ $b->layanan->nama }}</td>
                            <td>{{ \Carbon\Carbon::parse($b->tanggal)->format('d/m/Y') }}</td>
                            <td>Rp {{ number_format($b->total_harga,0,',','.') }}</td>
                            <td><span class="badge-status badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="inv-empty">
                                <span>👰</span>Belum ada klien.
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
