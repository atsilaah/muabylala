@extends('layouts.app')
@section('page-title', 'Manajemen Customer')
@section('content')

<div class="dash-welcome-bar">
    <div>
        <h1 class="dash-welcome-title">Manajemen Customer 👤</h1>
        <p class="dash-welcome-sub">Kelola data customer terdaftar</p>
    </div>
</div>

<section id="Inventory">
    <h2>👤 Daftar Customer</h2>
    <div class="inv-topbar">
        <input type="text" class="inv-search" placeholder="🔍 Cari customer..." id="searchCustomer"
               oninput="filterCustomer(this.value)">
    </div>
    <div class="inv-table-wrap">
        <table id="inv-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Total Booking</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="customer-tbody">
                @forelse($customers as $c)
                <tr>
                    <td><strong>{{ $c->name }}</strong></td>
                    <td>{{ $c->email }}</td>
                    <td>{{ $c->phone ?? '-' }}</td>
                    <td>{{ $c->bookings_count ?? 0 }}x</td>
                    <td>{{ $c->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.customer.show', $c->id) }}" class="btn-edit-row">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="inv-empty">
                        <span>👤</span>Belum ada customer.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:1.25rem;">{{ $customers->links() }}</div>
</section>

@endsection

@push('scripts')
<script>
function filterCustomer(q) {
    const rows = document.querySelectorAll('#customer-tbody tr');
    q = q.toLowerCase();
    rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}
</script>
@endpush
