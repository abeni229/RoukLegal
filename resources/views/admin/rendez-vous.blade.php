@extends('layouts.app')

@section('title', 'Rendez-vous — Admin RoukLegal')

@section('page-title')
  Admin <span>/ Rendez-vous & Paiements</span>
@endsection

@section('content')
@php
  $statuts = [
    'en_attente'      => ['label'=>'En attente','color'=>'var(--orange)','bg'=>'var(--orange-dim)'],
    'payé'            => ['label'=>'À valider','color'=>'var(--blue)','bg'=>'rgba(52,152,219,.08)'],
    'paye'            => ['label'=>'À valider','color'=>'var(--blue)','bg'=>'rgba(52,152,219,.08)'],
    'validé_admin'    => ['label'=>'Validé','color'=>'var(--gold)','bg'=>'var(--gold-dim)'],
    'confirmé_acteur' => ['label'=>'Confirmé','color'=>'var(--green)','bg'=>'var(--green-dim)'],
    'refusé'          => ['label'=>'Refusé','color'=>'var(--red)','bg'=>'var(--red-dim)'],
    'remboursé'       => ['label'=>'Remboursé','color'=>'var(--txt-muted)','bg'=>'var(--surface2)'],
  ];
@endphp

<div style="display:flex;flex-direction:column;gap:24px;">

  {{-- STATS --}}
  <div style="display:grid;grid-template-columns:repeat(6,1fr);gap:14px;">
    @foreach([
      ['📋','Total',$stats['total'],'var(--gold)'],
      ['💳','À valider',$stats['en_attente'],'var(--blue)'],
      ['✔️','Validés',$stats['validés'],'var(--gold)'],
      ['✅','Confirmés',$stats['confirmés'],'var(--green)'],
      ['↩️','Remboursés',$stats['remboursés'],'var(--red)'],
      ['💵','Revenus admin',number_format($stats['revenus_total'],0,',',' ').' F','var(--green)'],
    ] as $s)
    <div class="rl-stat-card fade-up" style="--accent:{{ $s[3] }};">
      <div class="rl-stat-header"><span class="rl-stat-label">{{ $s[1] }}</span><span>{{ $s[0] }}</span></div>
      <div class="rl-stat-value" style="font-size:1.3rem;">{{ $s[2] }}</div>
    </div>
    @endforeach
  </div>

  {{-- ALERTE paiements en attente --}}
  @if($stats['en_attente'] > 0)
  <div style="display:flex;align-items:center;gap:12px;padding:14px 18px;background:rgba(52,152,219,.08);border:1px solid rgba(52,152,219,.25);border-radius:10px;">
    <i class="fas fa-bell" style="color:var(--blue);font-size:1rem;"></i>
    <span style="font-size:.85rem;color:var(--blue);font-weight:600;">
      {{ $stats['en_attente'] }} paiement(s) en attente de votre validation
    </span>
  </div>
  @endif

  {{-- TABLEAU --}}
  <div class="rl-card fade-up">
    <div class="rl-card-header">
      <span class="rl-card-title">Tous les rendez-vous</span>
      <span class="rl-badge rl-badge-gold">{{ $rdvs->total() }} total</span>
    </div>

    @if($rdvs->count() > 0)
    <div style="overflow-x:auto;">
      <table class="rl-table" style="width:100%;">
        <thead>
          <tr>
            <th>Date & Heure</th>
            <th>Client</th>
            <th>Acteur</th>
            <th>Sujet</th>
            <th>Paiement</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($rdvs as $rdv)
          @php $s = $statuts[$rdv->statut_paiement] ?? $statuts['en_attente']; @endphp
          <tr>
            <td>
              <div style="font-weight:600;color:var(--ink);font-size:.85rem;">{{ $rdv->date_heure->format('d/m/Y') }}</div>
              <div style="font-size:.72rem;color:var(--txt-muted);">{{ $rdv->date_heure->format('H:i') }}</div>
            </td>
            <td>
              <div style="font-size:.85rem;color:var(--ink);">{{ $rdv->client->nom }}</div>
              <div style="font-size:.7rem;color:var(--txt-muted);">{{ $rdv->client->email }}</div>
            </td>
            <td>
              <div style="font-size:.85rem;color:var(--ink);">{{ $rdv->acteur->nom }}</div>
              <div style="font-size:.7rem;color:var(--gold);">{{ $rdv->acteur->profession?->nom ?? 'Expert' }}</div>
            </td>
            <td>
              <div style="font-size:.82rem;color:var(--txt);max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                {{ $rdv->sujet }}
              </div>
            </td>
            <td>
              <div style="font-size:.82rem;font-weight:600;color:var(--ink);">{{ number_format($rdv->montant,0,',',' ') }} F</div>
              @if($rdv->paiement)
              <div style="font-size:.68rem;color:var(--txt-muted);">{{ $rdv->paiement->methode }}</div>
              <div style="font-size:.65rem;color:var(--txt-muted);font-family:monospace;">{{ Str::limit($rdv->paiement->paygate_reference,18) }}</div>
              @endif
              <div style="margin-top:4px;">
                <span style="font-size:.65rem;color:var(--green);">Admin: {{ number_format($rdv->commission_admin,0,',',' ') }} F</span>
                &nbsp;|&nbsp;
                <span style="font-size:.65rem;color:var(--txt-muted);">Acteur: {{ number_format($rdv->commission_acteur,0,',',' ') }} F</span>
              </div>
            </td>
            <td>
              <span style="font-size:.72rem;padding:4px 10px;border-radius:100px;background:{{ $s['bg'] }};color:{{ $s['color'] }};border:1px solid {{ $s['color'] }}22;white-space:nowrap;">
                {{ $s['label'] }}
              </span>
            </td>
            <td>
              <div style="display:flex;flex-direction:column;gap:6px;">
                @if(in_array($rdv->statut_paiement, ['payé','paye']))
                <form method="POST" action="{{ route('admin.rdv.valider', $rdv->id) }}">
                  @csrf
                  <button type="submit" class="rl-btn" style="padding:6px 12px;font-size:.72rem;white-space:nowrap;background:var(--green);">
                    <i class="fas fa-check"></i> Valider
                  </button>
                </form>
                <form method="POST" action="{{ route('admin.rdv.rembourser', $rdv->id) }}" onsubmit="return confirm('Rembourser ce client ?')">
                  @csrf
                  <button type="submit" style="display:flex;align-items:center;gap:5px;padding:6px 12px;background:var(--red-dim);border:1px solid rgba(231,76,60,.3);border-radius:8px;color:var(--red);font-size:.72rem;cursor:pointer;white-space:nowrap;">
                    <i class="fas fa-undo"></i> Rembourser
                  </button>
                </form>

                @elseif(in_array($rdv->statut_paiement, ['validé_admin','valide_admin','confirmé_acteur','confirme_acteur']))
                <form method="POST" action="{{ route('admin.rdv.rembourser', $rdv->id) }}" onsubmit="return confirm('Rembourser ce client ?')">
                  @csrf
                  <button type="submit" style="display:flex;align-items:center;gap:5px;padding:6px 12px;background:var(--red-dim);border:1px solid rgba(231,76,60,.3);border-radius:8px;color:var(--red);font-size:.72rem;cursor:pointer;white-space:nowrap;">
                    <i class="fas fa-undo"></i> Rembourser
                  </button>
                </form>

                @else
                <span style="font-size:.72rem;color:var(--txt-muted);">—</span>
                @endif
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div style="display:flex;justify-content:center;margin-top:20px;">{{ $rdvs->links() }}</div>

    @else
    <div style="text-align:center;padding:48px;color:var(--txt-muted);">
      <div style="font-size:2.5rem;margin-bottom:12px;">📅</div>
      <div style="font-size:.9rem;">Aucun rendez-vous enregistré pour le moment.</div>
    </div>
    @endif
  </div>

</div>
@endsection