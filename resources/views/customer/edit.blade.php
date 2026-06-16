@extends('layouts.app')

@section('content')
<section class="hero">
    <h2>Edit Customer ✏️</h2>
    <p>Update customer data below</p>
</section>
<section class="container">
    <main>
        <section id="Welcome">
            <h2>Edit Customer Form</h2>
            <form action="{{ route('customer.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="frow">
                    <div class="fgroup">
                        <label>Name</label>
                        <input type="text" name="nama" value="{{ old('nama', $customer->nama) }}" class="{{ $errors->has('nama') ? 'err-field' : '' }}">
                        @error('nama')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="{{ $errors->has('email') ? 'err-field' : '' }}">
                        @error('email')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="frow">
                    <div class="fgroup">
                        <label>Phone Number</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $customer->no_hp) }}" class="{{ $errors->has('no_hp') ? 'err-field' : '' }}">
                        @error('no_hp')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Makeup Type</label>
                        <select name="jenis_makeup" class="{{ $errors->has('jenis_makeup') ? 'err-field' : '' }}">
                            <option value="">-- Select Makeup Type --</option>
                            <option value="Graduation" {{ old('jenis_makeup',$customer->jenis_makeup)=='Graduation' ? 'selected' : '' }}>Graduation</option>
                            <option value="Wedding" {{ old('jenis_makeup',$customer->jenis_makeup)=='Wedding' ? 'selected' : '' }}>Wedding</option>
                            <option value="Party" {{ old('jenis_makeup',$customer->jenis_makeup)=='Party' ? 'selected' : '' }}>Party</option>
                            <option value="Engagement" {{ old('jenis_makeup',$customer->jenis_makeup)=='Engagement' ? 'selected' : '' }}>Engagement</option>
                            <option value="Daily" {{ old('jenis_makeup',$customer->jenis_makeup)=='Daily' ? 'selected' : '' }}>Daily</option>
                        </select>
                        @error('jenis_makeup')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="frow">
                    <div class="fgroup">
                        <label>Price (Rp)</label>
                        <input type="number" name="harga" value="{{ old('harga', $customer->harga) }}" min="0" class="{{ $errors->has('harga') ? 'err-field' : '' }}">
                        @error('harga')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Booking Date</label>
                        <input type="date" name="tanggal_booking" value="{{ old('tanggal_booking', $customer->tanggal_booking) }}" class="{{ $errors->has('tanggal_booking') ? 'err-field' : '' }}">
                        @error('tanggal_booking')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="frow">
                    <div class="fgroup">
                        <label>New Photo (optional)</label>
                        @if($customer->foto)
                            <img src="{{ asset('storage/'.$customer->foto) }}" style="width:80px;border-radius:8px;margin-bottom:8px;display:block">
                        @endif
                        <input type="file" name="foto" accept="image/*">
                        @error('foto')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Status</label>
                        <select name="aktif">
                            <option value="1" {{ old('aktif', $customer->aktif ? '1' : '0')=='1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('aktif', $customer->aktif ? '1' : '0')=='0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="factions">
                    <a href="{{ route('customer.index') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save">💾 Update</button>
                </div>
            </form>
        </section>
    </main>
</section>
@endsection
