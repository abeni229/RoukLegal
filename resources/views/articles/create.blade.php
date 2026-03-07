@extends('layouts.app')

@section('title', 'Créer un article — RoukLegal')

@section('page-title')
  Articles <span>/ Nouvel article</span>
@endsection

@section('topbar-actions')
  <a href="{{ route('articles.dashboard') }}" class="rl-btn-outline">
    <i class="fas fa-arrow-left"></i> Mes articles
  </a>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:1fr 300px;gap:28px;align-items:start;">

  {{-- FORMULAIRE --}}
  <div class="rl-card fade-up">
    <div class="rl-card-header">
      <span class="rl-card-title">Rédiger un article</span>
      <span class="rl-badge rl-badge-gold">Visible par tous les clients</span>
    </div>
    <form method="POST" action="{{ route('articles.store') }}">
      @csrf
      <div class="rl-form-group">
        <label class="rl-label" for="title">
          <i class="fas fa-heading" style="color:var(--gold);margin-right:6px;"></i>Titre de l'article <span style="color:var(--red)">*</span>
        </label>
        <input type="text" id="title" name="title" class="rl-input" value="{{ old('title') }}" required
          placeholder="Ex : Les droits des locataires en cas d'expulsion…">
        @error('title')<div style="font-size:.75rem;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      <div class="rl-form-group">
        <label class="rl-label" for="content">
          <i class="fas fa-file-alt" style="color:var(--gold);margin-right:6px;"></i>Contenu <span style="color:var(--red)">*</span>
        </label>
        <textarea id="content" name="content" class="rl-textarea" rows="14" required
          placeholder="Rédigez votre article ici. Soyez détaillé et structuré pour aider les clients…">{{ old('content') }}</textarea>
        <div style="font-size:.72rem;color:var(--txt-muted);margin-top:4px;">
          <i class="fas fa-info-circle"></i> Structurez avec des paragraphes clairs. Les clients pourront poser des questions.
        </div>
        @error('content')<div style="font-size:.75rem;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      <div style="display:flex;gap:12px;">
        <button type="submit" class="rl-btn"><i class="fas fa-paper-plane"></i> Publier l'article</button>
        <a href="{{ route('articles.dashboard') }}" class="rl-btn-outline"><i class="fas fa-times"></i> Annuler</a>
      </div>
    </form>
  </div>

  {{-- COLONNE DROITE --}}
  <div style="display:flex;flex-direction:column;gap:20px;">
    <div class="rl-card fade-up" style="animation-delay:.1s;background:linear-gradient(135deg,#111820,#1a2535);border-color:rgba(201,168,76,.2);">
      <div style="font-family:'Playfair Display',serif;font-size:1rem;color:var(--gold);margin-bottom:14px;">💡 Conseils de rédaction</div>
      <div style="display:flex;flex-direction:column;gap:10px;">
        @foreach([
          ['Titre accrocheur','Résumez le sujet en quelques mots'],
          ['Structure claire','Utilisez des paragraphes distincts'],
          ['Contenu utile','Répondez aux questions fréquentes'],
          ['Professionnalisme','Soyez précis et factuel'],
          ['Cas pratiques','Donnez des exemples concrets'],
        ] as $c)
        <div style="font-size:.82rem;color:rgba(255,255,255,.7);">
          <span style="color:var(--gold);font-weight:600;">{{ $c[0] }}</span>
          <span style="color:rgba(255,255,255,.4);"> — </span>{{ $c[1] }}
        </div>
        @endforeach
      </div>
    </div>

    <div class="rl-card fade-up" style="animation-delay:.15s;">
      <div class="rl-card-header"><span class="rl-card-title">Sujets populaires</span></div>
      <div style="display:flex;flex-direction:column;gap:8px;">
        @foreach(['Droit du travail','Droit de la famille','Contrats et obligations','Droit immobilier','Conseils fiscaux'] as $s)
        <div style="display:flex;align-items:center;gap:8px;font-size:.83rem;color:var(--txt-muted);padding:6px 0;border-bottom:1px solid var(--border);">
          <span style="color:var(--gold);">⚖️</span> {{ $s }}
        </div>
        @endforeach
      </div>
    </div>
  </div>

</div>
@endsection