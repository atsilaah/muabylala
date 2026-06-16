@extends('layouts.app')
@section('content')
<section class="hero">
    <h2>Edit Layanan ✏️</h2>
    <p>Ubah data layanan makeup</p>
</section>
<section class="container">
    <main>
        <section id="Welcome">
            <h2>Form Edit Layanan</h2>
            <form action="{{ route('admin.layanan.update', $layanan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="frow">
                    <div class="fgroup">
                        <label>Nama Layanan</label>
                        <input type="text" name="nama" value="{{ old('nama', $layanan->nama) }}" class="{{ $errors->has('nama') ? 'err-field' : '' }}">
                        @error('nama')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Harga (Rp)</label>
                        <input type="number" name="harga" value="{{ old('harga', $layanan->harga) }}" min="0" class="{{ $errors->has('harga') ? 'err-field' : '' }}">
                        @error('harga')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="frow">
                    <div class="fgroup">
                        <label>Harga Hairdo/Hijab (Rp)</label>
                        <input type="number" name="harga_hairdo" value="{{ old('harga_hairdo', $layanan->harga_hairdo) }}" min="0">
                    </div>
                    <div class="fgroup">
                        <label>Durasi (menit)</label>
                        <input type="number" name="durasi" value="{{ old('durasi', $layanan->durasi) }}" min="30" class="{{ $errors->has('durasi') ? 'err-field' : '' }}">
                        @error('durasi')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="frow">
                    <div class="fgroup">
                        <label>Foto Baru (opsional)</label>
                        @if($layanan->foto)
                            <img src="{{ asset('storage/'.$layanan->foto) }}"
                                style="width:80px;height:80px;object-fit:cover;border-radius:10px;margin-bottom:8px;display:block;">
                        @endif
                        <input type="file" name="foto" accept="image/*">
                    </div>
                    <div class="fgroup">
                        <label>Status</label>
                        <select name="is_active">
                            <option value="1" {{ $layanan->is_active ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$layanan->is_active ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="fgroup">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
                </div>
                <div class="factions">
                    <a href="{{ route('admin.layanan.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-save">💾 Update</button>
                </div>
            </form>
        </section>
    </main>
</section>
@endsection
