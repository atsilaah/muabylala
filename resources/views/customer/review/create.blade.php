@extends('layouts.app')
@section('content')
<section class="hero">
    <h2>Beri Review ⭐</h2>
    <p>Bagikan pengalaman kamu bersama MUA by Lala</p>
</section>
<section class="container">
    <main>
        <section id="Welcome">
            <h2>Form Review</h2>

            {{-- Detail Booking --}}
            <div class="total-booking-box" style="margin-bottom:24px;">
                <div class="total-label">Detail Booking</div>
                <div style="margin-top:12px;text-align:left;">
                    <table>
                        <tbody>
                            <tr><td><b>Layanan</b></td><td>{{ $booking->layanan->nama }}</td></tr>
                            <tr><td><b>MUA</b></td><td>{{ $booking->mua->user->name }}</td></tr>
                            <tr><td><b>Tanggal</b></td><td>{{ \Carbon\Carbon::parse($booking->tanggal)->format('d F Y') }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <form action="{{ route('customer.review.store', $booking->id) }}" method="POST">
                @csrf

                {{-- Star Rating --}}
                <div class="fgroup">
                    <label>Rating</label>
                    <div class="star-rating" id="star-rating">
                        <span data-val="1">★</span>
                        <span data-val="2">★</span>
                        <span data-val="3">★</span>
                        <span data-val="4">★</span>
                        <span data-val="5">★</span>
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', 5) }}">
                    @error('rating')<div class="ferr tampil">{{ $message }}</div>@enderror
                </div>

                {{-- Komentar --}}
                <div class="fgroup">
                    <label>Komentar (opsional)</label>
                    <textarea name="komentar"
                        placeholder="Ceritakan pengalaman kamu bersama MUA kami...">{{ old('komentar') }}</textarea>
                </div>

                <div class="factions">
                    <a href="{{ route('customer.booking.show', $booking->id) }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-save">⭐ Kirim Review</button>
                </div>
            </form>
        </section>
    </main>
</section>
@endsection

@push('scripts')
<script>
const stars  = document.querySelectorAll('.star-rating span');
const input  = document.getElementById('rating-input');

function setRating(val) {
    input.value = val;
    stars.forEach(s => {
        s.classList.toggle('active', +s.dataset.val <= val);
    });
}

// Set default rating 5
setRating(+input.value || 5);

stars.forEach(s => {
    s.addEventListener('click', () => setRating(+s.dataset.val));
    s.addEventListener('mouseover', () => {
        stars.forEach(x => x.classList.toggle('active', +x.dataset.val <= +s.dataset.val));
    });
    s.addEventListener('mouseout', () => setRating(+input.value));
});
</script>
@endpush
