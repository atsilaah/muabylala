<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Makeup Artist by Lala</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        (function(){
            const h = document.documentElement;
            if(localStorage.getItem('tema') === 'dark') h.classList.add('dark');
            const fs = localStorage.getItem('fontsize') || 'medium';
            h.classList.remove('font-small','font-medium','font-large');
            h.classList.add('font-' + fs);
        })();
        function getCookie(n){ return localStorage.getItem(n); }
        function setCookie(n,v,d){ localStorage.setItem(n,v); }
    </script>
</head>
<body class="{{ auth()->check() ? 'dashboard-body' : '' }}">

@auth
    <div class="sb-overlay" id="sb-overlay"></div>
    @include('layouts.sidebar')
@endauth

<div class="{{ auth()->check() ? 'dash-main' : '' }}">

    @auth
    <div class="dash-topbar">

        <button class="btn-hamburger" id="btn-hamburger" onclick="toggleSidebar()">
            <span></span><span></span><span></span>
        </button>

        <div class="dash-topbar-brand">
            <div class="dtb-logo">
                <img src="{{ asset('images/logomuabylala.png') }}" alt="Logo"
                     style="width:100%;height:100%;object-fit:cover;border-radius:50%;"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <span style="display:none;align-items:center;justify-content:center;font-size:20px;">💄</span>
            </div>
            <div class="dtb-text">
                <div class="dtb-title">Makeup Artist by Lala</div>
                <div class="dtb-page">@yield('page-title', 'Dashboard')</div>
            </div>
        </div>

        <nav class="dash-nav">
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}"        class="dash-nav-link {{ request()->routeIs('admin.dashboard')    ? 'act' : '' }}">Dashboard</a>
                <a href="{{ route('admin.booking.index') }}"    class="dash-nav-link {{ request()->routeIs('admin.booking.*')    ? 'act' : '' }}">Booking</a>
                <a href="{{ route('admin.layanan.index') }}"    class="dash-nav-link {{ request()->routeIs('admin.layanan.*')    ? 'act' : '' }}">Layanan</a>
                <a href="{{ route('admin.mua.index') }}"        class="dash-nav-link {{ request()->routeIs('admin.mua.*')        ? 'act' : '' }}">MUA</a>
                <a href="{{ route('admin.customer.index') }}"   class="dash-nav-link {{ request()->routeIs('admin.customer.*')   ? 'act' : '' }}">Customer</a>
                <a href="{{ route('admin.pembayaran.index') }}" class="dash-nav-link {{ request()->routeIs('admin.pembayaran.*') ? 'act' : '' }}">
                    Pembayaran
                    @php $pp = \App\Models\Pembayaran::where('status','pending')->count(); @endphp
                    @if($pp > 0)<span class="dash-nav-badge">{{ $pp }}</span>@endif
                </a>
                <a href="{{ route('admin.review.index') }}"     class="dash-nav-link {{ request()->routeIs('admin.review.*')     ? 'act' : '' }}">Review</a>
                <a href="{{ route('admin.laporan.index') }}"    class="dash-nav-link {{ request()->routeIs('admin.laporan.*')    ? 'act' : '' }}">Laporan</a>
            @elseif(auth()->user()->isMua())
                <a href="{{ route('mua.dashboard') }}" class="dash-nav-link {{ request()->routeIs('mua.dashboard') ? 'act' : '' }}">Dashboard</a>
                <a href="{{ route('mua.jadwal') }}"    class="dash-nav-link {{ request()->routeIs('mua.jadwal*')   ? 'act' : '' }}">Jadwal</a>
                <a href="{{ route('mua.klien') }}"     class="dash-nav-link {{ request()->routeIs('mua.klien')     ? 'act' : '' }}">Klien</a>
                <a href="{{ route('mua.review') }}"    class="dash-nav-link {{ request()->routeIs('mua.review')    ? 'act' : '' }}">Review</a>
            @else
                <a href="{{ route('customer.dashboard') }}"     class="dash-nav-link {{ request()->routeIs('customer.dashboard')    ? 'act' : '' }}">Dashboard</a>
                <a href="{{ route('customer.katalog') }}"       class="dash-nav-link {{ request()->routeIs('customer.katalog')      ? 'act' : '' }}">Katalog</a>
                <a href="{{ route('customer.booking.index') }}" class="dash-nav-link {{ request()->routeIs('customer.booking.*')    ? 'act' : '' }}">Booking Saya</a>
                <a href="{{ route('customer.profil') }}"        class="dash-nav-link {{ request()->routeIs('customer.profil')       ? 'act' : '' }}">Profil</a>
            @endif
        </nav>

        <div class="dash-topbar-right">
            <button onclick="toggleDark()" class="btn-darkmode" id="btn-dark">🌙</button>

            @php
                $notifList  = [];
                $notifCount = 0;
                if(auth()->user()->isAdmin()){
                    $pendingBooking = \App\Models\Booking::where('status','pending')->count();
                    $pendingBayar   = \App\Models\Pembayaran::where('status','pending')->count();
                    $notifCount     = $pendingBooking + $pendingBayar;
                    if($pendingBooking > 0)
                        $notifList[] = ['icon'=>'📅','text'=>"$pendingBooking booking menunggu konfirmasi",'url'=>route('admin.booking.index')];
                    if($pendingBayar > 0)
                        $notifList[] = ['icon'=>'💳','text'=>"$pendingBayar pembayaran menunggu konfirmasi",'url'=>route('admin.pembayaran.index')];
                } elseif(auth()->user()->isMua()){
                    $jadwalHariIni = \App\Models\Booking::where('mua_id', auth()->user()->mua?->id)
                        ->whereDate('tanggal', today())->where('status','confirmed')->count();
                    $notifCount = $jadwalHariIni;
                    if($jadwalHariIni > 0)
                        $notifList[] = ['icon'=>'📅','text'=>"$jadwalHariIni jadwal hari ini",'url'=>route('mua.jadwal')];
                } else {
                    $bookingPending = \App\Models\Booking::where('customer_id', auth()->user()->id)
                        ->where('status','pending')->count();
                    $notifCount = $bookingPending;
                    if($bookingPending > 0)
                        $notifList[] = ['icon'=>'📅','text'=>"$bookingPending booking menunggu konfirmasi",'url'=>route('customer.booking.index')];
                }
            @endphp

            <div class="notif-wrap" id="notif-wrap">
                <button class="notif-btn" id="notif-btn" type="button">
                    🔔
                    @if($notifCount > 0)
                        <span class="notif-count">{{ $notifCount }}</span>
                    @endif
                </button>
                <div class="notif-dropdown" id="notif-dropdown">
                    <div class="notif-header">
                        <span class="notif-header-title">Notifikasi</span>
                        @if($notifCount > 0)
                            <span class="notif-header-badge">{{ $notifCount }}</span>
                        @endif
                    </div>
                    <div class="notif-body">
                        @forelse($notifList as $n)
                            <a href="{{ $n['url'] }}" class="notif-item">
                                <span class="notif-item-icon">{{ $n['icon'] }}</span>
                                <span class="notif-item-text">{{ $n['text'] }}</span>
                                <span class="notif-item-arrow">→</span>
                            </a>
                        @empty
                            <div class="notif-empty">
                                <span class="notif-empty-icon">🎉</span>
                                <span>Tidak ada notifikasi!</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
    @endauth

    @if(session('success'))
        <div class="flash-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash-error">❌ {{ session('error') }}</div>
    @endif

    <div class="{{ auth()->check() ? 'dash-content' : '' }}">
        @yield('content')
    </div>

    @auth
    <footer>
        <p>📧 <a href="mailto:muabylala@gmail.com">muabylala@gmail.com</a></p>
        <p>© 2026 Makeup Artist by Lala</p>
        <p>📸 Instagram: <a href="#">@muabylalajember</a></p>
    </footer>
    @endauth
</div>

<div class="modal-bg" id="modal-form">
    <div class="form-card">
        <button class="fc-close" id="fc-close">✕</button>
        <h3 id="form-judul">Tambah Barang</h3>
        <div class="frow">
            <div class="fgroup">
                <label>Kode Barang</label>
                <input type="text" id="f-kode" placeholder="cth: MUA-001">
                <div class="ferr" id="ferr-kode"></div>
            </div>
            <div class="fgroup">
                <label>Nama Barang</label>
                <input type="text" id="f-nama" placeholder="cth: Foundation Shade 02">
                <div class="ferr" id="ferr-nama"></div>
            </div>
        </div>
        <div class="frow">
            <div class="fgroup">
                <label>Kategori</label>
                <select id="f-kat">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Complexion">Complexion</option>
                    <option value="Eye Makeup">Eye Makeup</option>
                    <option value="Lip Color">Lip Color</option>
                    <option value="Contouring">Contouring</option>
                    <option value="Setting & Primer">Setting &amp; Primer</option>
                    <option value="Skincare">Skincare</option>
                    <option value="Tools & Brush">Tools &amp; Brush</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
                <div class="ferr" id="ferr-kat"></div>
            </div>
            <div class="fgroup">
                <label>Tanggal Masuk</label>
                <input type="date" id="f-tgl">
                <div class="ferr" id="ferr-tgl"></div>
            </div>
        </div>
        <div class="frow">
            <div class="fgroup">
                <label>Stok</label>
                <input type="number" id="f-stok" placeholder="0" min="0">
                <div class="ferr" id="ferr-stok"></div>
            </div>
            <div class="fgroup">
                <label>Harga (Rp)</label>
                <input type="number" id="f-harga" placeholder="0" min="0">
                <div class="ferr" id="ferr-harga"></div>
            </div>
        </div>
        <div class="factions">
            <button class="btn-cancel" id="fc-batal">Batal</button>
            <button class="btn-save"   id="fc-simpan">💾 Simpan</button>
        </div>
    </div>
</div>

<div class="modal-bg" id="modal-konfirm">
    <div class="konfirm-card">
        <span class="kicon">🗑️</span>
        <h3 id="konfirm-judul">Hapus data ini?</h3>
        <p id="konfirm-pesan">Tindakan ini tidak dapat dibatalkan.</p>
        <div class="kactions">
            <button class="btn-cancel" id="konfirm-batal">Batal</button>
            <button class="btn-del-ok" id="konfirm-ok">Ya, Hapus</button>
        </div>
    </div>
</div>

<div class="inv-toast" id="inv-toast"></div>
<script src="{{ asset('script.js') }}"></script>
<script>

function toggleDark(){
    const h    = document.documentElement;
    const dark = h.classList.toggle('dark');
    localStorage.setItem('tema', dark ? 'dark' : 'light');
    const btn = document.getElementById('btn-dark');
    if(btn) btn.textContent = dark ? '☀️' : '🌙';
}

function applyFontSize(size){
    const valid = ['small','medium','large'];
    if(!valid.includes(size)) size = 'medium';
    document.documentElement.classList.remove('font-small','font-medium','font-large');
    document.documentElement.classList.add('font-'+size);
    localStorage.setItem('fontsize', size);
}

document.addEventListener('DOMContentLoaded', function(){
    const btn  = document.getElementById('notif-btn');
    const dd   = document.getElementById('notif-dropdown');
    const wrap = document.getElementById('notif-wrap');

    if(btn && dd){
        btn.addEventListener('click', function(e){
            e.stopPropagation();
            dd.classList.toggle('show');
        });
    }

    document.addEventListener('click', function(e){
        if(dd && wrap && !wrap.contains(e.target)){
            dd.classList.remove('show');
        }
    });

    const darkBtn = document.getElementById('btn-dark');
    if(darkBtn){
        darkBtn.textContent = document.documentElement.classList.contains('dark') ? '☀️' : '🌙';
    }

    document.querySelectorAll('.flash-success,.flash-error').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity .5s';
            el.style.opacity    = '0';
            setTimeout(() => el.remove(), 500);
        }, 3500);
    });

    const overlay = document.getElementById('sb-overlay');
    if(overlay){
        overlay.addEventListener('click', function(){
            document.getElementById('sidebar')?.classList.remove('open');
            overlay.classList.remove('show');
        });
    }
});
</script>
@stack('scripts')
</body>
</html>
