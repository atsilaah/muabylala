@extends('layouts.app')
@section('page-title', 'Manajemen MUA')
@section('content')

<div class="dash-welcome-bar">
    <div>
        <h1 class="dash-welcome-title">Manajemen MUA 💄</h1>
        <p class="dash-welcome-sub">Kelola data makeup artist</p>
    </div>
</div>

<section id="Inventory">
    <h2>💄 Daftar MUA</h2>
    <div class="inv-topbar">
        <a href="{{ route('admin.mua.create') }}" class="btn-tambah">+ Tambah MUA</a>
    </div>
    <div class="inv-table-wrap">
        <table id="inv-table">
            <thead>
                <tr><th>Nama</th><th>Email</th><th>Spesialisasi</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($muas as $m)
                <tr>
                    <td><strong>{{ $m->user->name }}</strong></td>
                    <td>{{ $m->user->email }}</td>
                    <td>{{ $m->spesialisasi ?? '-' }}</td>
                    <td>
                        @if($m->is_active ?? true)
                            <span class="stok-aman">Aktif</span>
                        @else
                            <span class="stok-tipis">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.mua.edit', $m->id) }}" class="btn-edit-row">Edit</a>
                        <form action="{{ route('admin.mua.destroy', $m->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-del-row" onclick="return confirm('Hapus MUA ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="inv-empty"><span>💄</span>Belum ada MUA.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@endsection
