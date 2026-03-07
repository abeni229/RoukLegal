@extends('layouts.app')

@section('title', 'Mes Articles — RoukLegal')

@section('page-title')
  Mes Articles <span>/ Gestion</span>
@endsection

@section('topbar-actions')
  <a href="{{ route('articles.create') }}" class="rl-btn">
    <i class="fas fa-plus"></i> Nouvel article
  </a>
@endsection

@section('content')
<div style="display:flex;flex-direction:column;gap:24px;">

  {{-- STATS --}}
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
    <div class="rl-stat-card fade-up" style="--accent:var(--gold);">
      <div class="rl-stat-header"><span class="rl-stat-label">Articles publiés</span><span>📰</span></div>
      <div class="rl-stat-value">{{ $articles->count() }}</div>
      <div class="rl-stat-sub">Total publié</div>
    </div>
    <div class="rl-stat-card fade-up" style="--accent:var(--blue);animation-delay:.08s">
      <div class="rl-stat-header"><span class="rl-stat-label">Vues totales</span><span>👁️</span></div>
      <div class="rl-stat-value">{{ $articles->sum('views') }}</div>
      <div class="rl-stat-sub">Sur tous vos articles</div>
    </div>
    <div class="rl-stat-card fade-up" style="--accent:var(--green);animation-delay:.13s">
      <div class="rl-stat-header"><span class="rl-stat-label">Questions reçues</span><span>❓</span></div>
      <div class="rl-stat-value">{{ $articles->sum(fn($a) => $a->questions()->count()) }}</div>
      <div class="rl-stat-sub">Total des questions</div>
    </div>
  </div>

  {{-- LISTE --}}
  @if($articles->isEmpty())
  <div class="rl-card" style="text-align:center;padding:48px 32px;">
    <div style="font-size:3rem;margin-bottom:16px;">📝</div>
    <div style="font-family:'Playfair Display',serif;font-size:1.2rem;color:var(--ink);margin-bottom:8px;">Aucun article publié</div>
    <div style="font-size:.88rem;color:var(--txt-muted);margin-bottom:24px;">Commencez à partager votre expertise juridique.</div>
    <a href="{{ route('articles.create') }}" class="rl-btn"><i class="fas fa-pen-fancy"></i> Créer votre premier article</a>
  </div>

  @else
  <div style="display:flex;flex-direction:column;gap:16px;">
    @foreach($articles as $article)
    <div class="rl-card fade-up" style="animation-delay:{{ $loop->index * 0.05 }}s">
      <div style="display:flex;align-items:flex-start;gap:20px;">

        {{-- Numéro --}}
        <div style="width:40px;height:40px;border-radius:10px;background:var(--gold-dim);border:1px solid rgba(201,168,76,.3);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:var(--gold);flex-shrink:0;">
          {{ $loop->iteration }}
        </div>

        {{-- Contenu --}}
        <div style="flex:1;min-width:0;">
          <div style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:500;color:var(--ink);margin-bottom:8px;">
            {{ $article->title }}
          </div>
          <div style="font-size:.82rem;color:var(--txt-muted);margin-bottom:10px;line-height:1.5;">
            {{ Str::limit(strip_tags($article->content), 120) }}
          </div>
          <div style="display:flex;flex-wrap:wrap;gap:12px;font-size:.75rem;color:var(--txt-muted);">
            <span><i class="fas fa-calendar" style="margin-right:4px;"></i>{{ $article->created_at->format('d M Y') }}</span>
            <span><i class="fas fa-eye" style="margin-right:4px;"></i>{{ $article->views }} vue(s)</span>
            <span style="color:var(--gold);font-weight:600;"><i class="fas fa-comments" style="margin-right:4px;"></i>{{ $article->questions()->count() }} question(s)</span>
          </div>
        </div>

        {{-- Actions --}}
        <div style="display:flex;gap:8px;flex-shrink:0;">
          <a href="{{ route('articles.show', $article->id) }}" class="rl-btn-outline" style="padding:6px 12px;font-size:.78rem;">
            <i class="fas fa-eye"></i>
          </a>
          <a href="{{ route('articles.edit', $article->id) }}" class="rl-btn" style="padding:6px 12px;font-size:.78rem;background:var(--blue);">
            <i class="fas fa-edit"></i>
          </a>
          <form action="{{ route('articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Supprimer cet article définitivement ?')">
            @csrf
            @method('DELETE')
            <button type="submit" style="display:flex;align-items:center;padding:6px 12px;border-radius:8px;background:var(--red-dim);border:1px solid rgba(231,76,60,.3);color:var(--red);font-size:.78rem;cursor:pointer;transition:background .15s;" onmouseover="this.style.background='var(--red)';this.style.color='white'" onmouseout="this.style.background='var(--red-dim)';this.style.color='var(--red)'">
              <i class="fas fa-trash"></i>
            </button>
          </form>
        </div>

      </div>
    </div>
    @endforeach
  </div>
  @endif

</div>
@endsection