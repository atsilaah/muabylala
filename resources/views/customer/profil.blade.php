@extends('layouts.app')
@section('page-title', 'Profil Saya')

@section('content')
<div class="dash-page-header">
    <h1>👤 Profil</h1>
    <p>Kelola informasi akun kamu</p>
</div>

<section id="Welcome">
    <h2>Edit Profil</h2>

    <form action="{{ route(auth()->user()->role . '.profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display:grid;grid-template-columns:220px 1fr;gap:2rem;align-items:start;">

            <div style="text-align:center;">
                <div style="position:relative;display:inline-block;margin-bottom:12px;">
                    @if(auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}"
                             alt="Foto Profil"
                             id="foto-preview"
                             style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:3px solid var(--pink);box-shadow:0 4px 16px rgba(196,72,106,.2);">
                    @else
                        <div id="foto-placeholder"
                             style="width:120px;height:120px;background:var(--grad);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:48px;color:white;font-weight:700;margin:0 auto;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <img id="foto-preview"
                             style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:3px solid var(--pink);display:none;box-shadow:0 4px 16px rgba(196,72,106,.2);"
                             src="" alt="Preview">
                    @endif
                </div>

                <div style="font-family:'Playfair Display',serif;font-size:16px;font-weight:700;color:var(--deep);">
                    {{ auth()->user()->name }}
                </div>
                <div style="font-size:11px;color:var(--muted);letter-spacing:1px;text-transform:uppercase;margin-top:4px;">
                    {{ ucfirst(auth()->user()->role) }}
                </div>
                <div style="margin-top:14px;">
                    <label for="photo-input"
                           style="display:inline-block;padding:8px 18px;background:var(--grad);color:white;border-radius:20px;font-size:13px;font-weight:600;cursor:pointer;box-shadow:0 4px 12px rgba(196,72,106,.25);">
                        📷 Ganti Foto
                    </label>
                    <input type="file" id="photo-input" name="photo" accept="image/*" style="display:none;">
                    <div style="font-size:11px;color:var(--muted);margin-top:6px;">JPG, PNG, WEBP · Maks 2MB</div>
                </div>
                @error('photo')
                    <div style="color:#e74c3c;font-size:12px;margin-top:6px;">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <div class="frow">
                    <div class="fgroup">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name"
                               value="{{ old('name', auth()->user()->name) }}"
                               class="{{ $errors->has('name') ? 'err-field' : '' }}">
                        @error('name')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Email</label>
                        <input type="email" value="{{ auth()->user()->email }}" disabled
                               style="opacity:.6;cursor:not-allowed;">
                    </div>
                </div>

                <div class="frow">
                    <div class="fgroup">
                        <label>No HP</label>
                        <input type="text" name="phone"
                               value="{{ old('phone', auth()->user()->phone) }}"
                               placeholder="08xxxxxxxxxx">
                    </div>
                    <div class="fgroup">
                        <label>Alamat</label>
                        <input type="text" name="address"
                               value="{{ old('address', auth()->user()->address) }}"
                               placeholder="Alamat lengkap...">
                    </div>
                </div>

                <div class="frow">
                    <div class="fgroup">
                        <label>Password Baru <span style="font-weight:400;font-size:11px;color:var(--muted);">(kosongkan jika tidak diubah)</span></label>
                        <input type="password" name="password" placeholder="••••••••">
                        @error('password')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••">
                    </div>
                </div>

                <div class="factions">
                    <button type="submit" class="btn-save">💾 Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </form>
</section>

@push('scripts')
<script>
document.getElementById('photo-input').addEventListener('change', function() {
    var file = this.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function(e) {
        var preview = document.getElementById('foto-preview');
        var placeholder = document.getElementById('foto-placeholder');
        preview.src = e.target.result;
        preview.style.display = 'block';
        if (placeholder) placeholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
});
</script>
@endpush
@endsection
