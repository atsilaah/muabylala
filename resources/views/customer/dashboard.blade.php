@extends('layouts.app')
@section('page-title', 'Dashboard')

@section('content')

<div class="dash-welcome-bar">
    <div>
        <h1 class="dash-welcome-title">Hi, {{ auth()->user()->name }}! 👋</h1>
        <p class="dash-welcome-sub">Selamat datang di dashboard kamu</p>
    </div>
    <div class="dash-welcome-date">
        <span id="dash-tanggal"></span>
    </div>
</div>

{{-- Cuaca --}}
<section id="Cuaca">
    <h2>🌤️ Current Weather — Jember</h2>
    <div class="cuaca-box">
        <div id="cuaca-loading" class="cuaca-loading">⏳ Loading...</div>
        <div id="cuaca-content" style="display:none;text-align:center;">
            <p id="cuaca-kota" style="font-size:1rem;font-weight:600;color:var(--deep);"></p>
            <p id="cuaca-suhu" style="font-size:3rem;font-weight:700;color:var(--rose);"></p>
            <p id="cuaca-desc" style="color:var(--muted);"></p>
            <p id="cuaca-extra" style="font-size:0.8125rem;color:var(--muted);"></p>
        </div>
        <div id="cuaca-error" style="display:none;color:#c0392b;">❌ Gagal memuat cuaca.</div>
    </div>
</section>

<section id="StatistikDashboard">
    <h2>📊 Ringkasan</h2>
    <div class="inv-stats">
        <x-stat-card judul="Total Booking" nilai="{{ auth()->user()->bookings->count() }}"                                           ikon="📅" />
        <x-stat-card judul="Booking Aktif" nilai="{{ auth()->user()->bookings->whereIn('status',['pending','confirmed'])->count() }}" ikon="✅" />
        <x-stat-card judul="Selesai"       nilai="{{ auth()->user()->bookings->where('status','done')->count() }}"                   ikon="🎉" />
    </div>
</section>

<section id="Inventory">
    <h2>📋 Booking Terbaru</h2>
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
                    <td><a href="{{ route('customer.booking.show', $b->id) }}" class="btn-edit-row">Detail</a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="inv-empty">
                        <span>📅</span>Belum ada booking. <a href="{{ route('customer.katalog') }}">Booking sekarang!</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@endsection

@push('scripts')
<script>
(function(){
    const el = document.getElementById('dash-tanggal');
    if(el) el.textContent = new Date().toLocaleDateString('id-ID',{
        weekday:'long', year:'numeric', month:'long', day:'numeric'
    });
})();

async function loadCuaca() {
    try {
        const res  = await fetch('https://wttr.in/Jember?format=j1');
        const data = await res.json();
        const area = data.nearest_area[0];
        document.getElementById('cuaca-loading').style.display = 'none';
        document.getElementById('cuaca-content').style.display = 'block';
        document.getElementById('cuaca-kota').textContent  = '📍 ' + area.areaName[0].value + ', ' + area.country[0].value;
        document.getElementById('cuaca-suhu').textContent  = data.current_condition[0].temp_C + '°C';
        document.getElementById('cuaca-desc').textContent  = '☁️ ' + data.current_condition[0].weatherDesc[0].value;
        document.getElementById('cuaca-extra').innerHTML   = `💧 ${data.current_condition[0].humidity}% | 🌡️ Feels ${data.current_condition[0].FeelsLikeC}°C | 💨 ${data.current_condition[0].windspeedKmph} km/h`;
    } catch(e) {
        document.getElementById('cuaca-loading').style.display = 'none';
        document.getElementById('cuaca-error').style.display   = 'block';
    }
}
loadCuaca();
</script>
@endpush
