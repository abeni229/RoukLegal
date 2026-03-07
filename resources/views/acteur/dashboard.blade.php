@extends('layouts.app')

@section('title', 'Espace Acteur — RoukLegal')

@section('page-title')
  Mon Espace <span>/ Acteur Juridique</span>
@endsection

@section('topbar-actions')
  <a href="{{ route('articles.create') }}" class="rl-btn">
    <i class="fas fa-plus"></i> Nouvel article
  </a>
@endsection

@section('content')
<div style="display:flex;flex-direction:column;gap:28px;">

  {{-- BANNIÈRE DE BIENVENUE --}}
  <div class="fade-up" style="background:linear-gradient(135deg,#111820 0%,#1a2535 100%);border-radius:var(--radius);padding:28px 32px;display:flex;align-items:center;justify-content:space-between;gap:20px;border:1px solid rgba(201,168,76,.2);position:relative;overflow:hidden;">
    <div style="position:absolute;right:32px;top:50%;transform:translateY(-50%);font-size:5rem;opacity:.06;">⚖️</div>
    <div>
      <div style="font-size:.8rem;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:1.5px;">Bienvenue</div>
      <div style="font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:700;color:white;margin:4px 0;">{{ Auth::user()->nom }}</div>
      @if($profession)
        <div style="display:inline-flex;align-items:center;gap:6px;background:var(--gold-dim);border:1px solid rgba(201,168,76,.3);color:var(--gold-lt);font-size:.78rem;font-weight:500;padding:4px 12px;border-radius:20px;">⚖️ {{ $profession->nom }}</div>
      @endif
    </div>
    @if($pendingQuestions > 0)
    <div style="background:var(--orange-dim);border:1px solid rgba(230,126,34,.3);border-radius:10px;padding:14px 20px;display:flex;align-items:center;gap:12px;">
      <div style="font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:700;color:var(--orange);line-height:1;">{{ $pendingQuestions }}</div>
      <div>
        <div style="font-size:.72rem;color:var(--orange);font-weight:600;">En attente</div>
        <div style="font-size:.7rem;color:rgba(255,255,255,.4);">question(s) à traiter</div>
      </div>
    </div>
    @endif
  </div>

  {{-- STATS --}}
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;">
    <div class="rl-stat-card fade-up" style="--accent:var(--gold);animation-delay:.08s">
      <div class="rl-stat-header"><span class="rl-stat-label">Réponses données</span><span>💬</span></div>
      <div class="rl-stat-value">{{ $assigned }}</div>
      <div class="rl-stat-sub">Depuis l'inscription</div>
    </div>
    <div class="rl-stat-card fade-up" style="--accent:var(--blue);animation-delay:.13s">
      <div class="rl-stat-header"><span class="rl-stat-label">Articles publiés</span><span>📰</span></div>
      <div class="rl-stat-value">{{ $articles }}</div>
      <div class="rl-stat-sub">Contenus publiés</div>
    </div>
    <div class="rl-stat-card fade-up" style="--accent:var(--green);animation-delay:.18s">
      <div class="rl-stat-header"><span class="rl-stat-label">Questions reçues</span><span>❓</span></div>
      <div class="rl-stat-value">{{ $totalQuestions }}</div>
      <div class="rl-stat-sub">Sur tous vos articles</div>
    </div>
    <div class="rl-stat-card fade-up" style="--accent:var(--orange);animation-delay:.23s">
      <div class="rl-stat-header"><span class="rl-stat-label">En attente</span><span>⏳</span></div>
      <div class="rl-stat-value">{{ $pendingQuestions }}</div>
      <div class="rl-stat-sub">
        @if($pendingQuestions > 0)
          <span style="color:var(--orange);font-weight:600;">À traiter</span>
        @else
          <span style="color:var(--green);font-weight:600;">Tout traité ✓</span>
        @endif
      </div>
    </div>
  </div>

  {{-- BOTTOM GRID --}}
  <div style="display:grid;grid-template-columns:1.5fr 1fr;gap:24px;">

    {{-- Questions récentes --}}
    <div class="rl-card fade-up" style="animation-delay:.28s">
      <div class="rl-card-header">
        <span class="rl-card-title">Questions récentes</span>
        <a href="{{ route('acteur.questions') }}" class="rl-card-link">Voir tout →</a>
      </div>
      <div style="display:flex;flex-direction:column;gap:12px;">
        @forelse($recentQuestions as $q)
        @php $answered = $q->reponses->count() > 0; @endphp
        <div style="padding:15px 18px;border-radius:10px;background:var(--surface2);border:1px solid var(--border);border-left:3px solid {{ $answered ? 'var(--green)' : 'var(--orange)' }};display:flex;align-items:flex-start;justify-content:space-between;gap:14px;">
          <div style="flex:1;min-width:0;">
            <div style="font-size:.72rem;color:var(--txt-muted);margin-bottom:4px;">{{ $q->user->nom ?? 'Client' }}</div>
            <div style="font-size:.85rem;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $q->titre }}</div>
            <div style="font-size:.72rem;color:var(--txt-muted);margin-top:5px;">{{ $q->created_at->diffForHumans() }}</div>
          </div>
          <div style="flex-shrink:0;">
            @if($answered)
              <span class="rl-badge rl-badge-green">✓ Répondu</span>
            @else
              <a href="{{ route('acteur.questions') }}" class="rl-badge rl-badge-orange" style="text-decoration:none;cursor:pointer;">Répondre →</a>
            @endif
          </div>
        </div>
        @empty
        <div style="text-align:center;padding:32px;color:var(--txt-muted);">
          <div style="font-size:2rem;margin-bottom:8px;">📭</div>
          Aucune question pour l'instant.<br>
          <a href="{{ route('articles.create') }}" style="color:var(--gold);font-weight:600;font-size:.82rem;">Publier un article →</a>
        </div>
        @endforelse
      </div>
    </div>

    {{-- Actions rapides --}}
    <div class="rl-card fade-up" style="animation-delay:.33s">
      <div class="rl-card-header"><span class="rl-card-title">Actions rapides</span></div>
      <div style="display:flex;flex-direction:column;gap:12px;">
        @foreach([
          ['route'=>'acteur.questions','icon'=>'📋','title'=>'Voir les questions','desc'=>$pendingQuestions.' en attente'],
          ['route'=>'articles.create','icon'=>'✍️','title'=>'Rédiger un article','desc'=>'Partager votre expertise'],
          ['route'=>'articles.dashboard','icon'=>'📰','title'=>'Mes articles','desc'=>$articles.' article(s) publié(s)'],
          ['route'=>'messages.index','icon'=>'💬','title'=>'Messagerie','desc'=>'Discussions avec clients'],
          ['route'=>'acteur.profile','icon'=>'🪪','title'=>'Mon profil','desc'=>'Photo, description, spécialités'],
        ] as $action)
        <a href="{{ route($action['route']) }}" style="display:flex;align-items:center;gap:14px;padding:13px 16px;border-radius:10px;background:var(--surface2);border:1px solid var(--border);text-decoration:none;transition:background .18s,border-color .18s,transform .15s;" onmouseover="this.style.background='var(--gold-dim)';this.style.borderColor='var(--gold)';this.style.transform='translateX(4px)'" onmouseout="this.style.background='var(--surface2)';this.style.borderColor='var(--border)';this.style.transform='none'">
          <div style="width:36px;height:36px;border-radius:9px;background:var(--gold-dim);display:flex;align-items:center;justify-content:center;font-size:.95rem;flex-shrink:0;">{{ $action['icon'] }}</div>
          <div>
            <div style="font-size:.85rem;font-weight:600;color:var(--txt);">{{ $action['title'] }}</div>
            <div style="font-size:.73rem;color:var(--txt-muted);margin-top:1px;">{{ $action['desc'] }}</div>
          </div>
          <span style="margin-left:auto;color:var(--txt-muted);">›</span>
        </a>
        @endforeach
      </div>
    </div>

  </div>
</div>
@endsection