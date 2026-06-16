@props(['judul', 'nilai', 'ikon' => '📊', 'warna' => ''])

<div class="stat-card {{ $warna }}">
    <div class="sc-label">{{ $ikon }} {{ $judul }}</div>
    <div class="sc-value">{{ $nilai }}</div>
</div>




