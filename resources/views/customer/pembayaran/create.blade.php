@extends('layouts.app')
@section('content')
<section class="hero">
    <h2>Pembayaran 💳</h2>
    <p>Upload bukti pembayaran booking kamu</p>
</section>
<section class="container">
    <main>
        <section id="Welcome">
            <h2>Form Pembayaran</h2>

            <div class="total-booking-box" style="margin-bottom:24px;">
                <div class="total-label">Detail Booking</div>
                <div style="margin-top:12px;text-align:left;">
                    <table>
                        <tbody>
                            <tr><td><b>Layanan</b></td><td>{{ $booking->layanan->nama }}</td></tr>
                            <tr><td><b>MUA</b></td><td>{{ $booking->mua->user->name }}</td></tr>
                            <tr><td><b>Tanggal</b></td><td>{{ \Carbon\Carbon::parse($booking->tanggal)->format('d F Y') }}</td></tr>
                            <tr><td><b>Jam</b></td><td>{{ $booking->jam_mulai }} — {{ $booking->jam_selesai }}</td></tr>
                            <tr><td><b>Jumlah Orang</b></td><td>{{ $booking->jumlah_orang }} orang</td></tr>
                            <tr><td><b>Hairdo</b></td><td>{{ $booking->add_hairdo ? 'Ya' : 'Tidak' }}</td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="total-label" style="margin-top:16px;">Total Pembayaran</div>
                <div class="total-value">Rp {{ number_format($booking->total_harga,0,',','.') }}</div>
            </div>

            <form action="{{ route('customer.pembayaran.store', $booking->id) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="frow">
                    <div class="fgroup">
                        <label>Metode Pembayaran</label>
                        <select name="metode" class="{{ $errors->has('metode') ? 'err-field' : '' }}">
                            <option value="">-- Pilih Bank/E-Wallet --</option>
                            <optgroup label="Transfer Bank">
                                <option value="BRI"       {{ old('metode')=='BRI'       ? 'selected':'' }}>Bank BRI</option>
                                <option value="BNI"       {{ old('metode')=='BNI'       ? 'selected':'' }}>Bank BNI</option>
                                <option value="Mandiri"   {{ old('metode')=='Mandiri'   ? 'selected':'' }}>Bank Mandiri</option>
                                <option value="BCA"       {{ old('metode')=='BCA'       ? 'selected':'' }}>Bank BCA</option>
                                <option value="Bank Jatim"{{ old('metode')=='Bank Jatim'? 'selected':'' }}>Bank Jatim</option>
                            </optgroup>
                            <optgroup label="E-Wallet">
                                <option value="GoPay" {{ old('metode')=='GoPay' ? 'selected':'' }}>GoPay</option>
                                <option value="OVO"   {{ old('metode')=='OVO'   ? 'selected':'' }}>OVO</option>
                                <option value="DANA"  {{ old('metode')=='DANA'  ? 'selected':'' }}>DANA</option>
                            </optgroup>
                        </select>
                        @error('metode')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Upload Bukti Pembayaran</label>
                        <input type="file" name="bukti_foto" accept="image/*"
                            class="{{ $errors->has('bukti_foto') ? 'err-field' : '' }}">
                        <small style="color:var(--muted);font-size:11px;margin-top:4px;display:block;">
                            Format: JPG/PNG, maks 2MB
                        </small>
                        @error('bukti_foto')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div style="background:var(--warm);border-radius:14px;padding:18px 20px;margin-bottom:20px;">
                    <p style="font-size:13px;font-weight:600;color:var(--deep);margin-bottom:10px;">📋 Info Rekening MUA by Lala:</p>
                    <p style="font-size:13px;color:var(--text);line-height:1.8;">
                        🏦 BRI: <strong>1234-5678-9012-3456</strong> a/n Makeup Artist Lala<br>
                        🏦 BCA: <strong>9876-5432-1098-7654</strong> a/n Makeup Artist Lala<br>
                        🏦 Bank Jatim: <strong>1111-2222-3333-4444</strong> a/n Makeup Artist Lala<br>
                        💚 GoPay/OVO/DANA: <strong>0812-3456-7890</strong>
                    </p>
                </div>

                <div class="factions">
                    <a href="{{ route('customer.booking.show', $booking->id) }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-save">💳 Upload Bukti Bayar</button>
                </div>
            </form>
        </section>
    </main>
</section>
@endsection
