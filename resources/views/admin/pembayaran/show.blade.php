@extends('layouts.app')
@section('page-title', 'Detail Pembayaran')
@section('content')

<div class="dash-welcome-bar">
    <div>
        <h1 class="dash-welcome-title">Detail Pembayaran 💳</h1>
        <p class="dash-welcome-sub">Verifikasi bukti pembayaran customer</p>
    </div>
</div>

<section id="Welcome">
    <h2>💳 Detail Pembayaran #{{ $pembayaran->id }}</h2>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-top:8px;">

        <div>
            <table style="width:100%">
                <tbody>
                    <tr>
                        <td style="padding:8px 0;font-size:13px;color:var(--muted);font-weight:600;width:40%">Customer</td>
                        <td style="font-size:13px">{{ $pembayaran->booking->customer->name }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;font-size:13px;color:var(--muted);font-weight:600">Layanan</td>
                        <td style="font-size:13px">{{ $pembayaran->booking->layanan->nama }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;font-size:13px;color:var(--muted);font-weight:600">MUA</td>
                        <td style="font-size:13px">{{ $pembayaran->booking->mua->user->name }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;font-size:13px;color:var(--muted);font-weight:600">Tanggal Booking</td>
                        <td style="font-size:13px">{{ \Carbon\Carbon::parse($pembayaran->booking->tanggal)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;font-size:13px;color:var(--muted);font-weight:600">Total</td>
                        <td style="font-size:14px;font-weight:700;color:var(--deep)">
                            Rp {{ number_format($pembayaran->booking->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;font-size:13px;color:var(--muted);font-weight:600">Metode</td>
                        <td style="font-size:13px">{{ strtoupper($pembayaran->metode) }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;font-size:13px;color:var(--muted);font-weight:600">Status</td>
                        <td>
                            <span class="badge-status badge-{{ $pembayaran->status }}">
                                {{ ucfirst($pembayaran->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0;font-size:13px;color:var(--muted);font-weight:600">Tanggal Bayar</td>
                        <td style="font-size:13px">{{ $pembayaran->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @if($pembayaran->confirmed_at)
                    <tr>
                        <td style="padding:8px 0;font-size:13px;color:var(--muted);font-weight:600">Dikonfirmasi</td>
                        <td style="font-size:13px">{{ \Carbon\Carbon::parse($pembayaran->confirmed_at)->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            @if($pembayaran->status === 'pending')
            <div style="margin-top:20px;">
                <form action="{{ route('admin.pembayaran.confirm', $pembayaran->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-save"
                        onclick="return confirm('Konfirmasi pembayaran ini? Booking otomatis akan dikonfirmasi.')">
                        ✅ Konfirmasi Pembayaran
                    </button>
                </form>
            </div>
            @else
            <div style="margin-top:20px;">
                <div class="flash-success" style="margin:0">
                    ✅ Pembayaran sudah dikonfirmasi
                </div>
            </div>
            @endif
        </div>

        <div>
            <div style="font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-bottom:12px;">
                Bukti Pembayaran
            </div>
            @if($pembayaran->bukti_foto)
                <a href="{{ asset('storage/' . $pembayaran->bukti_foto) }}" target="_blank">
                    <img src="{{ asset('storage/' . $pembayaran->bukti_foto) }}"
                         alt="Bukti Pembayaran"
                         style="width:100%;max-width:400px;border-radius:12px;border:2px solid rgba(232,120,154,.2);box-shadow:0 4px 16px rgba(196,72,106,.1);cursor:zoom-in;">
                </a>
                <p style="font-size:12px;color:var(--muted);margin-top:8px;">
                    Klik gambar untuk melihat ukuran penuh
                </p>
            @else
                <div style="background:var(--light);border-radius:12px;padding:40px;text-align:center;border:2px dashed rgba(232,120,154,.3);">
                    <div style="font-size:48px;margin-bottom:12px;">📎</div>
                    <div style="font-size:13px;color:var(--muted)">Belum ada bukti pembayaran diunggah</div>
                </div>
            @endif
        </div>

    </div>

    <div class="factions" style="margin-top:24px;">
        <a href="{{ route('admin.pembayaran.index') }}" class="btn-cancel">← Kembali</a>
    </div>
</section>

@endsection
