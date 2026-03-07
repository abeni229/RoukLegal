@extends('layouts.app')

@section('title', 'Éditer — {{ $article->title }}')

@section('page-title')
  Articles <span>/ Éditer</span>
@endsection

@section('topbar-actions')
  <a href="{{ route('articles.show', $article->id) }}" class="rl-btn-outline" style="margin-right:8px;">
    <i class="fas fa-eye"></i> Voir
  </a>
  <a href="{{ route('articles.dashboard') }}" class="rl-btn-outline">
    <i class="fas fa-arrow-left"></i> Mes articles
  </a>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:1fr 280px;gap:28px;align-items:start;">

  {{-- FORMULAIRE --}}
  <div class="rl-card fade-up">
    <div class="rl-card-header">
      <span class="rl-card-title">Modifier l'article</span>
    </div>
    <form method="POST" action="{{ route('articles.update', $article->id) }}">
      @csrf
      <div class="rl-form-group">
        <label class="rl-label" for="title">
          <i class="fas fa-heading" style="color:var(--gold);margin-right:6px;"></i>Titre <span style="color:var(--red)">*</span>
        </label>
        <input type="text" id="title" name="title" class="rl-input" value="{{ old('title', $article->title) }}" required>
        @error('title')<div style="font-size:.75rem;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      <div class="rl-form-group">
        <label class="rl-label" for="content">
          <i class="fas fa-file-alt" style="color:var(--gold);margin-right:6px;"></i>Contenu <span style="color:var(--red)">*</span>
        </label>
        <textarea id="content" name="content" class="rl-textarea" rows="14" required>{{ old('content', $article->content) }}</textarea>
        @error('content')<div style="font-size:.75rem;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      <div style="display:flex;gap:12px;">
        <button type="submit" class="rl-btn"><i class="fas fa-save"></i> Mettre à jour</button>
        <a href="{{ route('articles.dashboard') }}" class="rl-btn-outline"><i class="fas fa-times"></i> Annuler</a>
      </div>
    </form>
  </div>

  {{-- STATS --}}
  <div style="display:flex;flex-direction:column;gap:20px;">
    <div class="rl-card fade-up" style="animation-delay:.1s;">
      <div class="rl-card-header"><span class="rl-card-title">Statistiques</span></div>
      <div style="display:flex;flex-direction:column;gap:14px;">
        @foreach([
          ['👁️','Vues',$article->views],
          ['❓','Questions',$article->questions()->count()],
          ['📅','Publié le',$article->created_at->format('d/m/Y')],
          ['✏️','Modifié le',$article->updated_at->format('d/m/Y')],
        ] as $s)
        <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);">
          <div style="font-size:.82rem;color:var(--txt-muted);">{{ $s[0] }} {{ $s[1] }}</div>
          <div style="font-size:.88rem;font-weight:600;color:var(--ink);">{{ $s[2] }}</div>
        </div>
        @endforeach
      </div>
    </div>

    <div class="rl-card fade-up" style="animation-delay:.15s;">
      <div class="rl-card-header"><span class="rl-card-title">Actions</span></div>
      <div style="display:flex;flex-direction:column;gap:10px;">
        <a href="{{ route('articles.show', $article->id) }}" style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:var(--surface2);border-radius:8px;border:1px solid var(--border);text-decoration:none;font-size:.85rem;color:var(--txt);">
          <i class="fas fa-eye" style="color:var(--gold);width:16px;"></i> Voir l'article public
        </a>
        <a href="{{ route('acteur.questions') }}" style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:var(--surface2);border-radius:8px;border:1px solid var(--border);text-decoration:none;font-size:.85rem;color:var(--txt);">
          <i class="fas fa-question-circle" style="color:var(--gold);width:16px;"></i> Voir les questions
        </a>
        <form action="{{ route('articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Supprimer définitivement ?')">
          @csrf @method('DELETE')
          <button type="submit" style="display:flex;align-items:center;gap:10px;width:100%;padding:10px 14px;background:var(--red-dim);border:1px solid rgba(231,76,60,.3);border-radius:8px;color:var(--red);font-size:.85rem;cursor:pointer;">
            <i class="fas fa-trash" style="width:16px;"></i> Supprimer l'article
          </button>
        </form>
      </div>
    </div>
  </div>

</div>
@endsection