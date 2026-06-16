@extends('layouts.app')

@section('page-title', 'Preferensi')

@section('content')
<div class="dash-welcome-bar">
    <div>
        <h1 class="dash-welcome-title">⚙️ Settings</h1>
        <p class="dash-welcome-sub">Atur tampilan sesuai selera kamu</p>
    </div>
</div>

<section id="Welcome">
    <h2>Pengaturan Tampilan</h2>
    <div id="pref-status" style="margin-bottom:16px;"></div>

    <div class="frow">
        <div class="fgroup">
            <label>Tema</label>
            <select id="pref-tema">
                <option value="light"  {{ ($tema ?? 'light') == 'light'  ? 'selected' : '' }}>☀️ Light</option>
                <option value="dark"   {{ ($tema ?? 'light') == 'dark'   ? 'selected' : '' }}>🌙 Dark</option>
            </select>
        </div>
        <div class="fgroup">
            <label>Ukuran Font</label>
            <select id="pref-font">
                <option value="small"  {{ ($font ?? 'medium') == 'small'  ? 'selected' : '' }}>Small (12px)</option>
                <option value="medium" {{ ($font ?? 'medium') == 'medium' ? 'selected' : '' }}>Medium (14px)</option>
                <option value="large"  {{ ($font ?? 'medium') == 'large'  ? 'selected' : '' }}>Large (16px)</option>
            </select>
        </div>
    </div>

    <div class="factions">
        <button onclick="simpanPref()" class="btn-save">💾 Simpan Settings</button>
    </div>
</section>
@endsection

@push('scripts')
<script>
const prefUrl = "{{ route(auth()->user()->role . '.preferensi.update') }}";

async function simpanPref() {
    const tema = document.getElementById('pref-tema').value;
    const font = document.getElementById('pref-font').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    try {
        const res = await fetch(prefUrl, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ tema, font })
        });

        const data = await res.json();

        if (data.status === 'ok') {
            localStorage.setItem('tema', tema);
            localStorage.setItem('fontsize', font);

            if (tema === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            applyFontSize(font);

            const btnDark = document.getElementById('btn-dark');
            if (btnDark) btnDark.textContent = tema === 'dark' ? '☀️' : '🌙';

            document.getElementById('pref-status').innerHTML =
                '<div class="flash-success">✅ Settings berhasil disimpan!</div>';
            setTimeout(() => {
                const el = document.getElementById('pref-status');
                if (el) el.innerHTML = '';
            }, 3000);
        } else {
            throw new Error('Server error');
        }
    } catch (e) {
        document.getElementById('pref-status').innerHTML =
            '<div class="flash-error">❌ Gagal menyimpan settings.</div>';
    }
}
</script>
@endpush
