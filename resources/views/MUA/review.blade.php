@extends('layouts.app')
@section('content')
<section class="hero">
    <h2>Review Customer ⭐</h2>
    <p>Review yang diberikan customer untuk kamu</p>
</section>
<section class="container">
    <main>
        <section id="Inventory">
            <h2>⭐ Daftar Review</h2>
            <div class="inv-table-wrap">
                <table id="inv-table">
                    <thead>
                        <tr>
                            <th>Customer</th><th>Layanan</th><th>Rating</th>
                            <th>Komentar</th><th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $r)
                        <tr>
                            <td>{{ $r->customer->name }}</td>
                            <td>{{ $r->booking->layanan->nama ?? '-' }}</td>
                            <td>
                                @for($i=1;$i<=5;$i++)
                                    {{ $i <= $r->rating ? '⭐' : '☆' }}
                                @endfor
                            </td>
                            <td>{{ $r->komentar ?? '-' }}</td>
                            <td>{{ $r->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="inv-empty">
                                <span>⭐</span>Belum ada review.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="margin-top:20px;">{{ $reviews->links() }}</div>
        </section>
    </main>
</section>
@endsection
