@extends('layouts.app')

@section('title', 'Mon Espace — RoukLegal')

@section('page-title')
  Mon Espace <span>/ Dashboard</span>
@endsection

@section('topbar-actions')
  <a href="{{ route('articles.index') }}" class="rl-btn">
    <i class="fas fa-plus"></i> Poser une question
  </a>
@endsection

@section('content')
@php
  $subType  = $subscriptionType ?? 'none';
  $icons    = ['trial'=>'⏳','active'=>'✅','expired'=>'⚠️','none'=>'🔓'];
@endphp
<div style="display:flex;flex-direction:column;gap:28px;">

  {{-- BANNIÈRE ABONNEMENT --}}
  @php
    $bannerBg = [
      'trial'  =>'var(--orange-dim)','active'=>'var(--green-dim)',
      'expired'=>'var(--red-dim)',   'none'  =>'var(--blue-dim)'
    ];
    $bannerBorder = [
      'trial'  =>'rgba(230,126,34,.25)','active'=>'rgba(39,174,96,.25)',
      'expired'=>'rgba(231,76,60,.25)', 'none'  =>'rgba(41,128,185,.25)'
    ];
    $titleColor = [
      'trial'=>'var(--orange)','active'=>'var(--green)',
      'expired'=>'var(--red)', 'none'=>'var(--blue)'
    ];
  @endphp
  <div class="fade-up" style="background:{{ $bannerBg[$subType] }};border:1px solid {{ $bannerBorder[$subType] }};border-radius:var(--radius);padding:22px 28px;display:flex;align-items:center;justify-content:space-between;gap:20px;">
    <div style="display:flex;align-items:center;gap:16px;">
      <div style="font-size:1.8rem;">{{ $icons[$subType] }}</div>
      <div>
        <div style="font-weight:600;font-size:.95rem;color:{{ $titleColor[$subType] }};">{{ $subscriptionLabel }}</div>
        <div style="font-size:.8rem;color:var(--txt-muted);margin-top:2px;">
          @if($subType==='trial') Votre essai expire le {{ \Carbon\Carbon::parse($subscriptionExpiry)->format('d/m/Y') }}
          @elseif($subType==='active') Abonnement valide jusqu'au {{ \Carbon\Carbon::parse($subscriptionExpiry)->format('d/m/Y') }}
          @elseif($subType==='expired') Votre accès a expiré — renouvelez pour continuer
          @else Activez votre essai gratuit pour accéder à toutes les fonctionnalités
          @endif
        </div>
      </div>
    </div>
    <div style="display:flex;align-items:center;gap:16px;">
      @if(in_array($subType,['trial','active']))
        <div style="text-align:center;">
          <div style="font-family:'Playfair Display',serif;font-size:2rem;font-weight:700;color:{{ $titleColor[$subType] }};line-height:1;">{{ $subscriptionDaysLeft }}</div>
          <div style="font-size:.7rem;color:var(--txt-muted);">jours restants</div>
        </div>
        <a href="{{ route('client.abonnement') }}" class="rl-btn-outline">Gérer</a>
      @elseif($subType === 'none')
        <a href="#" class="rl-btn" onclick="event.preventDefault();fetch('{{ route('client.startTrial') }}',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'}}).then(()=>location.reload())">
          Démarrer l'essai gratuit
        </a>
      @else
        {{-- expired --}}
        <a href="{{ route('client.abonnement') }}" class="rl-btn">
          <i class="fas fa-refresh"></i> Renouveler
        </a>
      @endif
    </div>
  </div>

  {{-- STATS --}}
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
    <div class="rl-stat-card fade-up" style="--accent:var(--gold);animation-delay:.1s">
      <div class="rl-stat-header"><span class="rl-stat-label">Questions posées</span><span>❓</span></div>
      <div class="rl-stat-value">{{ $questionsCount }}</div>
      <div class="rl-stat-sub">Depuis l'inscription</div>
    </div>
    <div class="rl-stat-card fade-up" style="--accent:var(--blue);animation-delay:.15s">
      <div class="rl-stat-header"><span class="rl-stat-label">Réponses reçues</span><span>💬</span></div>
      <div class="rl-stat-value">{{ $recentQuestions->sum(fn($q)=>$q->reponses->count()) }}</div>
      <div class="rl-stat-sub">Sur vos questions récentes</div>
    </div>
    <div class="rl-stat-card fade-up" style="--accent:var(--green);animation-delay:.2s">
      <div class="rl-stat-header"><span class="rl-stat-label">Paiements</span><span>💳</span></div>
      <div class="rl-stat-value">{{ $paymentsCount }}</div>
      <div class="rl-stat-sub">Transactions effectuées</div>
    </div>
  </div>

  {{-- BOTTOM GRID --}}
  <div style="display:grid;grid-template-columns:1.5fr 1fr;gap:24px;">

    {{-- Questions récentes --}}
    <div class="rl-card fade-up" style="animation-delay:.25s">
      <div class="rl-card-header">
        <span class="rl-card-title">Questions récentes</span>
        <a href="{{ route('client.questions') }}" class="rl-card-link">Voir tout →</a>
      </div>
      <div style="display:flex;flex-direction:column;gap:12px;">
        @forelse($recentQuestions as $q)
        <div style="padding:14px 16px;border-radius:10px;background:var(--surface2);border:1px solid var(--border);border-left:3px solid {{ $q->reponses->count()>0 ? 'var(--green)' : 'var(--orange)' }};display:flex;align-items:flex-start;gap:14px;">
          <div style="flex:1;min-width:0;">
            <div style="font-size:.85rem;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $q->titre }}</div>
            <div style="display:flex;gap:10px;margin-top:5px;">
              <span style="font-size:.72rem;color:var(--txt-muted);">{{ $q->created_at->format('d/m/Y') }}</span>
              @if($q->reponses->count()>0)
                <span style="font-size:.72rem;color:var(--green);font-weight:600;">{{ $q->reponses->count() }} réponse(s)</span>
              @else
                <span style="font-size:.72rem;color:var(--orange);">En attente</span>
              @endif
            </div>
          </div>
        </div>
        @empty
        <div style="text-align:center;padding:32px;color:var(--txt-muted);">
          <div style="font-size:2rem;margin-bottom:8px;">💬</div>
          Aucune question posée pour l'instant.<br>
          <a href="{{ route('articles.index') }}" style="color:var(--gold);font-weight:600;font-size:.82rem;">Parcourir les articles →</a>
        </div>
        @endforelse
      </div>
    </div>

    {{-- Actions rapides --}}
    <div class="rl-card fade-up" style="animation-delay:.3s">
      <div class="rl-card-header"><span class="rl-card-title">Actions rapides</span></div>
      <div style="display:flex;flex-direction:column;gap:12px;">
        @foreach([
          ['route'=>'client.acteurs','icon'=>'⚖️','title'=>'Trouver un acteur','desc'=>'Avocats, notaires, huissiers…'],
          ['route'=>'client.questions','icon'=>'📋','title'=>'Mes questions','desc'=>'Historique & réponses'],
          ['route'=>'messages.index','icon'=>'💬','title'=>'Messagerie','desc'=>'Discussions privées'],
          ['route'=>'client.articles','icon'=>'📰','title'=>'Lire les articles','desc'=>'Actualités juridiques'],
        ] as $action)
        <a href="{{ route($action['route']) }}" style="display:flex;align-items:center;gap:14px;padding:15px 18px;border-radius:10px;background:var(--surface2);border:1px solid var(--border);text-decoration:none;transition:background .18s,border-color .18s,transform .15s;" onmouseover="this.style.background='var(--gold-dim)';this.style.borderColor='var(--gold)';this.style.transform='translateX(4px)'" onmouseout="this.style.background='var(--surface2)';this.style.borderColor='var(--border)';this.style.transform='none'">
          <div style="width:38px;height:38px;border-radius:9px;background:var(--gold-dim);display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;">{{ $action['icon'] }}</div>
          <div>
            <div style="font-size:.88rem;font-weight:600;color:var(--txt);">{{ $action['title'] }}</div>
            <div style="font-size:.75rem;color:var(--txt-muted);margin-top:2px;">{{ $action['desc'] }}</div>
          </div>
          <span style="margin-left:auto;color:var(--txt-muted);">›</span>
        </a>
        @endforeach
      </div>
    </div>

  </div>
</div>
@endsection