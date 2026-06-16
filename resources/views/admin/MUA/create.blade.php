@extends('layouts.app')
@section('content')
<section class="hero">
    <h2>Tambah MUA ✨</h2>
    <p>Tambah Makeup Artist baru</p>
</section>
<section class="container">
    <main>
        <section id="Welcome">
            <h2>Form Tambah MUA</h2>
            <form action="{{ route('admin.mua.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="frow">
                    <div class="fgroup">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            placeholder="Nama MUA" class="{{ $errors->has('name') ? 'err-field' : '' }}">
                        @error('name')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            placeholder="email@example.com" class="{{ $errors->has('email') ? 'err-field' : '' }}">
                        @error('email')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="frow">
                    <div class="fgroup">
                        <label>Password</label>
                        <input type="password" name="password"
                            placeholder="Min. 6 karakter" class="{{ $errors->has('password') ? 'err-field' : '' }}">
                        @error('password')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>No HP</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            placeholder="08xxxxxxxxxx">
                    </div>
                </div>
                <div class="frow">
                    <div class="fgroup">
                        <label>Spesialisasi</label>
                        <input type="text" name="spesialisasi" value="{{ old('spesialisasi') }}"
                            placeholder="cth: Wedding & Graduation">
                    </div>
                    <div class="fgroup">
                        <label>Foto</label>
                        <input type="file" name="foto" accept="image/*">
                        @error('foto')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="fgroup">
                    <label>Bio</label>
                    <textarea name="bio" placeholder="Deskripsi singkat tentang MUA...">{{ old('bio') }}</textarea>
                </div>
                <div class="factions">
                    <a href="{{ route('admin.mua.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-save">💾 Simpan</button>
                </div>
            </form>
        </section>
    </main>
</section>
@endsection
