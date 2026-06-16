@extends('layouts.app')

@section('content')
<section class="hero">
    <h2>Makeup Artist by Lala</h2>
    <p>Login to manage your customers</p>
</section>
<section class="container">
    <main>
        <section id="Welcome">
            <h2>Login</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="frow">
                    <div class="fgroup">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" class="{{ $errors->has('email') ? 'err-field' : '' }}" required autofocus>
                        @error('email')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="••••••••" class="{{ $errors->has('password') ? 'err-field' : '' }}" required>
                        @error('password')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="factions">
                    <a href="{{ route('register') }}" class="btn-cancel">Register</a>
                    <button type="submit" class="btn-save">🔐 Login</button>
                </div>
            </form>
        </section>
    </main>
</section>
@endsection
