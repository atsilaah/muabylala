@extends('layouts.app')

@section('content')
<section class="hero">
    <h2>Create Account ✨</h2>
    <p>Register to start managing customers</p>
</section>
<section class="container">
    <main>
        <section id="Welcome">
            <h2>Register</h2>

            @if ($errors->any())
                <div style="color:red; margin-bottom:10px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="frow">
                    <div class="fgroup">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Your name" class="{{ $errors->has('name') ? 'err-field' : '' }}" required autofocus>
                        @error('name')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" class="{{ $errors->has('email') ? 'err-field' : '' }}" required>
                        @error('email')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="frow">
                    <div class="fgroup">
                        <label>Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" class="{{ $errors->has('phone') ? 'err-field' : '' }}" required>
                        @error('phone')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="frow">
                    <div class="fgroup">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="••••••••" class="{{ $errors->has('password') ? 'err-field' : '' }}" required>
                        @error('password')<div class="ferr tampil">{{ $message }}</div>@enderror
                    </div>
                    <div class="fgroup">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••" required>
                    </div>
                </div>
                <div class="factions">
                    <a href="{{ route('login') }}" class="btn-cancel">Already have account?</a>
                    <button type="submit" class="btn-save">📝 Register</button>
                </div>
            </form>
        </section>
    </main>
</section>
@endsection
