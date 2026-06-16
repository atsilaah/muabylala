@extends('layouts.app')
@section('content')
<section class="hero">
    <h2>Edit MUA ✏️</h2>
    <p>Ubah data Makeup Artist</p>
</section>
<section class="container">
    <main>
        <section id="Welcome">
            <h2>Form Edit MUA</h2>
            <form action="{{ route('admin.mua.update', $mua->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="frow">
                    <div class="fgroup">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $mua->user->name) }}"
                            class="{{ $errors->has('name') ? 'err-field' : '' }}">
                        @error('name')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $mua->user->email) }}"
                            class="{{ $errors->has('email') ? 'err-field' : '' }}">
                        @error('email')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="frow">
                    <div class="fgroup">
                        <label>No HP</label>
                        <input type="text" name="phone" value="{{ old('phone', $mua->user->phone) }}"
                            placeholder="08xxxxxxxxxx">
                    </div>
                    <div class="fgroup">
                        <label>Spesialisasi</label>
                        <input type="text" name="spesialisasi"
                            value="{{ old('spesialisasi', $mua->spesialisasi) }}"
                            placeholder="cth: Wedding & Graduation">
                    </div>
                </div>
                <div class="frow">
                    <div class="fgroup">
                        <label>Foto Baru (opsional)</label>
                        @if($mua->foto)
                            <img src="{{ asset('storage/'.$mua->foto) }}"
                                style="width:60px;height:60px;object-fit:cover;border-radius:50%;margin-bottom:8px;display:block;border:2px solid var(--blush);">
                        @endif
                        <input type="file" name="foto" accept="image/*">
                    </div>
                    <div class="fgroup">
                        <label>Status</label>
                        <select name="is_active">
                            <option value="1" {{ $mua->is_active ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$mua->is_active ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="fgroup">
                    <label>Bio</label>
                    <textarea name="bio">{{ old('bio', $mua->bio) }}</textarea>
                </div>
                <div class="factions">
                    <a href="{{ route('admin.mua.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-save">💾 Update</button>
                </div>
            </form>
        </section>
    </main>
</section>
@endsection
