@extends('layouts.app')
@section('page-title', 'Profil Saya')

@section('content')
<div class="dash-page-header">
    <h1>👤 Profil</h1>
    <p>Kelola informasi akun kamu</p>
</div>

<section id="Welcome">
    <h2>Edit Profil</h2>

    <form action="{{ route('mua.profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="profil-layout">

            {{-- FOTO --}}
            <div class="profil-foto-wrap">
                @if(auth()->user()->photo)
                    <img src="{{ asset('storage/' . auth()->user()->photo) }}"
                         id="foto-preview" class="profil-foto-img" alt="Foto Profil">
                @else
                    <div class="profil-foto-placeholder" id="foto-placeholder">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <img id="foto-preview" src="" alt="Preview"
                         class="profil-foto-img" style="display:none;">
                @endif

                <div class="profil-nama">{{ auth()->user()->name }}</div>
                <div class="profil-role">MUA</div>

                <label for="photo-input" class="profil-foto-label">📷 Ganti Foto</label>
                <input type="file" id="photo-input" name="photo" accept="image/*" style="display:none;">
                <div class="profil-foto-hint">JPG, PNG, WEBP · Maks 2MB</div>
                @error('photo')<div class="ferr tampil">{{ $message }}</div>@enderror
            </div>

            {{-- FORM --}}
            <div>
                <div class="frow">
                    <div class="fgroup">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                        @error('name')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Email</label>
                        <input type="email" value="{{ auth()->user()->email }}" disabled class="profil-email-disabled">
                    </div>
                </div>
                <div class="frow">
                    <div class="fgroup">
                        <label>No HP</label>
                        <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" placeholder="08xxxxxxxxxx">
                    </div>
                    <div class="fgroup">
                        <label>Alamat</label>
                        <input type="text" name="address" value="{{ old('address', auth()->user()->address) }}" placeholder="Alamat lengkap...">
                    </div>
                </div>
                <div class="frow">
                    <div class="fgroup">
                        <label>Password Baru <small style="font-weight:400;text-transform:none;letter-spacing:0;">(kosongkan jika tidak diubah)</small></label>
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
        var preview     = document.getElementById('foto-preview');
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
