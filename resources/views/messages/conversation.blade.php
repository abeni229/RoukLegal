@extends('layouts.app')

@section('title', 'Conversation avec ' . $user->nom . ' — RoukLegal')

@section('page-title')
  Messagerie <span>/ {{ $user->nom }}</span>
@endsection

@section('topbar-actions')
  <a href="{{ route('messages.index') }}" class="rl-btn-outline">
    <i class="fas fa-arrow-left"></i> Conversations
  </a>
@endsection

@section('content')
@php
  $avatar = $user->photo_professionnelle
    ? asset('storage/'.$user->photo_professionnelle)
    : ($user->profile_photo ? asset('storage/'.$user->profile_photo) : null);
  $meAvatar = Auth::user()->profile_photo
    ? asset('storage/'.Auth::user()->profile_photo)
    : (Auth::user()->photo_professionnelle ? asset('storage/'.Auth::user()->photo_professionnelle) : null);
  $role = $user->role === 'acteur_juridique' ? ($user->profession?->nom ?? 'Professionnel juridique') : 'Client';
@endphp

<div style="max-width:820px;display:flex;flex-direction:column;gap:0;">

  {{-- EN-TÊTE CONVERSATION --}}
  <div style="display:flex;align-items:center;gap:16px;padding:16px 20px;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius) var(--radius) 0 0;border-bottom:none;">
    <div style="width:46px;height:46px;border-radius:50%;background:var(--gold-dim);border:2px solid var(--gold);display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;">
      @if($avatar)
        <img src="{{ $avatar }}" style="width:100%;height:100%;object-fit:cover;"/>
      @else
        <span style="font-family:'Playfair Display',serif;font-size:.95rem;font-weight:700;color:var(--gold);">{{ strtoupper(substr($user->nom,0,2)) }}</span>
      @endif
    </div>
    <div>
      <div style="font-family:'Playfair Display',serif;font-size:.95rem;font-weight:600;color:var(--ink);">{{ $user->nom }}</div>
      <div style="font-size:.72rem;color:var(--txt-muted);">{{ $role }}</div>
    </div>
    <div style="margin-left:auto;">
      <div style="width:8px;height:8px;border-radius:50%;background:var(--green);display:inline-block;margin-right:5px;"></div>
      <span style="font-size:.72rem;color:var(--txt-muted);">En ligne</span>
    </div>
  </div>

  {{-- ZONE MESSAGES --}}
  <div id="messagesContainer"
       style="min-height:400px;max-height:58vh;overflow-y:auto;background:var(--surface2);border:1px solid var(--border);border-top:1px solid var(--border);padding:20px;display:flex;flex-direction:column;gap:12px;">

    @forelse($messages as $msg)
    @php $isMe = $msg->sender_id === Auth::id(); @endphp

    <div style="display:flex;align-items:flex-end;gap:10px;{{ $isMe ? 'flex-direction:row-reverse;' : '' }}">

      {{-- Avatar --}}
      <div style="width:32px;height:32px;border-radius:50%;background:var(--gold-dim);border:1px solid var(--gold);display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;">
        @if($isMe)
          @if($meAvatar)
            <img src="{{ $meAvatar }}" style="width:100%;height:100%;object-fit:cover;"/>
          @else
            <span style="font-size:.65rem;font-weight:700;color:var(--gold);">{{ strtoupper(substr(Auth::user()->nom,0,2)) }}</span>
          @endif
        @else
          @if($avatar)
            <img src="{{ $avatar }}" style="width:100%;height:100%;object-fit:cover;"/>
          @else
            <span style="font-size:.65rem;font-weight:700;color:var(--gold);">{{ strtoupper(substr($user->nom,0,2)) }}</span>
          @endif
        @endif
      </div>

      {{-- Bulle --}}
      <div style="max-width:65%;padding:10px 14px;border-radius:{{ $isMe ? '16px 4px 16px 16px' : '4px 16px 16px 16px' }};font-size:.88rem;line-height:1.6;word-wrap:break-word;
        {{ $isMe
          ? 'background:var(--gold);color:#111820;'
          : 'background:var(--surface);border:1px solid var(--border);color:var(--txt);' }}">
        {{ $msg->message }}
        <div style="font-size:.65rem;opacity:.6;margin-top:5px;text-align:{{ $isMe ? 'left' : 'right' }};">
          {{ $msg->created_at->format('H:i') }}
        </div>
      </div>

    </div>

    @empty
    <div style="flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px 0;color:var(--txt-muted);">
      <div style="font-size:2.5rem;margin-bottom:12px;">💬</div>
      <div style="font-size:.88rem;">Démarrez la conversation avec {{ $user->nom }}</div>
    </div>
    @endforelse
  </div>

  {{-- FORMULAIRE ENVOI --}}
  <form method="POST" action="{{ route('messages.send', ['user'=>$user->id]) }}"
        style="display:flex;gap:0;border:1px solid var(--border);border-top:none;border-radius:0 0 var(--radius) var(--radius);overflow:hidden;background:var(--surface);">
    @csrf
    <textarea name="message" id="msgInput" rows="1"
              style="flex:1;padding:14px 18px;background:transparent;border:none;outline:none;resize:none;font-family:'DM Sans',sans-serif;font-size:.9rem;color:var(--txt);line-height:1.5;max-height:120px;"
              placeholder="Écrire un message…"
              onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();this.closest('form').submit();}"></textarea>
    <button type="submit"
            style="padding:14px 22px;background:var(--gold);border:none;cursor:pointer;color:#111820;font-size:1rem;transition:background .15s;flex-shrink:0;"
            onmouseover="this.style.background='var(--gold-lt)'"
            onmouseout="this.style.background='var(--gold)'">
      <i class="fas fa-paper-plane"></i>
    </button>
  </form>
  @error('message')
  <div style="font-size:.75rem;color:var(--red);margin-top:6px;">{{ $message }}</div>
  @enderror

</div>
@endsection

@section('scripts')
<script>
  // Auto-scroll bas
  const mc = document.getElementById('messagesContainer');
  if(mc) mc.scrollTop = mc.scrollHeight;

  // Auto-resize textarea
  const ta = document.getElementById('msgInput');
  ta?.addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
  });
</script>
@endsection