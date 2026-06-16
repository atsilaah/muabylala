@extends('layouts.app')
@section('page-title', 'Laporan Penjualan')
@section('content')

<div class="dash-welcome-bar">
    <div>
        <h1 class="dash-welcome-title">Laporan Penjualan 📊</h1>
        <p class="dash-welcome-sub">Ringkasan pendapatan dan statistik bisnis</p>
    </div>
    <div class="dash-welcome-date" id="dash-tanggal"></div>
</div>

<section id="Welcome">
    <h2>🔍 Filter Laporan</h2>
    <form method="GET" action="{{ route('admin.laporan.index') }}"
          style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
        <div class="fgroup" style="margin:0;">
            <label>Tahun</label>
            <select name="tahun" class="inv-filter-select">
                @for($y = date('Y'); $y >= date('Y')-4; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div class="fgroup" style="margin:0;">
            <label>Bulan</label>
            <select name="bulan" class="inv-filter-select">
                <option value="">Semua Bulan</option>
                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $b)
                    <option value="{{ $i+1 }}" {{ $bulan == $i+1 ? 'selected' : '' }}>{{ $b }}</option>
                @endforeach
            </select>
        </div>
        <div class="fgroup" style="margin:0;align-self:flex-end;">
            <label>&nbsp;</label>
            <div style="display:flex;gap:8px;">
                <button type="submit" class="btn-tambah">🔍 Filter</button>
                <a href="{{ route('admin.laporan.index') }}" class="btn-cancel">Reset</a>
            </div>
        </div>
    </form>
</section>

<section id="StatistikDashboard">
    <h2>📊 Statistik {{ $tahun }}{{ $bulan ? ' — ' . ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][$bulan] : '' }}</h2>
    <div class="inv-stats">
        <x-stat-card judul="Total Booking"    nilai="{{ $totalBooking }}"                                        ikon="📅" />
        <x-stat-card judul="Total Pendapatan" nilai="Rp {{ number_format($totalPendapatan,0,',','.') }}"        ikon="💰" />
        <x-stat-card judul="Total Customer"   nilai="{{ $totalCustomer }}"                                       ikon="👤" />
        <x-stat-card judul="Layanan Terlaris" nilai="{{ $layananTerlaris->first()?->layanan?->nama ?? '-' }}"    ikon="🏆" />
    </div>
</section>

<section id="Laporan">
    <h2>📋 Riwayat Transaksi</h2>
    <div class="inv-table-wrap">
        <table id="inv-table">
            <thead>
                <tr>
                    <th>Tanggal</th><th>Customer</th><th>Layanan</th>
                    <th>MUA</th><th>Total</th><th>Pembayaran</th><th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($b->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $b->customer->name }}</td>
                    <td>{{ $b->layanan->nama }}</td>
                    <td>{{ $b->mua->user->name }}</td>
                    <td>Rp {{ number_format($b->total_harga,0,',','.') }}</td>
                    <td>
                        @if($b->pembayaran)
                            <span class="badge-status badge-{{ $b->pembayaran->status }}">
                                {{ ucfirst($b->pembayaran->metode) }}
                            </span>
                        @else
                            <span style="color:var(--muted)">Belum bayar</span>
                        @endif
                    </td>
                    <td><span class="badge-status badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="inv-empty">
                        <span>📊</span>Belum ada data laporan untuk periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:1.25rem;">{{ $bookings->links() }}</div>
</section>

@endsection

@push('scripts')
<script>
document.getElementById('dash-tanggal').textContent =
    new Date().toLocaleDateString('id-ID',{weekday:'long',year:'numeric',month:'long',day:'numeric'});
</script>
@endpush
