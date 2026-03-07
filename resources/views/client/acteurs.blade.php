@extends('layouts.app')

@section('title', 'Acteurs Juridiques — RoukLegal')

@section('page-title')
  Annuaire <span>/ Acteurs Juridiques</span>
@endsection

@section('content')
<div style="display:flex;flex-direction:column;gap:24px;">

  {{-- RECHERCHE --}}
  <div class="rl-card fade-up" style="padding:20px 24px;">
    <div style="display:grid;grid-template-columns:1fr 220px;gap:12px;">
      <div style="position:relative;">
        <i class="fas fa-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--txt-muted);font-size:.85rem;"></i>
        <input type="text" id="searchInput" class="rl-input" placeholder="Rechercher un acteur…" style="padding-left:38px;">
      </div>
      <select id="professionFilter" class="rl-select">
        <option value="">Toutes les professions</option>
        <option value="avocat">Avocat</option>
        <option value="notaire">Notaire</option>
        <option value="huissier">Huissier</option>
        <option value="conseil">Conseil juridique</option>
      </select>
    </div>
  </div>

  {{-- LISTE --}}
  @if($acteurs->count() > 0)
  <div id="acteursList" style="display:flex;flex-direction:column;gap:16px;">
    @foreach($acteurs as $acteur)
    <div class="rl-card acteur-card fade-up" style="animation-delay:{{ $loop->index * 0.05 }}s;transition:transform .2s,box-shadow .2s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 32px rgba(0,0,0,.1)'" onmouseout="this.style.transform='none';this.style.boxShadow='var(--shadow)'">
      <div style="display:flex;gap:20px;align-items:flex-start;">

        {{-- Avatar --}}
        <div style="width:70px;height:70px;border-radius:50%;background:var(--gold-dim);border:2px solid var(--gold);display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;">
          @if($acteur->photo_professionnelle)
            <img src="{{ asset('storage/'.$acteur->photo_professionnelle) }}" style="width:100%;height:100%;object-fit:cover;"/>
          @else
            <span style="font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;color:var(--gold);">{{ strtoupper(substr($acteur->nom,0,2)) }}</span>
          @endif
        </div>

        {{-- Infos --}}
        <div style="flex:1;min-width:0;">
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;flex-wrap:wrap;">
            <a href="{{ route('client.acteur.show', ['user' => $acteur->id]) }}" style="font-family:'Playfair Display',serif;font-size:1.05rem;font-weight:600;color:var(--ink);text-decoration:none;" class="acteur-name">
              {{ $acteur->nom }}
            </a>
            <span class="rl-badge rl-badge-gold">{{ $acteur->profession?->nom ?? $acteur->profession_libre ?? 'Expert juridique' }}</span>
          </div>
          <div style="font-size:.85rem;color:var(--txt-muted);line-height:1.6;margin-bottom:12px;" class="acteur-desc">
            {{ Str::limit($acteur->description ?? 'Aucune description fournie.', 160) }}
          </div>
          <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
            <span style="font-size:.75rem;color:var(--txt-muted);">
              <i class="fas fa-newspaper" style="margin-right:4px;color:var(--gold);"></i>{{ $acteur->articles->count() }} article(s)
            </span>
            <a href="{{ route('client.acteur.show', ['user'=>$acteur->id]) }}" class="rl-btn-outline" style="padding:6px 14px;font-size:.8rem;">
              Voir le profil
            </a>
            @if(Auth::user()->canAccessResponses())
              <a href="{{ route('messages.conversation', ['user'=>$acteur->id]) }}" class="rl-btn" style="padding:6px 14px;font-size:.8rem;">
                <i class="fas fa-comments"></i> Contacter
              </a>
            @else
              <span style="font-size:.75rem;color:var(--orange);"><i class="fas fa-lock" style="margin-right:4px;"></i>Abonnement requis</span>
            @endif
          </div>
        </div>

      </div>
    </div>
    @endforeach
  </div>

  <div style="display:flex;justify-content:center;">{{ $acteurs->links() }}</div>

  @else
  <div class="rl-card" style="text-align:center;padding:48px 32px;">
    <div style="font-size:3rem;margin-bottom:16px;">⚖️</div>
    <div style="font-family:'Playfair Display',serif;font-size:1.2rem;color:var(--ink);margin-bottom:8px;">Aucun acteur disponible</div>
    <div style="font-size:.88rem;color:var(--txt-muted);">Les professionnels seront bientôt disponibles.</div>
  </div>
  @endif

</div>
@endsection

@section('scripts')
<script>
document.getElementById('searchInput')?.addEventListener('keyup', function() {
  const q = this.value.toLowerCase();
  document.querySelectorAll('.acteur-card').forEach(card => {
    const name = card.querySelector('.acteur-name')?.textContent.toLowerCase() ?? '';
    const desc = card.querySelector('.acteur-desc')?.textContent.toLowerCase() ?? '';
    card.style.display = (name.includes(q) || desc.includes(q)) ? '' : 'none';
  });
});
</script>
@endsection