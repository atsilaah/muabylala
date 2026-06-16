<nav class="navbar">
    <img src="{{ asset('logomuabylala.png') }}" alt="Logo MUA by Lala">
    <h1>Makeup Artist by Lala</h1>
    <ul class="menu">
        <li><a href="{{ route('home') }}">Home</a></li>
        @auth
            @if(auth()->user()->isAdmin())
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('admin.customer.index') }}">Customer</a></li>
                <li><a href="{{ route('admin.mua.index') }}">MUA</a></li>
                <li><a href="{{ route('admin.layanan.index') }}">Layanan</a></li>
                <li><a href="{{ route('admin.booking.index') }}">Booking</a></li>
                <li><a href="{{ route('admin.pembayaran.index') }}">Pembayaran</a></li>
            @elseif(auth()->user()->isMua())
                <li><a href="{{ route('mua.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('mua.jadwal') }}">Jadwal</a></li>
                <li><a href="{{ route('mua.klien') }}">Klien</a></li>
                <li><a href="{{ route('mua.review') }}">Review</a></li>
            @else
                <li><a href="{{ route('customer.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('customer.katalog') }}">Katalog</a></li>
                <li><a href="{{ route('customer.booking.index') }}">Booking Saya</a></li>
                <li><a href="{{ route('customer.profil') }}">Profil</a></li>
            @endif
            <li><span style="color:var(--muted);font-size:13px;">👤 {{ auth()->user()->name }}</span></li>
            <li>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </li>
        @endauth
        <li><button onclick="toggleDark()" class="btn-darkmode" id="btn-dark">🌙</button></li>
    </ul>
</nav>

<script>
function toggleDark(){
    const h=document.documentElement;
    const d=h.classList.toggle('dark');
    setCookie('tema',d?'dark':'light',30);
    document.getElementById('btn-dark').textContent=d?'☀️':'🌙';
}
document.addEventListener('DOMContentLoaded',()=>{
    const d=document.documentElement.classList.contains('dark');
    const b=document.getElementById('btn-dark');
    if(b)b.textContent=d?'☀️':'🌙';
});
</script>
