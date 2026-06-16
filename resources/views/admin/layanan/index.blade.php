@extends('layouts.app')
@section('page-title', 'Manajemen Layanan')
@section('content')

<div class="dash-welcome-bar">
    <div>
        <h1 class="dash-welcome-title">Manajemen Layanan 💄</h1>
        <p class="dash-welcome-sub">Kelola layanan makeup MUA by Lala</p>
    </div>
</div>

<section id="Inventory">
    <h2>💄 Daftar Layanan</h2>
    <div class="inv-topbar">
        <a href="{{ route('admin.layanan.create') }}" class="btn-tambah">+ Tambah Layanan</a>
    </div>
    <div class="inv-table-wrap">
        <table id="inv-table">
            <thead>
                <tr>
                    <th>Foto</th><th>Nama</th><th>Harga</th>
                    <th>Harga Hairdo</th><th>Durasi</th><th>Status</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($layanans as $l)
                <tr>
                    <td>
                        @if($l->foto)
                            <img src="{{ asset('storage/'.$l->foto) }}"
                                style="width:50px;height:50px;object-fit:cover;border-radius:8px;">
                        @else
                            <div style="width:50px;height:50px;background:var(--warm);border-radius:8px;display:flex;align-items:center;justify-content:center;">💄</div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $l->nama }}</strong><br>
                        <small style="color:var(--muted)">{{ Str::limit($l->deskripsi, 50) }}</small>
                    </td>
                    <td>Rp {{ number_format($l->harga, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($l->harga_hairdo, 0, ',', '.') }}</td>
                    <td>{{ $l->durasi }} menit</td>
                    <td>
                        @if($l->is_active)
                            <span class="stok-aman">Aktif</span>
                        @else
                            <span class="stok-tipis">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.layanan.edit', $l->id) }}" class="btn-edit-row">Edit</a>
                        <form action="{{ route('admin.layanan.destroy', $l->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-del-row"
                                onclick="return confirm('Hapus layanan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="inv-empty">
                        <span>💄</span>
                        Belum ada layanan. <a href="{{ route('admin.layanan.create') }}">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:1.25rem;">{{ $layanans->links() }}</div>
</section>

@endsection
