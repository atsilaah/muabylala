@extends('layouts.app')
@section('content')
<section class="hero">
    <h2>Tambah Layanan ✨</h2>
    <p>Tambah layanan makeup baru</p>
</section>
<section class="container">
    <main>
        <section id="Welcome">
            <h2>Form Tambah Layanan</h2>
            <form action="{{ route('admin.layanan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="frow">
                    <div class="fgroup">
                        <label>Nama Layanan</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="cth: Wedding Makeup" class="{{ $errors->has('nama') ? 'err-field' : '' }}">
                        @error('nama')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Harga (Rp)</label>
                        <input type="number" name="harga" value="{{ old('harga') }}" placeholder="0" min="0" class="{{ $errors->has('harga') ? 'err-field' : '' }}">
                        @error('harga')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="frow">
                    <div class="fgroup">
                        <label>Harga Hairdo/Hijab (Rp)</label>
                        <input type="number" name="harga_hairdo" value="{{ old('harga_hairdo', 50000) }}" placeholder="50000" min="0">
                    </div>
                    <div class="fgroup">
                        <label>Durasi (menit)</label>
                        <input type="number" name="durasi" value="{{ old('durasi', 120) }}" placeholder="120" min="30" class="{{ $errors->has('durasi') ? 'err-field' : '' }}">
                        @error('durasi')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="frow">
                    <div class="fgroup">
                        <label>Foto Layanan</label>
                        <input type="file" name="foto" accept="image/*">
                        @error('foto')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Status</label>
                        <select name="is_active">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="fgroup">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" placeholder="Deskripsi layanan...">{{ old('deskripsi') }}</textarea>
                </div>
                <div class="factions">
                    <a href="{{ route('admin.layanan.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-save">💾 Simpan</button>
                </div>
            </form>
        </section>
    </main>
</section>
@endsection
