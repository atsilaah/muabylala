@extends('layouts.app')

@section('content')
<section class="hero">
    <h2>Customer Detail 👰</h2>
    <p>Detail data customer Makeup Artist by Lala</p>
</section>
<section class="container">
    <main>
        <section id="Welcome">
            <h2>{{ $customer->nama }}</h2>
            <div style="margin-top:20px;">
                @if($customer->foto)
                    <img src="{{ asset('storage/'.$customer->foto) }}" style="width:120px;border-radius:12px;margin-bottom:16px;display:block">
                @endif
                <table>
                    <tbody>
                        <tr><td><b>Email</b></td><td>{{ $customer->email }}</td></tr>
                        <tr><td><b>Phone</b></td><td>{{ $customer->no_hp }}</td></tr>
                        <tr><td><b>Makeup Type</b></td><td>{{ $customer->jenis_makeup }}</td></tr>
                        <tr><td><b>Price</b></td><td>Rp {{ number_format($customer->harga, 0, ',', '.') }}</td></tr>
                        <tr><td><b>Booking Date</b></td><td>{{ \Carbon\Carbon::parse($customer->tanggal_booking)->format('d/m/Y') }}</td></tr>
                        <tr><td><b>Status</b></td><td>
                            @if($customer->aktif)
                                <span class="stok-aman">Active</span>
                            @else
                                <span class="stok-tipis">Inactive</span>
                            @endif
                        </td></tr>
                    </tbody>
                </table>
                <div class="factions" style="margin-top:24px;">
                    <a href="{{ route('customer.index') }}" class="btn-cancel">Back</a>
                    <a href="{{ route('customer.edit', $customer->id) }}" class="btn-save">✏️ Edit</a>
                </div>
            </div>
        </section>
    </main>
</section>
@endsection
