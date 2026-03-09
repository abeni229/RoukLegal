@extends('layouts.app')

@section('title', 'Mes Rendez-vous — RoukLegal')

@section('page-title')
  Mes Rendez-vous <span>/ Suivi</span>
@endsection

@section('topbar-actions')
  <a href="{{ route('client.acteurs') }}" class="rl-btn">
    <i class="fas fa-plus"></i> Nouveau RDV
  </a>
@endsection

@section('content')
@php
  $statuts = [
    'en_attente'      => ['label'=>'En attente','color'=>'var(--orange)','bg'=>'var(--orange-dim)','icon'=>'⏳'],
    'payé'            => ['label'=>'Paiement reçu','color'=>'var(--blue)','bg'=>'rgba(52,152,219,.08)','icon'=>'💳'],
    'validé_admin'    => ['label'=>'Validé — en attente acteur','color'=>'var(--gold)','bg'=>'var(--gold-dim)','icon'=>'✔️'],
    'confirmé_acteur' => ['label'=>'Confirmé','color'=>'var(--green)','bg'=>'var(--green-dim)','icon'=>'✅'],
    'refusé'          => ['label'=>'Refusé','color'=>'var(--red)','bg'=>'var(--red-dim)','icon'=>'❌'],
    'remboursé'       => ['label'=>'Remboursé','color'=>'var(--txt-muted)','bg'=>'var(--surface2)','icon'=>'↩️'],
  ];
@endphp

<div style="display:flex;flex-direction:column;gap:24px;">

  {{-- STATS --}}
  @php $all = $rdvs->getCollection(); @endphp
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
    <div class="rl-stat-card fade-up" style="--accent:var(--gold);">
      <div class="rl-stat-header"><span class="rl-stat-label">Total</span><span>📅</span></div>
      <div class="rl-stat-value">{{ $rdvs->total() }}</div>
      <div class="rl-stat-sub">Rendez-vous réservés</div>
    </div>
    <div class="rl-stat-card fade-up" style="--accent:var(--green);animation-delay:.07s">
      <div class="rl-stat-header"><span class="rl-stat-label">Confirmés</span><span>✅</span></div>
      <div class="rl-stat-value">{{ $all->where('statut_paiement','confirmé_acteur')->count() }}</div>
      <div class="rl-stat-sub">Consultations à venir</div>
    </div>
    <div class="rl-stat-card fade-up" style="--accent:var(--blue);animation-delay:.13s">
      <div class="rl-stat-header"><span class="rl-stat-label">En cours</span><span>⏳</span></div>
      <div class="rl-stat-value">{{ $all->whereIn('statut_paiement',['payé','validé_admin'])->count() }}</div>
      <div class="rl-stat-sub">En attente de confirmation</div>
    </div>
  </div>

  {{-- LISTE --}}
  @if($rdvs->count() > 0)
  <div style="display:flex;flex-direction:column;gap:14px;">
    @foreach($rdvs as $rdv)
    @php $s = $statuts[$rdv->statut_paiement] ?? $statuts['en_attente']; @endphp
    <div class="rl-card fade-up" style="animation-delay:{{ $loop->index * 0.04 }}s;">
      <div style="display:flex;gap:20px;align-items:flex-start;flex-wrap:wrap;">

        {{-- Calendrier date --}}
        <div style="width:56px;height:56px;border-radius:12px;background:var(--gold-dim);border:1px solid var(--border);display:flex;flex-direction:column;align-items:center;justify-content:center;flex-shrink:0;">
          <span style="font-family:'Playfair Display',serif;font-size:1.2rem;font-weight:700;color:var(--gold);line-height:1;">{{ $rdv->date_heure->format('d') }}</span>
          <span style="font-size:.58rem;color:var(--txt-muted);text-transform:uppercase;letter-spacing:.05em;">{{ $rdv->date_heure->translatedFormat('M Y') }}</span>
        </div>

        {{-- Infos --}}
        <div style="flex:1;min-width:0;">
          <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;flex-wrap:wrap;">
            <span style="font-size:.7rem;padding:3px 10px;border-radius:100px;background:{{ $s['bg'] }};color:{{ $s['color'] }};border:1px solid {{ $s['color'] }}22;">
              {{ $s['icon'] }} {{ $s['label'] }}
            </span>
            <span style="font-size:.72rem;color:var(--txt-muted);">
              <i class="fas fa-clock" style="margin-right:3px;"></i>{{ $rdv->date_heure->format('H:i') }}
            </span>
          </div>

          <div style="font-family:'Playfair Display',serif;font-size:.95rem;font-weight:500;color:var(--ink);margin-bottom:8px;">
            {{ $rdv->sujet }}
          </div>

          <div style="display:flex;flex-wrap:wrap;gap:14px;font-size:.75rem;color:var(--txt-muted);">
            <span>
              <i class="fas fa-user-tie" style="margin-right:4px;color:var(--gold);"></i>{{ $rdv->acteur->nom }}
            </span>
            <span>
              <i class="fas fa-money-bill" style="margin-right:4px;color:var(--gold);"></i>{{ number_format($rdv->montant,0,',',' ') }} FCFA
            </span>
            @if($rdv->paiement)
            <span>
              <i class="fas fa-receipt" style="margin-right:4px;color:var(--gold);"></i>{{ $rdv->paiement->paygate_reference }}
            </span>
            <span style="color:{{ $rdv->paiement->statut==='remboursé' ? 'var(--red)' : 'var(--green)' }}">
              <i class="fas fa-credit-card" style="margin-right:4px;"></i>{{ ucfirst($rdv->paiement->methode) }} · {{ ucfirst($rdv->paiement->statut) }}
            </span>
            @endif
          </div>
        </div>

        {{-- Timeline statut --}}
        <div style="display:flex;flex-direction:column;gap:4px;min-width:160px;flex-shrink:0;">
          @foreach([
            ['payé','Paiement reçu'],
            ['validé_admin','Validé par admin'],
            ['confirmé_acteur','Confirmé par acteur'],
          ] as $step)
          @php
            $done = match($rdv->statut_paiement) {
              'payé'           => in_array($step[0],['payé']),
              'validé_admin'   => in_array($step[0],['payé','validé_admin']),
              'confirmé_acteur'=> in_array($step[0],['payé','validé_admin','confirmé_acteur']),
              default          => false
            };
          @endphp
          <div style="display:flex;align-items:center;gap:8px;font-size:.72rem;color:{{ $done ? 'var(--green)' : 'var(--txt-muted)' }};">
            <span style="width:16px;height:16px;border-radius:50%;background:{{ $done ? 'var(--green)' : 'var(--surface2)' }};border:1px solid {{ $done ? 'var(--green)' : 'var(--border)' }};display:flex;align-items:center;justify-content:center;font-size:.55rem;flex-shrink:0;">
              {{ $done ? '✓' : '' }}
            </span>
            {{ $step[1] }}
          </div>
          @endforeach
          @if(in_array($rdv->statut_paiement,['refusé','remboursé']))
          <div style="font-size:.72rem;color:var(--red);margin-top:4px;">{{ $rdv->statut_paiement === 'refusé' ? '❌ Refusé' : '↩️ Remboursé' }}</div>
          @endif
        </div>

      </div>
    </div>
    @endforeach
  </div>

  <div style="display:flex;justify-content:center;">{{ $rdvs->links() }}</div>

  @else
  <div class="rl-card" style="text-align:center;padding:48px 32px;">
    <div style="font-size:3rem;margin-bottom:16px;">📅</div>
    <div style="font-family:'Playfair Display',serif;font-size:1.1rem;color:var(--ink);margin-bottom:8px;">Aucun rendez-vous</div>
    <div style="font-size:.85rem;color:var(--txt-muted);margin-bottom:20px;">Réservez une consultation avec un expert juridique.</div>
    <a href="{{ route('client.acteurs') }}" class="rl-btn"><i class="fas fa-search"></i> Trouver un expert</a>
  </div>
  @endif

</div>
@endsection