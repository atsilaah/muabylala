@extends('layouts.app')

@section('content')
<section class="hero">
    <h2>Add Customer ✨</h2>
    <p>Fill in the form to add a new customer booking</p>
</section>
<section class="container">
    <main>
        <section id="Welcome">
            <h2>Add Customer Form</h2>
            <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="frow">
                    <div class="fgroup">
                        <label>Name</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Full name" class="{{ $errors->has('nama') ? 'err-field' : '' }}">
                        @error('nama')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" class="{{ $errors->has('email') ? 'err-field' : '' }}">
                        @error('email')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="frow">
                    <div class="fgroup">
                        <label>Phone Number</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" class="{{ $errors->has('no_hp') ? 'err-field' : '' }}">
                        @error('no_hp')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Makeup Type</label>
                        <select name="jenis_makeup" class="{{ $errors->has('jenis_makeup') ? 'err-field' : '' }}">
                            <option value="">-- Select Makeup Type --</option>
                            <option value="Graduation" {{ old('jenis_makeup')=='Graduation' ? 'selected' : '' }}>Graduation</option>
                            <option value="Wedding" {{ old('jenis_makeup')=='Wedding' ? 'selected' : '' }}>Wedding</option>
                            <option value="Party" {{ old('jenis_makeup')=='Party' ? 'selected' : '' }}>Party</option>
                            <option value="Engagement" {{ old('jenis_makeup')=='Engagement' ? 'selected' : '' }}>Engagement</option>
                            <option value="Daily" {{ old('jenis_makeup')=='Daily' ? 'selected' : '' }}>Daily</option>
                        </select>
                        @error('jenis_makeup')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="frow">
                    <div class="fgroup">
                        <label>Price (Rp)</label>
                        <input type="number" name="harga" value="{{ old('harga') }}" placeholder="0" min="0" class="{{ $errors->has('harga') ? 'err-field' : '' }}">
                        @error('harga')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Booking Date</label>
                        <input type="date" name="tanggal_booking" value="{{ old('tanggal_booking') }}" class="{{ $errors->has('tanggal_booking') ? 'err-field' : '' }}">
                        @error('tanggal_booking')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="frow">
                    <div class="fgroup">
                        <label>Photo (optional)</label>
                        <input type="file" name="foto" accept="image/*">
                        @error('foto')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Status</label>
                        <select name="aktif">
                            <option value="1" {{ old('aktif','1')=='1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('aktif')=='0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="factions">
                    <a href="{{ route('customer.index') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save">💾 Save</button>
                </div>
            </form>
        </section>
    </main>
</section>
@endsection
