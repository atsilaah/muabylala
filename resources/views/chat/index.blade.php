@extends('layouts.app')
@section('page-title', 'Chat')

@section('content')

<div class="dash-welcome-bar">
    <div>
        <h1 class="dash-welcome-title">💬 Chat</h1>
        <p class="dash-welcome-sub">Percakapan kamu</p>
    </div>
</div>

<section id="Welcome" style="padding:0;overflow:hidden;">
    <div class="chat-layout">

        <div class="chat-contacts">
            <div class="chat-contacts-header">
                <span style="font-family:'Playfair Display',serif;font-size:15px;font-weight:700;color:var(--deep)">
                    Percakapan
                </span>
            </div>

            <div class="chat-filter-tabs">
                <button class="chat-filter-tab active" onclick="filterChat('semua', this)">
                    Semua
                    @php $totalUnread = $contacts->sum('unread') @endphp
                    @if($totalUnread > 0)
                        <span class="chat-filter-badge">{{ $totalUnread }}</span>
                    @endif
                </button>

                @if(auth()->user()->role === 'admin')
                    <button class="chat-filter-tab" onclick="filterChat('customer', this)">
                        Customer
                        @php $customerUnread = $contacts->where('role','customer')->sum('unread') @endphp
                        @if($customerUnread > 0)
                            <span class="chat-filter-badge">{{ $customerUnread }}</span>
                        @endif
                    </button>
                    <button class="chat-filter-tab" onclick="filterChat('mua', this)">
                        MUA
                        @php $muaUnread = $contacts->where('role','mua')->sum('unread') @endphp
                        @if($muaUnread > 0)
                            <span class="chat-filter-badge">{{ $muaUnread }}</span>
                        @endif
                    </button>

                @elseif(auth()->user()->role === 'mua')
                    <button class="chat-filter-tab" onclick="filterChat('admin', this)">
                        Admin
                        @php $adminUnread = $contacts->where('role','admin')->sum('unread') @endphp
                        @if($adminUnread > 0)
                            <span class="chat-filter-badge">{{ $adminUnread }}</span>
                        @endif
                    </button>
                    <button class="chat-filter-tab" onclick="filterChat('customer', this)">
                        Customer
                        @php $customerUnread = $contacts->where('role','customer')->sum('unread') @endphp
                        @if($customerUnread > 0)
                            <span class="chat-filter-badge">{{ $customerUnread }}</span>
                        @endif
                    </button>

                @elseif(auth()->user()->role === 'customer')
                    <button class="chat-filter-tab" onclick="filterChat('admin', this)">
                        Admin
                        @php $adminUnread = $contacts->where('role','admin')->sum('unread') @endphp
                        @if($adminUnread > 0)
                            <span class="chat-filter-badge">{{ $adminUnread }}</span>
                        @endif
                    </button>
                    <button class="chat-filter-tab" onclick="filterChat('mua', this)">
                        MUA
                        @php $muaUnread = $contacts->where('role','mua')->sum('unread') @endphp
                        @if($muaUnread > 0)
                            <span class="chat-filter-badge">{{ $muaUnread }}</span>
                        @endif
                    </button>
                @endif
            </div>

            @forelse($contacts as $c)
            <a href="{{ route(auth()->user()->role . '.chat.index', ['with' => $c->id]) }}"
               class="chat-contact-item {{ isset($activeContact) && $activeContact->id == $c->id ? 'act' : '' }}"
               data-role="{{ $c->role }}">
                <div class="chat-contact-avatar">{{ strtoupper(substr($c->name, 0, 1)) }}</div>
                <div class="chat-contact-info">
                    <div class="chat-contact-name">{{ $c->name }}</div>
                    <div class="chat-contact-role">{{ ucfirst($c->role) }}</div>
                </div>
                @if($c->unread > 0)
                    <span class="chat-unread-badge">{{ $c->unread }}</span>
                @endif
            </a>
            @empty
            <div style="padding:24px;text-align:center;color:var(--muted);font-size:13px;">
                <div style="font-size:32px;margin-bottom:8px;">💬</div>
                Belum ada kontak
            </div>
            @endforelse

            <div id="chat-empty-filter" style="display:none;padding:24px;text-align:center;color:var(--muted);font-size:13px;">
                <div style="font-size:28px;margin-bottom:8px;">🔍</div>
                Tidak ada percakapan
            </div>
        </div>

        <div class="chat-area">
            @if($activeContact)
                <div class="chat-area-header">
                    <div class="chat-contact-avatar" style="width:36px;height:36px;font-size:14px;">
                        {{ strtoupper(substr($activeContact->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:14px;color:var(--text)">{{ $activeContact->name }}</div>
                        <div style="font-size:11px;color:var(--muted)">{{ ucfirst($activeContact->role) }}</div>
                    </div>
                </div>

                <div class="chat-messages" id="chat-messages">
                    @forelse($chats as $chat)
                    <div class="chat-bubble-wrap {{ $chat->sender_id == auth()->id() ? 'sent' : 'received' }}">
                        <div class="chat-bubble">
                            {{ $chat->pesan }}
                            <div class="chat-time">
                                {{ $chat->created_at->format('H:i') }}
                                @if($chat->sender_id == auth()->id())
                                    {{ $chat->dibaca ? ' ✓✓' : ' ✓' }}
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div style="text-align:center;color:var(--muted);font-size:13px;padding:40px 20px;">
                        <div style="font-size:40px;margin-bottom:10px;">👋</div>
                        Mulai percakapan dengan {{ $activeContact->name }}
                    </div>
                    @endforelse
                </div>

                <div class="chat-input-wrap">
                    <form action="{{ route(auth()->user()->role . '.chat.send') }}"
                          method="POST" class="chat-input-form">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $activeContact->id }}">
                        <input type="text" name="pesan" class="chat-input"
                               placeholder="Ketik pesan..." autocomplete="off"
                               required id="chat-input-field">
                        <button type="submit" class="chat-send-btn" title="Kirim">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg>
                        </button>
                    </form>
                </div>

            @else
                <div class="chat-placeholder">
                    <div style="font-size:64px;margin-bottom:16px;">💬</div>
                    <div style="font-family:'Playfair Display',serif;font-size:22px;font-weight:700;color:var(--deep);margin-bottom:8px;">
                        Mulai Percakapan
                    </div>
                    <div style="font-size:13px;color:var(--muted);">
                        Pilih kontak di sebelah kiri untuk memulai chat
                    </div>
                </div>
            @endif
        </div>

    </div>
</section>

@endsection

@push('styles')
<style>
.chat-filter-tabs {
    display: flex;
    gap: 6px;
    padding: 10px 14px 8px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    flex-wrap: wrap;
}
.chat-filter-tab {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 16px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    border: 1.5px solid var(--border, rgba(255,255,255,0.15));
    background: transparent;
    color: var(--muted);
    transition: all 0.18s ease;
    font-family: inherit;
}
.chat-filter-tab:hover {
    border-color: var(--deep);
    color: var(--deep);
}
.chat-filter-tab.active {
    background: var(--deep);
    border-color: var(--deep);
    color: #fff;
}
.chat-filter-badge {
    background: rgba(255,255,255,0.25);
    color: inherit;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 700;
    padding: 1px 6px;
    line-height: 1.4;
}
.chat-filter-tab:not(.active) .chat-filter-badge {
    background: var(--deep);
    color: #fff;
}
</style>
@endpush

@push('scripts')
<script>
const chatMessages = document.getElementById('chat-messages');
if (chatMessages) chatMessages.scrollTop = chatMessages.scrollHeight;

@if(isset($activeContact))
let refreshTimer = setTimeout(() => window.location.reload(), 5000);

const inputField = document.getElementById('chat-input-field');
if (inputField) {
    inputField.addEventListener('input', function () {
        clearTimeout(refreshTimer);
        refreshTimer = setTimeout(() => window.location.reload(), 8000);
    });
    inputField.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            this.closest('form').submit();
        }
    });
}
@endif

function filterChat(role, btn) {
    document.querySelectorAll('.chat-filter-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');

    const items = document.querySelectorAll('.chat-contact-item');
    let visibleCount = 0;

    items.forEach(item => {
        if (role === 'semua' || item.dataset.role === role) {
            item.style.display = '';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    const emptyMsg = document.getElementById('chat-empty-filter');
    if (emptyMsg) {
        emptyMsg.style.display = visibleCount === 0 ? 'block' : 'none';
    }
}
</script>
@endpush
