@extends('layouts.app')
@section('content')
<section class="hero">
    <h2>Buat Booking ✨</h2>
    <p>Isi form booking layanan makeup kamu</p>
</section>
<section class="container">
    <main>
        <section id="Welcome">
            <h2>Form Booking</h2>
            <form action="{{ route('customer.booking.store') }}" method="POST" id="form-booking">
                @csrf
                <div class="frow">
                    <div class="fgroup">
                        <label>Layanan</label>
                        <select name="layanan_id" id="layanan_id" class="{{ $errors->has('layanan_id') ? 'err-field' : '' }}">
                            <option value="">-- Pilih Layanan --</option>
                            @foreach($layanans as $l)
                                <option value="{{ $l->id }}"
                                    data-harga="{{ $l->harga }}"
                                    data-hairdo="{{ $l->harga_hairdo }}"
                                    data-durasi="{{ $l->durasi }}"
                                    {{ (old('layanan_id', $layanan?->id) == $l->id) ? 'selected' : '' }}>
                                    {{ $l->nama }} — Rp {{ number_format($l->harga,0,',','.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('layanan_id')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Jumlah Orang</label>
                        <input type="number" name="jumlah_orang" id="jumlah_orang"
                            value="{{ old('jumlah_orang', 1) }}" min="1" max="20">
                        @error('jumlah_orang')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="frow">
                    <div class="fgroup">
                        <label>Tanggal Booking</label>
                        <input type="date" name="tanggal" id="tanggal"
                            value="{{ old('tanggal') }}"
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                            class="{{ $errors->has('tanggal') ? 'err-field' : '' }}">
                        @error('tanggal')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Pilih MUA</label>
                        <select name="mua_id" id="mua_id" class="{{ $errors->has('mua_id') ? 'err-field' : '' }}">
                            <option value="">-- Pilih MUA --</option>
                            @foreach($muas as $m)
                                <option value="{{ $m->id }}" {{ old('mua_id') == $m->id ? 'selected' : '' }}>
                                    {{ $m->user->name }} — {{ $m->spesialisasi ?? 'MUA Profesional' }}
                                </option>
                            @endforeach
                        </select>
                        @error('mua_id')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="fgroup" id="slot-wrapper" style="display:none;">
                    <label>Pilih Jam</label>
                    <div class="slot-grid" id="slot-grid"></div>
                    <input type="hidden" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai') }}">
                    @error('jam_mulai')<div class="ferr tampil">{{ $message }}</div>@enderror
                </div>

                <div class="frow">
                    <div class="fgroup">
                        <label>Alamat Lengkap</label>
                        <textarea name="alamat" placeholder="Masukkan alamat lengkap untuk MUA datang...">{{ old('alamat') }}</textarea>
                        @error('alamat')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Catatan (opsional)</label>
                        <textarea name="catatan" placeholder="Catatan tambahan untuk MUA...">{{ old('catatan') }}</textarea>
                    </div>
                </div>

                <div class="fgroup">
                    <label style="flex-direction:row;display:flex;align-items:center;gap:10px;text-transform:none;font-size:14px;font-weight:500;cursor:pointer;">
                        <input type="checkbox" name="add_hairdo" id="add_hairdo" value="1"
                            {{ old('add_hairdo') ? 'checked' : '' }}
                            style="width:18px;height:18px;accent-color:var(--rose);">
                        Tambah Hairdo / Hijab Style
                        <span id="hairdo-price" style="color:var(--rose);font-weight:600;"></span>
                    </label>
                </div>

                <div class="total-booking-box">
                    <div class="total-label">Estimasi Total</div>
                    <div class="total-value" id="total-display">Rp 0</div>
                    <div class="total-note" id="total-note"></div>
                </div>

                <div class="factions">
                    <a href="{{ route('customer.katalog') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-save">📅 Buat Booking</button>
                </div>
            </form>
        </section>
    </main>
</section>
@endsection

@push('scripts')
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function hitungTotal() {
    const layananEl = document.getElementById('layanan_id');
    const jumlah    = parseInt(document.getElementById('jumlah_orang').value) || 1;
    const hairdo    = document.getElementById('add_hairdo').checked;
    const opt       = layananEl.options[layananEl.selectedIndex];

    if (!opt || !opt.value) {
        document.getElementById('total-display').textContent = 'Rp 0';
        document.getElementById('hairdo-price').textContent  = '';
        document.getElementById('total-note').textContent    = '';
        return;
    }

    const harga      = parseInt(opt.dataset.harga)  || 0;
    const hairdoHrg  = parseInt(opt.dataset.hairdo) || 50000;
    const durasi     = opt.dataset.durasi;
    let total        = harga * jumlah;

    document.getElementById('hairdo-price').textContent = `(+Rp ${hairdoHrg.toLocaleString('id-ID')}/orang)`;

    if (hairdo) total += hairdoHrg * jumlah;

    document.getElementById('total-display').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('total-note').textContent    =
        `${jumlah} orang × Rp ${harga.toLocaleString('id-ID')}${hairdo ? ` + hairdo` : ''} | Durasi: ${durasi} menit`;
}

async function loadSlots() {
    const muaId    = document.getElementById('mua_id').value;
    const layananId= document.getElementById('layanan_id').value;
    const tanggal  = document.getElementById('tanggal').value;
    const wrapper  = document.getElementById('slot-wrapper');
    const grid     = document.getElementById('slot-grid');

    if (!muaId || !layananId || !tanggal) {
        wrapper.style.display = 'none';
        return;
    }

    grid.innerHTML = '<p style="color:var(--muted)">⏳ Memuat slot...</p>';
    wrapper.style.display = 'block';

    try {
        const res  = await fetch(`/customer/get-slots?mua_id=${muaId}&layanan_id=${layananId}&tanggal=${tanggal}`, {
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
        });
        const slots = await res.json();

        grid.innerHTML = '';
        slots.forEach(s => {
            const btn = document.createElement('button');
            btn.type        = 'button';
            btn.textContent = s.jam;
            btn.className   = `slot-btn ${s.available ? 'available' : 'unavailable'}`;
            if (s.available) {
                btn.onclick = () => {
                    document.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));
                    btn.classList.add('selected');
                    document.getElementById('jam_mulai').value = s.jam;
                };
            }
            grid.appendChild(btn);
        });
    } catch(e) {
        grid.innerHTML = '<p style="color:#c0392b">❌ Gagal memuat slot.</p>';
    }
}

document.getElementById('layanan_id').addEventListener('change', () => { hitungTotal(); loadSlots(); });
document.getElementById('jumlah_orang').addEventListener('input', hitungTotal);
document.getElementById('add_hairdo').addEventListener('change', hitungTotal);
document.getElementById('mua_id').addEventListener('change', loadSlots);
document.getElementById('tanggal').addEventListener('change', loadSlots);

hitungTotal();
</script>
@endpush
