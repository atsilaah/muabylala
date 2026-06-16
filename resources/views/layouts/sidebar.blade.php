<aside class="sidebar" id="sidebar">
    <div class="sb-user">
        <div class="sb-avatar" style="padding:0;overflow:hidden;flex-shrink:0;">
            @if(auth()->user()->photo)
                <img src="{{ asset('storage/' . auth()->user()->photo) }}"
                     style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
            @else
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            @endif
        </div>
        <div class="sb-user-info">
            <div class="sb-username">{{ auth()->user()->name }}</div>
            <div class="sb-role">{{ ucfirst(auth()->user()->role) }}</div>
        </div>
    </div>

    <nav class="sb-nav">
        <div class="sb-section">Akun</div>
        <a href="{{ route(auth()->user()->role . '.profil') }}"
           class="sb-link {{ request()->routeIs(auth()->user()->role . '.profil') ? 'act' : '' }}">
            <span class="sb-link-icon">👤</span>
            <span class="sb-label">Profile</span>
        </a>
        <a href="{{ route(auth()->user()->role . '.preferensi') }}"
           class="sb-link {{ request()->routeIs(auth()->user()->role . '.preferensi') ? 'act' : '' }}">
            <span class="sb-link-icon">⚙️</span>
            <span class="sb-label">Settings</span>
        </a>

        <div class="sb-section">Pesan</div>
        <a href="{{ route(auth()->user()->role . '.chat.index') }}"
           class="sb-link {{ request()->routeIs(auth()->user()->role . '.chat.*') ? 'act' : '' }}">
            <span class="sb-link-icon">💬</span>
            <span class="sb-label">Chat</span>
            @php
                $unreadTotal = \App\Models\Chat::where('receiver_id', auth()->id())
                    ->where('dibaca', false)->count();
            @endphp
            @if($unreadTotal > 0)
                <span class="sb-badge">{{ $unreadTotal }}</span>
            @endif
        </a>
    </nav>

    <div class="sb-logout">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sb-logout-btn">
                <span class="sb-link-icon">🚪</span>
                <span class="sb-label">Logout</span>
            </button>
        </form>
    </div>
</aside>
