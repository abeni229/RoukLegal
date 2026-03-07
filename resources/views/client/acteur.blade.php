@extends('layouts.app')

@section('title', 'Profil de ' . $acteur->nom . ' — RoukLegal')

@section('page-title')
  Acteurs <span>/ Profil</span>
@endsection

@section('topbar-actions')
  <a href="{{ route('client.acteurs') }}" class="rl-btn-outline">
    <i class="fas fa-arrow-left"></i> Retour à l'annuaire
  </a>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:1fr 300px;gap:28px;align-items:start;">

  {{-- COLONNE PRINCIPALE --}}
  <div style="display:flex;flex-direction:column;gap:24px;">

    {{-- En-tête profil --}}
    <div class="rl-card fade-up" style="background:linear-gradient(135deg,#111820,#1a2535);border-color:rgba(201,168,76,.2);">
      <div style="display:flex;align-items:center;gap:24px;flex-wrap:wrap;">
        <div style="width:90px;height:90px;border-radius:50%;background:var(--gold-dim);border:3px solid var(--gold);display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;">
          @if($acteur->photo_professionnelle)
            <img src="{{ asset('storage/'.$acteur->photo_professionnelle) }}" style="width:100%;height:100%;object-fit:cover;"/>
          @else
            <span style="font-family:'Playfair Display',serif;font-size:2rem;font-weight:700;color:var(--gold);">{{ strtoupper(substr($acteur->nom,0,2)) }}</span>
          @endif
        </div>
        <div>
          <div style="font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:700;color:white;margin-bottom:6px;">{{ $acteur->nom }}</div>
          <span class="rl-badge rl-badge-gold" style="font-size:.8rem;">
            ⚖️ {{ $acteur->profession?->nom ?? $acteur->profession_libre ?? 'Expert juridique' }}
          </span>
          <div style="display:flex;gap:16px;margin-top:12px;font-size:.78rem;color:rgba(255,255,255,.5);">
            <span><i class="fas fa-newspaper" style="margin-right:4px;color:var(--gold);"></i>{{ $acteur->articles->count() }} article(s)</span>
          </div>
        </div>
      </div>
    </div>

    {{-- Description --}}
    <div class="rl-card fade-up" style="animation-delay:.1s;">
      <div class="rl-card-header">
        <span class="rl-card-title">Description professionnelle</span>
      </div>
      <div style="font-size:.9rem;color:var(--txt);line-height:1.8;">
        {{ $acteur->description ?? 'Cet acteur n\'a pas encore renseigné sa description.' }}
      </div>
    </div>

    {{-- Articles --}}
    <div class="rl-card fade-up" style="animation-delay:.15s;">
      <div class="rl-card-header">
        <span class="rl-card-title">Articles publiés</span>
        <span class="rl-badge rl-badge-gold">{{ $acteur->articles->count() }}</span>
      </div>
      @if($acteur->articles->count() > 0)
      <div style="display:flex;flex-direction:column;gap:12px;">
        @foreach($acteur->articles as $article)
        <a href="{{ route('articles.show', $article->id) }}" style="display:flex;align-items:center;gap:14px;padding:14px 16px;background:var(--surface2);border-radius:10px;border:1px solid var(--border);text-decoration:none;transition:border-color .15s,background .15s;" onmouseover="this.style.borderColor='var(--gold)';this.style.background='#fffdf5'" onmouseout="this.style.borderColor='var(--border)';this.style.background='var(--surface2)'">
          <div style="width:36px;height:36px;border-radius:8px;background:var(--gold-dim);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.9rem;">📰</div>
          <div style="flex:1;min-width:0;">
            <div style="font-size:.88rem;font-weight:500;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $article->title }}</div>
            <div style="font-size:.72rem;color:var(--txt-muted);margin-top:3px;">
              <i class="fas fa-eye" style="margin-right:4px;"></i>{{ $article->views }} vue(s) •
              {{ $article->created_at->format('d/m/Y') }}
            </div>
          </div>
          <span style="color:var(--gold);font-size:.9rem;">›</span>
        </a>
        @endforeach
      </div>
      @else
      <div style="text-align:center;padding:24px;color:var(--txt-muted);font-size:.88rem;">
        <div style="font-size:2rem;margin-bottom:8px;">📝</div>
        Aucun article publié pour le moment.
      </div>
      @endif
    </div>

  </div>

  {{-- COLONNE DROITE --}}
  <div style="display:flex;flex-direction:column;gap:20px;position:sticky;top:calc(var(--topbar-h) + 24px);">

    {{-- Actions --}}
    <div class="rl-card fade-up" style="animation-delay:.05s;">
      <div class="rl-card-header"><span class="rl-card-title">Contacter</span></div>
      @if(Auth::user()->canAccessResponses())
        <a href="{{ route('messages.conversation', ['user'=>$acteur->id]) }}" class="rl-btn" style="width:100%;justify-content:center;margin-bottom:10px;">
          <i class="fas fa-comments"></i> Envoyer un message
        </a>
        <div style="font-size:.75rem;color:var(--txt-muted);text-align:center;">
          <i class="fas fa-shield-alt" style="color:var(--green);margin-right:4px;"></i>Messagerie sécurisée
        </div>
      @else
        <div style="padding:16px;background:var(--orange-dim);border-radius:10px;border:1px solid rgba(230,126,34,.25);text-align:center;margin-bottom:10px;">
          <div style="font-size:1.4rem;margin-bottom:6px;">🔒</div>
          <div style="font-size:.83rem;font-weight:600;color:var(--orange);margin-bottom:4px;">Abonnement requis</div>
          <div style="font-size:.75rem;color:var(--txt-muted);margin-bottom:12px;">Souscrivez pour contacter les acteurs.</div>
          <button class="rl-btn" style="width:100%;justify-content:center;" onclick="openSubscriptionModal()">
            <i class="fas fa-credit-card"></i> Accéder au service
          </button>
        </div>
      @endif
    </div>

    {{-- Notation globale --}}
    <div class="rl-card fade-up" style="animation-delay:.1s;">
      <div class="rl-card-header"><span class="rl-card-title">Évaluations</span></div>
      <div style="text-align:center;padding:8px 0;">
        <div style="font-size:2rem;color:var(--gold);letter-spacing:4px;">★★★★★</div>
        <div style="font-family:'Playfair Display',serif;font-size:1.3rem;font-weight:700;color:var(--ink);margin:6px 0;">4.8 / 5</div>
        <div style="font-size:.75rem;color:var(--txt-muted);">Basé sur les évaluations clients</div>
      </div>
    </div>

  </div>

</div>

{{-- MODAL ABONNEMENT --}}
<div id="subscriptionModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999;align-items:center;justify-content:center;">
  <div style="background:var(--surface);border-radius:var(--radius);padding:32px;width:100%;max-width:460px;margin:24px;animation:fadeUp .25s ease;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
      <div style="font-family:'Playfair Display',serif;font-size:1.1rem;color:var(--ink);">Accéder au service</div>
      <button onclick="closeSubscriptionModal()" style="background:none;border:none;font-size:1.2rem;cursor:pointer;color:var(--txt-muted);">✕</button>
    </div>
    <div style="display:flex;flex-direction:column;gap:14px;">
      <div style="padding:18px;background:var(--green-dim);border-radius:10px;border:1px solid rgba(39,174,96,.25);text-align:center;">
        <div style="font-size:1.5rem;margin-bottom:6px;">🎁</div>
        <div style="font-family:'Playfair Display',serif;font-size:1rem;color:var(--green);margin-bottom:4px;">Essai gratuit — 2 semaines</div>
        <div style="font-size:.78rem;color:var(--txt-muted);margin-bottom:12px;">Accès complet, sans engagement</div>
        <button class="rl-btn" style="background:var(--green);width:100%;justify-content:center;" onclick="startTrial()">
          <i class="fas fa-play"></i> Commencer l'essai
        </button>
      </div>
      <div style="padding:18px;background:var(--gold-dim);border-radius:10px;border:1px solid rgba(201,168,76,.25);text-align:center;">
        <div style="font-size:1.5rem;margin-bottom:6px;">⭐</div>
        <div style="font-family:'Playfair Display',serif;font-size:1rem;color:var(--gold);margin-bottom:4px;">Abonnement mensuel</div>
        <div style="font-size:.78rem;color:var(--txt-muted);margin-bottom:12px;">Accès illimité à toutes les fonctionnalités</div>
        <button class="rl-btn" style="width:100%;justify-content:center;" onclick="alert('Paiement à implémenter')">
          <i class="fas fa-credit-card"></i> Souscrire
        </button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
function openSubscriptionModal() {
  document.getElementById('subscriptionModal').style.display = 'flex';
  document.body.style.overflow = 'hidden';
}
function closeSubscriptionModal() {
  document.getElementById('subscriptionModal').style.display = 'none';
  document.body.style.overflow = '';
}
document.getElementById('subscriptionModal')?.addEventListener('click', e => {
  if(e.target===e.currentTarget) closeSubscriptionModal();
});
function startTrial() {
  fetch('{{ route("client.startTrial") }}', {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
  }).then(r=>r.json()).then(d => {
    if(d.success) { closeSubscriptionModal(); location.reload(); }
    else alert(d.message);
  });
}
</script>
@endsection