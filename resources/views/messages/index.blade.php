@extends('layouts.app')

@section('title', 'Messagerie — RoukLegal')

@section('page-title')
  Messagerie <span>/ Conversations</span>
@endsection

@section('content')
<div style="max-width:700px;">

  {{-- RECHERCHE --}}
  <div style="position:relative;margin-bottom:20px;">
    <i class="fas fa-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--txt-muted);font-size:.85rem;"></i>
    <input type="text" id="searchConv" class="rl-input" placeholder="Rechercher une conversation…" style="padding-left:38px;">
  </div>

  {{-- LISTE --}}
  @forelse($users as $u)
  @php
    $role = $u->role === 'acteur_juridique' ? 'Professionnel juridique' : 'Client';
    $initials = strtoupper(substr($u->nom, 0, 2));
    $avatar = $u->photo_professionnelle
      ? asset('storage/'.$u->photo_professionnelle)
      : ($u->profile_photo ? asset('storage/'.$u->profile_photo) : null);
  @endphp
  <a href="{{ route('messages.conversation', ['user'=>$u->id]) }}"
     class="conv-item fade-up"
     style="display:flex;align-items:center;gap:16px;padding:16px 20px;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);margin-bottom:10px;text-decoration:none;transition:border-color .15s,background .15s;animation-delay:{{ $loop->index * 0.05 }}s;"
     onmouseover="this.style.borderColor='var(--gold)';this.style.background='var(--surface2)'"
     onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--surface)'">

    {{-- Avatar --}}
    <div style="width:50px;height:50px;border-radius:50%;background:var(--gold-dim);border:2px solid var(--gold);display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;">
      @if($avatar)
        <img src="{{ $avatar }}" style="width:100%;height:100%;object-fit:cover;"/>
      @else
        <span style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:var(--gold);">{{ $initials }}</span>
      @endif
    </div>

    {{-- Infos --}}
    <div style="flex:1;min-width:0;" class="conv-name-wrap">
      <div style="font-weight:600;color:var(--ink);font-size:.92rem;margin-bottom:3px;" class="conv-name">{{ $u->nom }}</div>
      <div style="font-size:.75rem;color:var(--txt-muted);">{{ $role }}</div>
    </div>

    <i class="fas fa-chevron-right" style="color:var(--gold);font-size:.8rem;flex-shrink:0;"></i>
  </a>

  @empty
  <div class="rl-card" style="text-align:center;padding:48px 32px;">
    <div style="font-size:3rem;margin-bottom:16px;">💬</div>
    <div style="font-family:'Playfair Display',serif;font-size:1.1rem;color:var(--ink);margin-bottom:8px;">Aucune conversation</div>
    <div style="font-size:.85rem;color:var(--txt-muted);">Contactez un acteur depuis un article ou un profil.</div>
  </div>
  @endforelse

</div>
@endsection

@section('scripts')
<script>
document.getElementById('searchConv')?.addEventListener('keyup', function() {
  const q = this.value.toLowerCase();
  document.querySelectorAll('.conv-item').forEach(item => {
    const name = item.querySelector('.conv-name')?.textContent.toLowerCase() ?? '';
    item.style.display = name.includes(q) ? '' : 'none';
  });
});
</script>
@endsection