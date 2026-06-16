@extends('layouts.app')
@section('page-title', 'Manajemen Booking')
@section('content')

<div class="dash-welcome-bar">
    <div>
        <h1 class="dash-welcome-title">Manajemen Booking 📅</h1>
        <p class="dash-welcome-sub">Kelola semua booking customer</p>
    </div>
</div>

<section id="Inventory">
    <h2>📅 Daftar Booking</h2>
    <div class="inv-table-wrap">
        <table id="inv-table">
            <thead>
                <tr>
                    <th>Customer</th><th>MUA</th><th>Layanan</th>
                    <th>Tanggal</th><th>Total</th><th>Pembayaran</th><th>Status</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                <tr>
                    <td>{{ $b->customer->name }}</td>
                    <td>{{ $b->mua->user->name }}</td>
                    <td>{{ $b->layanan->nama }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($b->tanggal)->format('d/m/Y') }}<br>
                        <small style="color:var(--muted)">{{ $b->jam_mulai }}</small>
                    </td>
                    <td>Rp {{ number_format($b->total_harga,0,',','.') }}</td>
                    <td>
                        @if($b->pembayaran)
                            <span class="badge-status badge-{{ $b->pembayaran->status }}">
                                {{ ucfirst($b->pembayaran->status) }}
                            </span><br>
                            <small style="color:var(--muted)">{{ $b->pembayaran->metode }}</small>
                        @else
                            <span class="stok-tipis">Belum Bayar</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge-status badge-{{ $b->status }}">
                            {{ ucfirst($b->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.booking.show', $b->id) }}" class="btn-edit-row">Detail</a>
                        @if($b->status === 'pending')
                            <form action="{{ route('admin.booking.confirm', $b->id) }}" method="POST" style="display:inline">
                                @csrf
                                <button type="submit" class="btn-edit-row"
                                    style="border-color:#27ae60;color:#27ae60"
                                    onclick="return confirm('Konfirmasi booking ini?')">
                                    ✅ Konfirmasi
                                </button>
                            </form>
                        @endif
                        @if($b->status !== 'cancelled')
                            <form action="{{ route('admin.booking.destroy', $b->id) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-del-row"
                                    onclick="return confirm('Batalkan booking ini?')">
                                    Batalkan
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="inv-empty"><span>📅</span>Belum ada booking.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:1.25rem;">{{ $bookings->links() }}</div>
</section>

@endsection
