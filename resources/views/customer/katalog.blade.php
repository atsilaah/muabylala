@extends('layouts.app')

@section('content')
<section class="hero">
    <h2>Katalog Layanan ✨</h2>
    <p>Pilih layanan makeup yang kamu inginkan</p>
</section>
<section class="container">
    <main>
        <section id="Katalog">
            <h2>💄 Layanan Tersedia</h2>

            <div class="katalog-topbar">
                <input type="text" id="katalog-search" class="inv-search"
                    placeholder="🔍 Cari layanan...">

                <select id="katalog-sort" class="inv-filter-select">
                    <option value="default">Urutkan</option>
                    <option value="harga-asc">Harga: Termurah</option>
                    <option value="harga-desc">Harga: Termahal</option>
                    <option value="durasi-asc">Durasi: Tercepat</option>
                    <option value="nama-asc">Nama: A-Z</option>
                </select>

                <div class="katalog-view-toggle">
                    <button class="view-btn active" id="btn-grid" onclick="setView('grid')" title="Grid View">⊞</button>
                    <button class="view-btn" id="btn-list" onclick="setView('list')" title="List View">☰</button>
                </div>
            </div>

            <p id="katalog-count" style="font-size:13px;color:var(--muted);margin-bottom:16px;"></p>

            <div class="katalog-grid" id="katalog-container">
                @forelse($layanans as $l)
                <div class="katalog-card"
                    data-nama="{{ strtolower($l->nama) }}"
                    data-harga="{{ $l->harga }}"
                    data-durasi="{{ $l->durasi ?? 0 }}"
                    data-desc="{{ strtolower($l->deskripsi ?? '') }}">

                    <div class="katalog-img-wrap">
                        @if($l->foto)
                            <img src="{{ asset('storage/'.$l->foto) }}" alt="{{ $l->nama }}">
                        @else
                            <div class="katalog-img-placeholder">💄</div>
                        @endif
                        <div class="katalog-durasi-badge">⏱ {{ $l->durasi ?? '-' }} mnt</div>
                    </div>

                    <div class="katalog-info">
                        <h3>{{ $l->nama }}</h3>
                        <p class="katalog-desc">{{ Str::limit($l->deskripsi, 90) ?? 'Layanan makeup profesional.' }}</p>

                        <div class="katalog-harga-row">
                            <div>
                                <div class="katalog-harga">Rp {{ number_format($l->harga, 0, ',', '.') }}</div>
                                <div class="katalog-hairdo">+ Hairdo Rp {{ number_format($l->harga_hairdo ?? 50000, 0, ',', '.') }}</div>
                            </div>
                        </div>

                        <a href="{{ route('customer.booking.create', ['layanan_id' => $l->id]) }}"
                            class="btn-tambah katalog-btn">
                            💄 Book Sekarang
                        </a>
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:60px 20px;color:var(--muted);grid-column:1/-1;">
                    <div style="font-size:48px;margin-bottom:12px;">💄</div>
                    <p>Belum ada layanan tersedia.</p>
                </div>
                @endforelse
            </div>

            <div id="katalog-empty" style="display:none;text-align:center;padding:60px 20px;color:var(--muted);">
                <div style="font-size:48px;margin-bottom:12px;">🔍</div>
                <p>Tidak ada layanan yang cocok.</p>
                <button onclick="resetFilter()" class="btn-cancel" style="margin-top:12px;">Reset Filter</button>
            </div>

        </section>
    </main>
</section>
@endsection

@push('scripts')
<script>
let currentView = 'grid';

function setView(view) {
    currentView = view;
    const container = document.getElementById('katalog-container');
    const btnGrid   = document.getElementById('btn-grid');
    const btnList   = document.getElementById('btn-list');

    if (view === 'grid') {
        container.classList.remove('katalog-list');
        container.classList.add('katalog-grid');
        btnGrid.classList.add('active');
        btnList.classList.remove('active');
    } else {
        container.classList.remove('katalog-grid');
        container.classList.add('katalog-list');
        btnList.classList.add('active');
        btnGrid.classList.remove('active');
    }
}

function applyFilter() {
    const q       = document.getElementById('katalog-search').value.toLowerCase().trim();
    const sort    = document.getElementById('katalog-sort').value;
    const cards   = [...document.querySelectorAll('.katalog-card')];
    const container = document.getElementById('katalog-container');
    const empty   = document.getElementById('katalog-empty');
    const count   = document.getElementById('katalog-count');

    let visible = cards.filter(c => {
        const nama = c.dataset.nama;
        const desc = c.dataset.desc;
        return !q || nama.includes(q) || desc.includes(q);
    });

    visible.sort((a, b) => {
        if (sort === 'harga-asc')  return +a.dataset.harga  - +b.dataset.harga;
        if (sort === 'harga-desc') return +b.dataset.harga  - +a.dataset.harga;
        if (sort === 'durasi-asc') return +a.dataset.durasi - +b.dataset.durasi;
        if (sort === 'nama-asc')   return a.dataset.nama.localeCompare(b.dataset.nama);
        return 0;
    });

    cards.forEach(c => c.style.display = 'none');

    if (visible.length === 0) {
        empty.style.display = 'block';
        count.textContent = '';
    } else {
        empty.style.display = 'none';
        count.textContent = `Menampilkan ${visible.length} layanan`;

        visible.forEach(c => {
            c.style.display = '';
            container.appendChild(c);
        });
    }
}

function resetFilter() {
    document.getElementById('katalog-search').value = '';
    document.getElementById('katalog-sort').value   = 'default';
    applyFilter();
}

document.getElementById('katalog-search').addEventListener('input', applyFilter);
document.getElementById('katalog-sort').addEventListener('change', applyFilter);

document.addEventListener('DOMContentLoaded', () => {
    const total = document.querySelectorAll('.katalog-card').length;
    document.getElementById('katalog-count').textContent = `Menampilkan ${total} layanan`;
});
</script>
@endpush
