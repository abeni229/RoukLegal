@extends('layouts.app')

@section('title', 'Mes Rendez-vous — RoukLegal')

@section('page-title')
  Rendez-vous <span>/ Reçus</span>
@endsection

@section('topbar-actions')
  <a href="{{ route('acteur.creneaux') }}" class="rl-btn-outline">
    <i class="fas fa-clock"></i> Mes créneaux
  </a>
@endsection

@section('content')
@php
  $statuts = [
    'en_attente'      => ['label'=>'En attente','color'=>'var(--orange)','bg'=>'var(--orange-dim)'],
    'payé'            => ['label'=>'Payé — en attente admin','color'=>'var(--blue)','bg'=>'rgba(52,152,219,.08)'],
    'validé_admin'    => ['label'=>'Validé — à confirmer','color'=>'var(--gold)','bg'=>'var(--gold-dim)'],
    'confirmé_acteur' => ['label'=>'Confirmé','color'=>'var(--green)','bg'=>'var(--green-dim)'],
    'refusé'          => ['label'=>'Refusé','color'=>'var(--red)','bg'=>'var(--red-dim)'],
    'remboursé'       => ['label'=>'Remboursé','color'=>'var(--txt-muted)','bg'=>'var(--surface2)'],
  ];
@endphp

<div style="display:flex;flex-direction:column;gap:20px;">

  {{-- STATS --}}
  @php
    $all = $rdvs->getCollection();
  @endphp
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;">
    @foreach([
      ['📋','Total',$rdvs->total(),'var(--gold)'],
      ['⏳','À confirmer',$all->where('statut_paiement','validé_admin')->count(),'var(--gold)'],
      ['✅','Confirmés',$all->where('statut_paiement','confirmé_acteur')->count(),'var(--green)'],
      ['💵','Revenus',$all->where('statut_paiement','confirmé_acteur')->sum('commission_acteur').' F','var(--blue)'],
    ] as $s)
    <div class="rl-stat-card fade-up" style="--accent:{{ $s[3] }};">
      <div class="rl-stat-header"><span class="rl-stat-label">{{ $s[1] }}</span><span>{{ $s[0] }}</span></div>
      <div class="rl-stat-value">{{ $s[2] }}</div>
    </div>
    @endforeach
  </div>

  {{-- LISTE --}}
  @if($rdvs->count() > 0)
  <div style="display:flex;flex-direction:column;gap:14px;">
    @foreach($rdvs as $rdv)
    @php
      $s = $statuts[$rdv->statut_paiement] ?? $statuts['en_attente'];
    @endphp
    <div class="rl-card fade-up" style="animation-delay:{{ $loop->index * 0.04 }}s;">
      <div style="display:flex;align-items:flex-start;gap:20px;flex-wrap:wrap;">

        {{-- Date --}}
        <div style="width:56px;height:56px;border-radius:12px;background:var(--gold-dim);border:1px solid var(--border);display:flex;flex-direction:column;align-items:center;justify-content:center;flex-shrink:0;">
          <span style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:var(--gold);line-height:1;">{{ $rdv->date_heure->format('d') }}</span>
          <span style="font-size:.6rem;color:var(--txt-muted);text-transform:uppercase;letter-spacing:.05em;">{{ $rdv->date_heure->translatedFormat('M') }}</span>
        </div>

        {{-- Infos --}}
        <div style="flex:1;min-width:0;">
          <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;flex-wrap:wrap;">
            <span style="font-size:.75rem;font-weight:600;padding:3px 10px;border-radius:100px;background:{{ $s['bg'] }};color:{{ $s['color'] }};border:1px solid {{ $s['color'] }}22;">
              {{ $s['label'] }}
            </span>
            <span style="font-size:.72rem;color:var(--txt-muted);">
              <i class="fas fa-clock" style="margin-right:3px;"></i>{{ $rdv->date_heure->format('H:i') }}
            </span>
          </div>
          <div style="font-family:'Playfair Display',serif;font-size:.95rem;font-weight:500;color:var(--ink);margin-bottom:6px;">
            {{ $rdv->sujet }}
          </div>
          <div style="font-size:.78rem;color:var(--txt-muted);display:flex;flex-wrap:wrap;gap:12px;">
            <span><i class="fas fa-user" style="margin-right:4px;color:var(--gold);"></i>{{ $rdv->client->nom }}</span>
            <span><i class="fas fa-money-bill" style="margin-right:4px;color:var(--gold);"></i>{{ number_format($rdv->montant,0,',',' ') }} FCFA</span>
            @if($rdv->paiement)
            <span><i class="fas fa-receipt" style="margin-right:4px;color:var(--gold);"></i>{{ $rdv->paiement->paygate_reference }}</span>
            @endif
          </div>
        </div>

        {{-- Actions --}}
        <div style="display:flex;flex-direction:column;gap:8px;flex-shrink:0;">
          @if($rdv->statut_paiement === 'validé_admin')
          <form method="POST" action="{{ route('acteur.rdv.confirmer', $rdv->id) }}">
            @csrf
            <button type="submit" class="rl-btn" style="padding:8px 16px;font-size:.78rem;white-space:nowrap;background:var(--green);">
              <i class="fas fa-check"></i> Confirmer
            </button>
          </form>
          <form method="POST" action="{{ route('acteur.rdv.refuser', $rdv->id) }}" onsubmit="return confirm('Refuser ce RDV ? Le client sera remboursé.')">
            @csrf
            <button type="submit" style="display:flex;align-items:center;justify-content:center;gap:6px;padding:8px 16px;background:var(--red-dim);border:1px solid rgba(231,76,60,.3);border-radius:8px;color:var(--red);font-size:.78rem;cursor:pointer;white-space:nowrap;">
              <i class="fas fa-times"></i> Refuser
            </button>
          </form>
          @elseif($rdv->statut_paiement === 'payé')
          <div style="padding:8px 14px;background:var(--surface2);border-radius:8px;border:1px solid var(--border);font-size:.72rem;color:var(--txt-muted);text-align:center;">
            ⏳ En attente<br>validation admin
          </div>
          @elseif($rdv->statut_paiement === 'confirmé_acteur')
          <div style="padding:8px 14px;background:var(--green-dim);border-radius:8px;border:1px solid rgba(39,174,96,.2);font-size:.72rem;color:var(--green);text-align:center;">
            ✓ Confirmé
          </div>
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
    <div style="font-family:'Playfair Display',serif;font-size:1.1rem;color:var(--ink);margin-bottom:8px;">Aucun rendez-vous reçu</div>
    <div style="font-size:.85rem;color:var(--txt-muted);margin-bottom:20px;">Définissez vos créneaux pour commencer à recevoir des réservations.</div>
    <a href="{{ route('acteur.creneaux') }}" class="rl-btn"><i class="fas fa-clock"></i> Gérer mes créneaux</a>
  </div>
  @endif

</div>
@endsection