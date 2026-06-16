@extends('layouts.app')

@section('page-title', 'Dashboard MUA')
@section('page-sub', 'Makeup Artist by Lala')

@section('content')

<div class="dash-welcome-bar">
    <div>
        <h1 class="dash-welcome-title">Dashboard MUA 💄</h1>
        <p class="dash-welcome-sub">Selamat datang kembali, <strong>{{ auth()->user()->name }}</strong>!</p>
    </div>
    <div class="dash-welcome-date">
        <span id="dash-tanggal"></span>
    </div>
</div>

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
    <h2>📊 Statistik Kamu</h2>
    <div class="inv-stats">
        <x-stat-card judul="Jadwal Hari Ini"     nilai="{{ $jadwalHariIni->count() }}"                          ikon="📅" />
        <x-stat-card judul="Total Klien"          nilai="{{ $totalKlien }}"                                      ikon="👰" />
        <x-stat-card judul="Pendapatan Bulan Ini" nilai="Rp {{ number_format($pendapatanBulanIni,0,',','.') }}" ikon="💰" />
        <x-stat-card judul="Rating Rata-rata"     nilai="{{ number_format($ratingRata ?? 0, 1) }} ⭐"           ikon="⭐" />
    </div>
</section>

<section id="Inventory">
    <h2>📅 Jadwal Hari Ini</h2>
    <div class="inv-topbar">
        <a href="{{ route('mua.jadwal') }}" class="btn-tambah">Lihat Semua Jadwal</a>
    </div>
    <div class="inv-table-wrap">
        <table id="inv-table">
            <thead>
                <tr>
                    <th>Jam</th><th>Customer</th><th>Layanan</th>
                    <th>Jumlah</th><th>Alamat</th><th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwalHariIni as $b)
                <tr>
                    <td><strong>{{ $b->jam_mulai }} — {{ $b->jam_selesai }}</strong></td>
                    <td>
                        {{ $b->customer->name }}
                        <br><small style="color:var(--muted)">{{ $b->customer->phone }}</small>
                    </td>
                    <td>{{ $b->layanan->nama }}</td>
                    <td>{{ $b->jumlah_orang }} orang{{ $b->add_hairdo ? ' + Hairdo' : '' }}</td>
                    <td><small>{{ $b->alamat }}</small></td>
                    <td><span class="badge-status badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="inv-empty">
                        <span>🎉</span>Tidak ada jadwal hari ini!
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
