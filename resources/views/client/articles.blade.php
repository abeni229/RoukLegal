@extends('layouts.app')

@section('title', 'Articles Juridiques — RoukLegal')

@section('page-title')
  Articles <span>/ Conseils Juridiques</span>
@endsection

@section('content')
<div style="display:flex;flex-direction:column;gap:24px;">

  {{-- RECHERCHE --}}
  <div class="rl-card fade-up" style="padding:20px 24px;">
    <div style="display:grid;grid-template-columns:1fr 220px;gap:12px;">
      <div style="position:relative;">
        <i class="fas fa-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--txt-muted);font-size:.85rem;"></i>
        <input type="text" id="searchInput" class="rl-input" placeholder="Rechercher un article…" style="padding-left:38px;">
      </div>
      <select id="domainFilter" class="rl-select">
        <option value="">Tous les domaines</option>
        <option value="travail">Droit du travail</option>
        <option value="famille">Droit de la famille</option>
        <option value="immobilier">Immobilier</option>
        <option value="entreprise">Droit de l'entreprise</option>
      </select>
    </div>
  </div>

  {{-- ARTICLES --}}
  @if($articles->count() > 0)
  <div id="articlesList" style="display:flex;flex-direction:column;gap:16px;">
    @foreach($articles as $article)
    <div class="rl-card article-card fade-up" style="animation-delay:{{ $loop->index * 0.05 }}s;transition:transform .2s,box-shadow .2s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 32px rgba(0,0,0,.1)'" onmouseout="this.style.transform='none';this.style.boxShadow='var(--shadow)'">
      <div style="display:flex;gap:20px;align-items:flex-start;">

        {{-- Avatar auteur --}}
        <div style="width:52px;height:52px;border-radius:50%;background:var(--gold-dim);border:2px solid var(--gold);display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;">
          @if($article->user->photo_professionnelle)
            <img src="{{ asset('storage/'.$article->user->photo_professionnelle) }}" style="width:100%;height:100%;object-fit:cover;"/>
          @else
            <span style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:var(--gold);">{{ strtoupper(substr($article->user->nom,0,2)) }}</span>
          @endif
        </div>

        {{-- Contenu --}}
        <div style="flex:1;min-width:0;">
          <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;flex-wrap:wrap;">
            <span class="rl-badge rl-badge-gold">{{ $article->user->profession?->nom ?? 'Expert' }}</span>
            <span style="font-size:.72rem;color:var(--txt-muted);">{{ $article->created_at->format('d M Y') }}</span>
          </div>
          <div style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:500;color:var(--ink);margin-bottom:8px;" class="article-title">
            {{ $article->title }}
          </div>
          <div style="font-size:.85rem;color:var(--txt-muted);line-height:1.6;margin-bottom:12px;" class="article-excerpt">
            {{ Str::limit(strip_tags($article->content), 140) }}
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
            <div style="display:flex;gap:14px;font-size:.75rem;color:var(--txt-muted);">
              <span><i class="fas fa-eye" style="margin-right:3px;"></i>{{ $article->views }}</span>
              <span><i class="fas fa-comments" style="margin-right:3px;"></i>{{ $article->questions()->count() }} question(s)</span>
              <span style="color:var(--txt);font-weight:500;">Par <strong>{{ $article->user->nom }}</strong></span>
            </div>
            <div style="display:flex;gap:8px;">
              @if(Auth::user()->canViewArticleFromAuthor($article->user_id))
                <a href="{{ route('articles.show', $article->id) }}" class="rl-btn" style="padding:7px 14px;font-size:.8rem;">
                  <i class="fas fa-book-open"></i> Lire
                </a>
                @if(Auth::user()->canAskQuestions())
                <a href="{{ route('articles.show', $article->id) }}#questions" class="rl-btn-outline" style="padding:7px 14px;font-size:.8rem;">
                  <i class="fas fa-question-circle"></i> Question
                </a>
                @endif
              @else
                <button class="rl-btn-outline" style="padding:7px 14px;font-size:.8rem;" onclick="openSubscriptionModal()">
                  <i class="fas fa-lock"></i> Accès limité
                </button>
              @endif
            </div>
          </div>
        </div>

      </div>
    </div>
    @endforeach
  </div>

  <div style="display:flex;justify-content:center;">{{ $articles->links() }}</div>

  @else
  <div class="rl-card" style="text-align:center;padding:48px 32px;">
    <div style="font-size:3rem;margin-bottom:16px;">📰</div>
    <div style="font-family:'Playfair Display',serif;font-size:1.2rem;color:var(--ink);margin-bottom:8px;">Aucun article disponible</div>
    <div style="font-size:.88rem;color:var(--txt-muted);margin-bottom:20px;">Les professionnels publient régulièrement des articles utiles.</div>
    <a href="{{ route('client.dashboard') }}" class="rl-btn"><i class="fas fa-arrow-left"></i> Retour au dashboard</a>
  </div>
  @endif

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
document.getElementById('searchInput')?.addEventListener('keyup', function() {
  const q = this.value.toLowerCase();
  document.querySelectorAll('.article-card').forEach(card => {
    const t = card.querySelector('.article-title')?.textContent.toLowerCase() ?? '';
    const e = card.querySelector('.article-excerpt')?.textContent.toLowerCase() ?? '';
    card.style.display = (t.includes(q) || e.includes(q)) ? '' : 'none';
  });
});
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