<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Makeup Artist by Lala</title>

    <script>
    (function() {
        if(localStorage.getItem('tema') === 'dark')
            document.documentElement.classList.add('dark');
        var fs = localStorage.getItem('fontsize') || 'medium';
        if(!['small','medium','large'].includes(fs)) fs = 'medium';
        document.documentElement.classList.add('font-' + fs);
    })();
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>

<nav class="home-nav">
    <a href="{{ route('home') }}" class="home-nav-brand">
        <div class="hnb-logo"><img src="{{ asset('images/logomuabylala.png') }}" alt="Logo" style="width:100%;height:100%;object-fit:cover;border-radius:50%;"></div>
        <div class="hnb-text">
            <span class="hnb-name">Makeup Artist</span>
            <span class="hnb-sub">by Lala</span>
        </div>
    </a>
    <div class="home-nav-links">
        <a href="{{ route('home') }}" class="hnl act">Home</a>
        <a href="#layanan" class="hnl">Layanan</a>
        <a href="#portfolio" class="hnl">Portfolio</a>
        <a href="#about" class="hnl">Tentang Kami</a>
        <a href="#testimoni" class="hnl">Testimoni</a>
        <a href="#contact" class="hnl">Contact</a>
    </div>
    <div class="home-nav-auth">
        <button onclick="toggleDark()" class="btn-darkmode" id="btn-dark">🌙</button>
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="btn-register">Dashboard</a>
            @elseif(auth()->user()->isMua())
                <a href="{{ route('mua.dashboard') }}" class="btn-register">Dashboard</a>
            @else
                <a href="{{ route('customer.dashboard') }}" class="btn-register">Dashboard</a>
            @endif
        @else
            <button onclick="window.location='{{ route('login') }}'" class="btn-login">Login</button>
            <button onclick="window.location='{{ route('register') }}'" class="btn-register">Register</button>
        @endauth
    </div>
</nav>

<section class="home-hero">
    <div class="hero-inner">
        <div class="hero-text">
            <div class="hero-eyebrow">
                <div class="hero-eyebrow-dot"></div>
                Professional Makeup Artist
                <div class="hero-eyebrow-dot"></div>
            </div>
            <h1 class="hero-h1">Beauty Starts</h1>
            <span class="hero-h1-italic">Here.</span>
            <p class="hero-desc">Tampil lebih percaya diri di setiap momen spesialmu bersama sentuhan profesional dari Makeup Artist by Lala.</p>
            <div class="hero-btns">
                <button onclick="window.location='{{ route('register') }}'" class="btn-hero-primary">📅 Book Now</button>
                <a href="#layanan" class="btn-hero-ghost">Lihat Layanan →</a>
            </div>
            <div class="hero-features">
                <div class="hero-feat">
                    <div class="hero-feat-icon">✨</div>
                    <div class="hero-feat-txt">Profesional & Berpengalaman</div>
                </div>
                <div class="hero-feat">
                    <div class="hero-feat-icon">💎</div>
                    <div class="hero-feat-txt">Produk Premium & Aman</div>
                </div>
                <div class="hero-feat">
                    <div class="hero-feat-icon">⏰</div>
                    <div class="hero-feat-txt">Hasil Makeup Tahan Lama</div>
                </div>
            </div>
        </div>
        <div class="hero-right">
            <div class="hero-deco">💄</div>
        </div>
    </div>
    <div class="scroll-down">
        <span>Scroll Down</span>
        <span class="scroll-arrow">↓</span>
    </div>
</section>

<div class="ticker">
    <div class="ticker-inner">
        <div class="ticker-item">Wedding Makeup<div class="ticker-dot"></div></div>
        <div class="ticker-item">Graduation Look<div class="ticker-dot"></div></div>
        <div class="ticker-item">Party Glam<div class="ticker-dot"></div></div>
        <div class="ticker-item">Engagement<div class="ticker-dot"></div></div>
        <div class="ticker-item">Hairdo & Hijab Style<div class="ticker-dot"></div></div>
        <div class="ticker-item">Photoshoot<div class="ticker-dot"></div></div>
        <div class="ticker-item">Wedding Makeup<div class="ticker-dot"></div></div>
        <div class="ticker-item">Graduation Look<div class="ticker-dot"></div></div>
        <div class="ticker-item">Party Glam<div class="ticker-dot"></div></div>
        <div class="ticker-item">Engagement<div class="ticker-dot"></div></div>
        <div class="ticker-item">Hairdo & Hijab Style<div class="ticker-dot"></div></div>
        <div class="ticker-item">Photoshoot<div class="ticker-dot"></div></div>
    </div>
</div>

<section id="layanan" class="home-section-white">
    <div class="home-sec">
        <div class="sec-eyebrow"><div class="sec-eyebrow-dot"></div>Layanan Kami<div class="sec-eyebrow-dot"></div></div>
        <div class="sec-title">Layanan Makeup Profesional</div>
        <div class="sec-divider"></div>
        <div class="svc-grid">
            <div class="svc-card">
                <div class="svc-icon">💍</div>
                <div class="svc-name">Wedding Makeup</div>
                <div class="svc-desc">Riasan pengantin yang anggun dan tahan lama sepanjang hari bahagiamu.</div>
                <a href="{{ route('register') }}" class="svc-link">Selengkapnya →</a>
            </div>
            <div class="svc-card">
                <div class="svc-icon">🎓</div>
                <div class="svc-name">Graduation Makeup</div>
                <div class="svc-desc">Tampil maksimal di hari kelulusan dengan riasan yang flawless dan tahan lama.</div>
                <a href="{{ route('register') }}" class="svc-link">Selengkapnya →</a>
            </div>
            <div class="svc-card">
                <div class="svc-icon">💃</div>
                <div class="svc-name">Party Makeup</div>
                <div class="svc-desc">Makeup sesuai tema acara agar kamu tampil stunning dan percaya diri.</div>
                <a href="{{ route('register') }}" class="svc-link">Selengkapnya →</a>
            </div>
            <div class="svc-card">
                <div class="svc-icon">📸</div>
                <div class="svc-name">Photoshoot Makeup</div>
                <div class="svc-desc">Makeup kamera ready untuk hasil foto yang lebih sempurna dan memukau.</div>
                <a href="{{ route('register') }}" class="svc-link">Selengkapnya →</a>
            </div>
        </div>
    </div>
</section>

<div id="about" class="about-wrap">
    <div class="about-inner">
        <div class="about-text">
            <div class="about-eyebrow">Tentang Kami</div>
            <div class="about-title">Menghadirkan Kecantikan Terbaik untukmu</div>
            <div class="about-desc">Makeup Artist by Lala berkomitmen memberikan hasil makeup terbaik dengan sentuhan profesional, produk berkualitas, dan pelayanan yang ramah. Kami hadir untuk membuat setiap momen spesialmu menjadi tak terlupakan dan penuh kenangan indah.</div>
            <button onclick="window.location='{{ route('register') }}'" class="about-cta">Selengkapnya Tentang Kami</button>
        </div>
        <div class="about-stats">
            <div class="astat"><div class="astat-icon">🏆</div><div><div class="astat-n">5+</div><div class="astat-l">Tahun Pengalaman di bidang makeup profesional</div></div></div>
            <div class="astat"><div class="astat-icon">👰</div><div><div class="astat-n">500+</div><div class="astat-l">Client Puas dengan hasil makeup kami</div></div></div>
            <div class="astat"><div class="astat-icon">✨</div><div><div class="astat-n">1000+</div><div class="astat-l">Event Terselesaikan dengan sempurna</div></div></div>
            <div class="astat"><div class="astat-icon">⭐</div><div><div class="astat-n">4.9</div><div class="astat-l">Rating Pelanggan dari berbagai platform</div></div></div>
        </div>
    </div>
</div>

<section id="portfolio" class="home-section-white">
    <div class="home-sec">
        <div class="sec-eyebrow"><div class="sec-eyebrow-dot"></div>Portfolio<div class="sec-eyebrow-dot"></div></div>
        <div class="sec-title">Hasil Karya Terbaik Kami</div>
        <div class="sec-divider"></div>
        <div class="port-grid">
            <div class="port-item port-item-photo">
                <img src="{{ asset('images/portfolio/wedding1.png') }}" alt="Wedding Makeup" loading="lazy">
                <div class="port-item-overlay"><div class="port-item-lbl">Wedding</div></div>
            </div>
            <div class="port-item port-item-photo">
                <img src="{{ asset('images/portfolio/graduation1.png') }}" alt="Graduation Makeup" loading="lazy">
                <div class="port-item-overlay"><div class="port-item-lbl">Graduation</div></div>
            </div>
            <div class="port-item port-item-photo">
                <img src="{{ asset('images/portfolio/party1.png') }}" alt="Party Makeup" loading="lazy">
                <div class="port-item-overlay"><div class="port-item-lbl">Party</div></div>
            </div>
            <div class="port-item port-item-photo">
                <img src="{{ asset('images/portfolio/photoshoot1.png') }}" alt="Photoshoot Makeup" loading="lazy">
                <div class="port-item-overlay"><div class="port-item-lbl">Photoshoot</div></div>
            </div>
            <div class="port-item port-item-photo">
                <img src="{{ asset('images/portfolio/engagement1.png') }}" alt="Engagement Makeup" loading="lazy">
                <div class="port-item-overlay"><div class="port-item-lbl">Engagement</div></div>
            </div>
            <div class="port-item port-item-photo">
                <img src="{{ asset('images/portfolio/daily.jpg') }}" alt="Daily Makeup" loading="lazy">
                <div class="port-item-overlay"><div class="port-item-lbl">Daily</div></div>
            </div>
        </div>
        <button onclick="window.location='{{ route('register') }}'" class="port-more">Lihat Semua Portfolio →</button>
    </div>
</section>

<div id="testimoni" class="testi-wrap">
    <div class="testi-inner">
        <div class="sec-eyebrow" style="justify-content:center"><div class="sec-eyebrow-dot"></div>Testimoni<div class="sec-eyebrow-dot"></div></div>
        <div class="sec-title">Kata Mereka tentang Kami</div>
        <div class="sec-divider"></div>
        <div class="testi-grid">
            <div class="testi-card">
                <div class="testi-quote">"</div>
                <div class="testi-stars">★★★★★</div>
                <div class="testi-text">Makeupnya flawless banget! Tahan lama seharian dan semua puas lihat makeupnya. Pasti akan booking lagi!</div>
                <div class="testi-user">
                    <div class="testi-avatar">👰</div>
                    <div><div class="testi-name">Anisa Putri</div><div class="testi-role">Bride</div></div>
                </div>
            </div>
            <div class="testi-card">
                <div class="testi-quote">"</div>
                <div class="testi-stars">★★★★★</div>
                <div class="testi-text">Sangat profesional, hasilnya bagus sesuai request. Pelayanan ramah dan tepat waktu. Pasti booking lagi!</div>
                <div class="testi-user">
                    <div class="testi-avatar">🎓</div>
                    <div><div class="testi-name">Dewi Lestari</div><div class="testi-role">Graduation</div></div>
                </div>
            </div>
            <div class="testi-card">
                <div class="testi-quote">"</div>
                <div class="testi-stars">★★★★★</div>
                <div class="testi-text">Thank you MUA by Lala, makeup photoshootku jadi lebih hidup dan cantik natural. Highly recommended!</div>
                <div class="testi-user">
                    <div class="testi-avatar">📸</div>
                    <div><div class="testi-name">Rizka Amanda</div><div class="testi-role">Model</div></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cta-band">
    <div class="cta-band-grid">
        <div class="cta-feat"><div class="cta-feat-icon">📅</div><div class="cta-feat-title">Booking Mudah & Cepat</div><div class="cta-feat-sub">Proses booking online</div></div>
        <div class="cta-feat"><div class="cta-feat-icon">⏰</div><div class="cta-feat-title">Jadwal Fleksibel</div><div class="cta-feat-sub">Sesuai kebutuhanmu</div></div>
        <div class="cta-feat"><div class="cta-feat-icon">💬</div><div class="cta-feat-title">Konsultasi Gratis</div><div class="cta-feat-sub">Untuk hasil terbaik</div></div>
        <div class="cta-feat"><div class="cta-feat-icon">💎</div><div class="cta-feat-title">Pelayanan Ramah</div><div class="cta-feat-sub">& Profesional</div></div>
    </div>
    <div class="cta-h">Siap Tampil Cantik di Momen Spesialmu?</div>
    <div class="cta-s">Booking sekarang dan dapatkan pengalaman makeup terbaik bersama MUA by Lala.</div>
    <button onclick="window.location='{{ route('register') }}'" class="cta-book">📅 Booking Sekarang</button>
</div>

<footer class="home-footer">
    <div class="hf-inner">
        <div class="hf-brand">
            <a href="{{ route('home') }}" class="home-nav-brand">
                <div class="hnb-logo"><img src="{{ asset('images/logomuabylala.png') }}" alt="Logo" style="width:100%;height:100%;object-fit:cover;border-radius:50%;"></div>
                <div class="hnb-text">
                    <span class="hnb-name">Makeup Artist</span>
                    <span class="hnb-sub">by Lala</span>
                </div>
            </a>
            <div class="hf-desc">Makeup Artist profesional yang siap membuat kamu tampil cantik, percaya diri, dan bersinar di setiap momen spesial.</div>
            <div class="hf-social">
                <div class="hf-social-btn">📘</div>
                <div class="hf-social-btn">📸</div>
                <div class="hf-social-btn">🎵</div>
                <div class="hf-social-btn">💬</div>
            </div>
        </div>
        <div class="hf-col">
            <h4>Menu</h4>
            <a href="#">Home</a>
            <a href="#layanan">Layanan</a>
            <a href="#portfolio">Portfolio</a>
            <a href="#about">Tentang Kami</a>
            <a href="#testimoni">Testimoni</a>
            <a href="#contact">Contact</a>
        </div>
        <div class="hf-col">
            <h4>Layanan</h4>
            <a href="#">Wedding Makeup</a>
            <a href="#">Graduation Makeup</a>
            <a href="#">Party Makeup</a>
            <a href="#">Hair Do</a>
            <a href="#">Hijab Styling</a>
            <a href="#">Photoshoot</a>
        </div>
        <div id="contact" class="hf-col">
            <h4>Kontak Kami</h4>
            <div class="hf-contact">📞 0812-3456-7890</div>
            <div class="hf-contact">📧 muabylala@gmail.com</div>
            <div class="hf-contact">📍 Jember, Jawa Timur</div>
            <div class="hf-contact">🕐 Senin–Minggu 08.00–20.00</div>
        </div>
    </div>
    <div class="hf-bottom">
        <div class="hf-copy">© 2026 Makeup Artist by Lala. All Rights Reserved.</div>
        <div class="hf-copy">Made with 💄 in Jember</div>
    </div>
</footer>

<script>
function toggleDark() {
    var isDark = document.documentElement.classList.toggle('dark');
    localStorage.setItem('tema', isDark ? 'dark' : 'light');
    var btn = document.getElementById('btn-dark');
    if (btn) btn.textContent = isDark ? '☀️' : '🌙';
}

document.addEventListener('DOMContentLoaded', function() {
    var btn = document.getElementById('btn-dark');
    if (btn) btn.textContent = document.documentElement.classList.contains('dark') ? '☀️' : '🌙';
});
</script>
</body>
</html>
