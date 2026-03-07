@extends('layouts.app')

@section('title', 'Mes Questions — RoukLegal')

@section('page-title')
  Mes Questions <span>/ Suivi</span>
@endsection

@section('topbar-actions')
  <a href="{{ route('client.articles') }}" class="rl-btn-outline">
    <i class="fas fa-newspaper"></i> Découvrir les articles
  </a>
@endsection

@section('content')
<div style="display:flex;flex-direction:column;gap:24px;">

  {{-- STATS RAPIDES --}}
  @php
    $total     = $questions->total();
    $repondues = $questions->getCollection()->where('statut','repondu')->count();
    $attente   = $questions->getCollection()->where('statut','en_attente')->count();
  @endphp
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
    <div class="rl-stat-card fade-up" style="--accent:var(--gold);">
      <div class="rl-stat-header"><span class="rl-stat-label">Total</span><span>❓</span></div>
      <div class="rl-stat-value">{{ $total }}</div>
      <div class="rl-stat-sub">Questions posées</div>
    </div>
    <div class="rl-stat-card fade-up" style="--accent:var(--green);animation-delay:.07s">
      <div class="rl-stat-header"><span class="rl-stat-label">Répondues</span><span>✅</span></div>
      <div class="rl-stat-value">{{ $repondues }}</div>
      <div class="rl-stat-sub">Réponses reçues</div>
    </div>
    <div class="rl-stat-card fade-up" style="--accent:var(--orange);animation-delay:.13s">
      <div class="rl-stat-header"><span class="rl-stat-label">En attente</span><span>⏳</span></div>
      <div class="rl-stat-value">{{ $attente }}</div>
      <div class="rl-stat-sub">En cours</div>
    </div>
  </div>

  {{-- LISTE --}}
  @if($questions->count() > 0)
  <div style="display:flex;flex-direction:column;gap:16px;">
    @foreach($questions as $question)
    <div class="rl-card fade-up" style="animation-delay:{{ $loop->index * 0.05 }}s;">

      {{-- En-tête --}}
      <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:16px;margin-bottom:12px;flex-wrap:wrap;">
        <div>
          <div style="font-family:'Playfair Display',serif;font-size:.95rem;font-weight:600;color:var(--ink);margin-bottom:4px;">
            {{ $question->titre }}
          </div>
          <div style="font-size:.75rem;color:var(--txt-muted);">
            <i class="fas fa-calendar" style="margin-right:4px;"></i>{{ $question->created_at->format('d/m/Y à H:i') }}
            @if($question->article)
              &nbsp;·&nbsp;
              <i class="fas fa-newspaper" style="margin-right:4px;"></i>
              <a href="{{ route('articles.show', $question->article->id) }}" style="color:var(--gold);text-decoration:none;">{{ Str::limit($question->article->title, 40) }}</a>
            @endif
          </div>
        </div>
        @php
          $statut = $question->statut ?? 'en_attente';
          $badgeClass = match($statut) { 'repondu'=>'rl-badge-green','clos'=>'rl-badge','default'=>'rl-badge-orange' };
          $badgeLabel = match($statut) { 'repondu'=>'✓ Répondu','clos'=>'Fermé',default=>'⏳ En attente' };
        @endphp
        <span class="rl-badge {{ $statut === 'repondu' ? 'rl-badge-green' : ($statut === 'clos' ? 'rl-badge' : 'rl-badge-orange') }}">
          {{ $statut === 'repondu' ? '✓ Répondu' : ($statut === 'clos' ? 'Fermé' : '⏳ En attente') }}
        </span>
      </div>

      {{-- Contenu question --}}
      @if($question->contenu)
      <div style="font-size:.85rem;color:var(--txt-muted);line-height:1.6;margin-bottom:14px;padding:12px 14px;background:var(--surface2);border-radius:8px;border-left:3px solid var(--border);">
        {{ $question->contenu }}
      </div>
      @endif

      {{-- Réponse --}}
      @if($question->reponses->count() > 0)
        @if(Auth::user()->canAccessResponses())
        <div style="padding:14px 16px;background:var(--green-dim);border-radius:10px;border-left:3px solid var(--green);">
          <div style="font-size:.75rem;font-weight:600;color:var(--green);margin-bottom:8px;">
            <i class="fas fa-check-circle" style="margin-right:4px;"></i>Réponse de {{ $question->reponses->first()->acteur->nom ?? 'Expert' }}
          </div>
          <div style="font-size:.87rem;color:var(--txt);line-height:1.7;">
            {{ $question->reponses->first()->contenu }}
          </div>
          <div style="font-size:.7rem;color:var(--txt-muted);margin-top:8px;">
            {{ $question->reponses->first()->created_at->format('d/m/Y à H:i') }}
          </div>
        </div>
        @else
        <div style="padding:14px 16px;background:var(--orange-dim);border-radius:10px;border:1px solid rgba(230,126,34,.25);display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;">
          <div style="font-size:.85rem;color:var(--orange);">
            <i class="fas fa-lock" style="margin-right:6px;"></i>Une réponse vous attend — abonnement requis
          </div>
          <button class="rl-btn" style="padding:6px 14px;font-size:.78rem;" onclick="openSubscriptionModal()">
            Débloquer
          </button>
        </div>
        @endif
      @else
        <div style="display:flex;align-items:center;gap:8px;font-size:.82rem;color:var(--txt-muted);padding:10px 14px;background:var(--surface2);border-radius:8px;">
          <i class="fas fa-clock" style="color:var(--orange);"></i> En attente de réponse d'un expert
        </div>
      @endif

    </div>
    @endforeach
  </div>

  <div style="display:flex;justify-content:center;">{{ $questions->links() }}</div>

  @else
  <div class="rl-card" style="text-align:center;padding:48px 32px;">
    <div style="font-size:3rem;margin-bottom:16px;">💬</div>
    <div style="font-family:'Playfair Display',serif;font-size:1.2rem;color:var(--ink);margin-bottom:8px;">Aucune question posée</div>
    <div style="font-size:.88rem;color:var(--txt-muted);margin-bottom:24px;">Lisez des articles et posez vos questions aux experts juridiques.</div>
    <a href="{{ route('client.articles') }}" class="rl-btn"><i class="fas fa-newspaper"></i> Découvrir les articles</a>
  </div>
  @endif

</div>

{{-- MODAL ABONNEMENT --}}
<div id="subscriptionModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999;align-items:center;justify-content:center;">
  <div style="background:var(--surface);border-radius:var(--radius);padding:32px;width:100%;max-width:460px;margin:24px;animation:fadeUp .25s ease;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
      <div style="font-family:'Playfair Display',serif;font-size:1.1rem;color:var(--ink);">Accéder aux réponses</div>
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
    method:'POST',
    headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'}
  }).then(r=>r.json()).then(d => {
    if(d.success){ closeSubscriptionModal(); location.reload(); }
    else alert(d.message);
  });
}
</script>
@endsection