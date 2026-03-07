@extends('layouts.app')

@section('title', 'Articles Juridiques — RoukLegal')

@section('page-title')
  Articles <span>/ Juridiques</span>
@endsection

@section('content')
<div style="display:flex;flex-direction:column;gap:24px;">

  {{-- RECHERCHE --}}
  <div class="rl-card fade-up" style="padding:20px 24px;">
    <div style="display:grid;grid-template-columns:1fr 240px;gap:12px;">
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
        <option value="fiscal">Droit fiscal</option>
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
        <div style="width:50px;height:50px;border-radius:50%;background:var(--gold-dim);border:2px solid var(--gold);display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;">
          @if($article->user->photo_professionnelle)
            <img src="{{ asset('storage/'.$article->user->photo_professionnelle) }}" style="width:100%;height:100%;object-fit:cover;"/>
          @else
            <span style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:var(--gold);">{{ strtoupper(substr($article->user->nom,0,2)) }}</span>
          @endif
        </div>

        {{-- Contenu --}}
        <div style="flex:1;min-width:0;">
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;flex-wrap:wrap;">
            <span class="rl-badge rl-badge-gold">{{ $article->user->profession?->nom ?? $article->user->profession_libre ?? 'Expert' }}</span>
            <span style="font-size:.75rem;color:var(--txt-muted);"><i class="fas fa-calendar" style="margin-right:4px;"></i>{{ $article->created_at->format('d M Y') }}</span>
          </div>
          <div style="font-family:'Playfair Display',serif;font-size:1.05rem;font-weight:500;color:var(--ink);margin-bottom:8px;" class="article-title">
            {{ $article->title }}
          </div>
          <div style="font-size:.85rem;color:var(--txt-muted);line-height:1.6;margin-bottom:12px;" class="article-excerpt">
            {{ Str::limit(strip_tags($article->content), 150) }}
          </div>
          <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
            <div style="display:flex;gap:16px;font-size:.75rem;color:var(--txt-muted);">
              <span><i class="fas fa-eye" style="margin-right:4px;"></i>{{ $article->views }}</span>
              <span><i class="fas fa-comments" style="margin-right:4px;"></i>{{ $article->questions()->count() }} question(s)</span>
              <span style="font-weight:500;color:var(--txt);">Par <strong>{{ $article->user->nom }}</strong></span>
            </div>
            <a href="{{ route('articles.show', $article->id) }}" class="rl-btn" style="padding:7px 16px;font-size:.8rem;">
              Lire l'article <i class="fas fa-arrow-right" style="margin-left:4px;"></i>
            </a>
          </div>
        </div>

      </div>
    </div>
    @endforeach
  </div>

  {{-- PAGINATION --}}
  <div style="display:flex;justify-content:center;">{{ $articles->links() }}</div>

  @else
  <div class="rl-card" style="text-align:center;padding:48px 32px;">
    <div style="font-size:3rem;margin-bottom:16px;">📰</div>
    <div style="font-family:'Playfair Display',serif;font-size:1.2rem;color:var(--ink);margin-bottom:8px;">Aucun article disponible</div>
    <div style="font-size:.88rem;color:var(--txt-muted);">Les articles seront bientôt disponibles.</div>
  </div>
  @endif

</div>
@endsection

@section('scripts')
<script>
  const searchInput = document.getElementById('searchInput');
  searchInput?.addEventListener('keyup', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.article-card').forEach(card => {
      const title   = card.querySelector('.article-title')?.textContent.toLowerCase() ?? '';
      const excerpt = card.querySelector('.article-excerpt')?.textContent.toLowerCase() ?? '';
      card.style.display = (title.includes(q) || excerpt.includes(q)) ? '' : 'none';
    });
  });
</script>
@endsection