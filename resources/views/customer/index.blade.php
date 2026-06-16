@extends('layouts.app')

@section('content')
<section class="hero">
    <h2>Customer Data 👰</h2>
    <p>List of Makeup Artist by Lala customers</p>
</section>
<section class="container">
    <main>
        <section id="LiveSearch">
            <h2>🔍 Live Search Customer</h2>
            <div class="inv-topbar">
                <input type="text" id="live-search" class="inv-search"
                    placeholder="🔍 Cari nama, email, atau jenis makeup...">
            </div>
            <div id="search-result" style="margin-top:12px;"></div>
        </section>

        <section id="Inventory">
            <h2>👰 Customer Data</h2>
            <div class="inv-stats">
                <x-stat-card judul="Total Customer" nilai="{{ $customers->total() }}" ikon="👰" />
                <x-stat-card judul="Active Customer" nilai="{{ \App\Models\Customer::where('aktif', true)->where('user_id', auth()->id())->count() }}" ikon="✅" />
                <x-stat-card judul="Avg Price" nilai="Rp {{ number_format(\App\Models\Customer::where('user_id', auth()->id())->avg('harga'), 0, ',', '.') }}" ikon="💰" />
            </div>
            <div class="inv-topbar">
                <a href="{{ route('customer.create') }}" class="btn-tambah">+ Add Customer</a>
            </div>
            <div class="inv-table-wrap">
                <table id="inv-table">
                    <thead>
                        <tr>
                            <th>Name</th><th>Email</th><th>Phone</th>
                            <th>Makeup Type</th><th>Price</th><th>Booking Date</th><th>Status</th><th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $c)
                        <tr>
                            <td>{{ $c->nama }}</td>
                            <td>{{ $c->email }}</td>
                            <td>{{ $c->no_hp }}</td>
                            <td>{{ $c->jenis_makeup }}</td>
                            <td>Rp {{ number_format($c->harga, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($c->tanggal_booking)->format('d/m/Y') }}</td>
                            <td>
                                @if($c->aktif)
                                    <span class="stok-aman">Active</span>
                                @else
                                    <span class="stok-tipis">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('customer.show', $c->id) }}" class="btn-edit-row">Detail</a>
                                <a href="{{ route('customer.edit', $c->id) }}" class="btn-edit-row">Edit</a>
                                <form action="{{ route('customer.destroy', $c->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-del-row"
                                        onclick="return confirm('Delete this customer?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="inv-empty">
                                <span>👰</span>
                                No customer data yet.
                                <a href="{{ route('customer.create') }}">Add now</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="margin-top:20px;">
                {{ $customers->links() }}
            </div>
        </section>

    </main>
</section>
@endsection

@push('scripts')
<script>
const liveSearch  = document.getElementById('live-search');
const searchResult = document.getElementById('search-result');
const csrfToken   = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

let timeout = null;

liveSearch.addEventListener('input', function () {
    clearTimeout(timeout);
    const q = this.value.trim();

    if (q.length === 0) {
        searchResult.innerHTML = '';
        return;
    }

    searchResult.innerHTML = '<p style="color:var(--muted)">⏳ Mencari...</p>';

    timeout = setTimeout(async () => {
        try {
            const res = await fetch(`/customer-search?q=${encodeURIComponent(q)}`, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });
            const data = await res.json();

            if (data.length === 0) {
                searchResult.innerHTML = '<p style="color:var(--muted)">Tidak ada hasil ditemukan.</p>';
                return;
            }

            let html = `<div class="inv-table-wrap">
                <table id="inv-table">
                <thead><tr>
                    <th>Name</th><th>Email</th><th>Makeup Type</th><th>Price</th><th>Status</th>
                </tr></thead><tbody>`;

            data.forEach(c => {
                const status = c.aktif
                    ? '<span class="stok-aman">Active</span>'
                    : '<span class="stok-tipis">Inactive</span>';
                html += `<tr>
                    <td>${c.nama}</td>
                    <td>${c.email}</td>
                    <td>${c.jenis_makeup}</td>
                    <td>Rp ${Number(c.harga).toLocaleString('id-ID')}</td>
                    <td>${status}</td>
                </tr>`;
            });

            html += '</tbody></table></div>';
            searchResult.innerHTML = html;

        } catch (e) {
            searchResult.innerHTML = '<p style="color:#c0392b">❌ Gagal mengambil data.</p>';
        }
    }, 400);
});
</script>
@endpush
