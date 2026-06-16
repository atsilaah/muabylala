@extends('layouts.app')
@section('page-title', 'Review')
@section('content')

<section id="Inventory">
    <h2>⭐ Daftar Review</h2>
    <div class="inv-table-wrap">
        <table id="inv-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>MUA</th>
                    <th>Layanan</th>
                    <th>Rating</th>
                    <th>Komentar</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $r)
                <tr>
                    <td>{{ $r->customer->name ?? '-' }}</td>
                    <td>{{ $r->mua->user->name ?? '-' }}</td>
                    <td>{{ $r->booking->layanan->nama ?? '-' }}</td>
                    <td>
                        <span style="color:#f1c40f;font-size:14px;">
                            @for($i=1;$i<=5;$i++)
                                {{ $i <= $r->rating ? '★' : '☆' }}
                            @endfor
                        </span>
                        <small style="color:var(--muted);margin-left:4px;">{{ $r->rating }}/5</small>
                    </td>
                    <td style="max-width:240px;">{{ $r->komentar ?? '-' }}</td>
                    <td>{{ $r->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="inv-empty">
                        <span>⭐</span>Belum ada review.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:20px;">{{ $reviews->links() }}</div>
</section>

@endsection
