@extends('layouts.app')
@section('page-title', 'Manajemen Pembayaran')
@section('content')

<div class="dash-welcome-bar">
    <div>
        <h1 class="dash-welcome-title">Manajemen Pembayaran 💳</h1>
        <p class="dash-welcome-sub">Kelola dan verifikasi pembayaran customer</p>
    </div>
</div>

<section id="Inventory">
    <h2>💳 Daftar Pembayaran</h2>
    <div class="inv-table-wrap">
        <table id="inv-table">
            <thead>
                <tr><th>Customer</th><th>Layanan</th><th>Jumlah</th><th>Metode</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($pembayarans as $p)
                <tr>
                    <td>{{ $p->booking->customer->name }}</td>
                    <td>{{ $p->booking->layanan->nama }}</td>
                    <td>Rp {{ number_format($p->booking->total_harga, 0, ',', '.') }}</td>
                    <td>{{ strtoupper($p->metode) }}</td>
                    <td><span class="badge-status badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.pembayaran.show', $p->id) }}" class="btn-edit-row">Detail</a>
                        @if($p->status === 'pending')
                            <form action="{{ route('admin.pembayaran.confirm', $p->id) }}" method="POST" style="display:inline">
                                @csrf
                                <button type="submit" class="btn-edit-row"
                                    style="border-color:#27ae60;color:#27ae60"
                                    onclick="return confirm('Konfirmasi pembayaran ini?')">
                                    ✅ Konfirmasi
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="inv-empty"><span>💳</span>Belum ada pembayaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:1.25rem;">{{ $pembayarans->links() }}</div>
</section>

@endsection
