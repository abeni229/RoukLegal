@extends('layouts.app')

@section('title', 'Choisir un abonnement — RoukLegal')

@section('page-title')
  Mon abonnement
@endsection

@section('content')
@php
  $subType = $subscriptionType ?? 'none';
@endphp

{{-- BANNIÈRE STATUT --}}
@if($subType === 'expired' || $subType === 'none')
<div style="padding:16px 20px;background:rgba(231,76,60,.08);border:1px solid rgba(231,76,60,.25);border-radius:12px;margin-bottom:28px;display:flex;align-items:center;gap:12px;">
  <i class="fas fa-exclamation-circle" style="color:var(--red);font-size:1.1rem;"></i>
  <div>
    <div style="font-weight:600;color:var(--red);font-size:.88rem;">
      @if($subType === 'expired') Votre essai gratuit a expiré @else Vous n'avez pas d'abonnement actif @endif
    </div>
    <div style="font-size:.78rem;color:var(--txt-muted);margin-top:2px;">Choisissez une formule ci-dessous pour continuer à accéder à la plateforme.</div>
  </div>
</div>
@elseif($subType === 'active')
<div style="padding:16px 20px;background:var(--green-dim);border:1px solid rgba(39,174,96,.25);border-radius:12px;margin-bottom:28px;display:flex;align-items:center;gap:12px;">
  <i class="fas fa-check-circle" style="color:var(--green);font-size:1.1rem;"></i>
  <div>
    <div style="font-weight:600;color:var(--green);font-size:.88rem;">Abonnement actif</div>
    <div style="font-size:.78rem;color:var(--txt-muted);margin-top:2px;">
      Expire le {{ \Carbon\Carbon::parse($subscriptionExpiry)->format('d/m/Y') }} · {{ $subscriptionDaysLeft }} jour(s) restant(s)
    </div>
  </div>
</div>
@endif

{{-- TITRE --}}
<div style="text-align:center;margin-bottom:40px;">
  <div style="font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:700;color:var(--ink);margin-bottom:8px;">
    Choisissez votre formule
  </div>
  <div style="font-size:.88rem;color:var(--txt-muted);">Accès complet à tous les services RoukLegal</div>
</div>

{{-- FORMULES --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;max-width:900px;margin:0 auto 48px;">

  @foreach([
    [
      'id'       => 'mensuel',
      'label'    => 'Mensuel',
      'prix'     => 5000,
      'duree'    => '1 mois',
      'popular'  => false,
      'features' => ['Accès illimité aux articles','Questions aux experts','Messagerie sécurisée','Prise de rendez-vous'],
    ],
    [
      'id'       => 'trimestriel',
      'label'    => 'Trimestriel',
      'prix'     => 12000,
      'duree'    => '3 mois',
      'popular'  => true,
      'features' => ['Accès illimité aux articles','Questions aux experts','Messagerie sécurisée','Prise de rendez-vous','Économisez 3 000 FCFA'],
    ],
    [
      'id'       => 'annuel',
      'label'    => 'Annuel',
      'prix'     => 40000,
      'duree'    => '12 mois',
      'popular'  => false,
      'features' => ['Accès illimité aux articles','Questions aux experts','Messagerie sécurisée','Prise de rendez-vous','Économisez 20 000 FCFA','Support prioritaire'],
    ],
  ] as $formule)
  <div style="background:var(--surface);border:2px solid {{ $formule['popular'] ? 'var(--gold)' : 'var(--border)' }};border-radius:16px;padding:32px 24px;position:relative;transition:transform .2s,box-shadow .2s;"
       onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 16px 40px rgba(0,0,0,.2)'"
       onmouseout="this.style.transform='none';this.style.boxShadow='none'">

    @if($formule['popular'])
    <div style="position:absolute;top:-14px;left:50%;transform:translateX(-50%);background:var(--gold);color:var(--bg);padding:4px 16px;border-radius:100px;font-size:.72rem;font-weight:700;white-space:nowrap;">
      ⭐ Le plus populaire
    </div>
    @endif

    <div style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:var(--ink);margin-bottom:4px;">{{ $formule['label'] }}</div>
    <div style="font-size:.75rem;color:var(--txt-muted);margin-bottom:20px;">{{ $formule['duree'] }}</div>

    <div style="margin-bottom:20px;">
      <span style="font-family:'Playfair Display',serif;font-size:2rem;font-weight:700;color:var(--gold);">{{ number_format($formule['prix'],0,',',' ') }}</span>
      <span style="font-size:.78rem;color:var(--txt-muted);"> FCFA</span>
    </div>

    <div style="display:flex;flex-direction:column;gap:8px;margin-bottom:24px;">
      @foreach($formule['features'] as $f)
      <div style="display:flex;align-items:center;gap:8px;font-size:.8rem;color:var(--txt-muted);">
        <i class="fas fa-check" style="color:var(--gold);width:12px;"></i> {{ $f }}
      </div>
      @endforeach
    </div>

    <button onclick="ouvrirPaiement('{{ $formule['id'] }}', {{ $formule['prix'] }}, '{{ $formule['label'] }}')"
      style="width:100%;padding:11px;border-radius:10px;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;font-size:.85rem;font-weight:600;transition:all .15s;
      background:{{ $formule['popular'] ? 'var(--gold)' : 'var(--surface2)' }};
      color:{{ $formule['popular'] ? 'var(--bg)' : 'var(--ink)' }};
      border:{{ $formule['popular'] ? 'none' : '1px solid var(--border)' }};">
      Choisir cette formule
    </button>
  </div>
  @endforeach

</div>

{{-- MODAL PAIEMENT --}}
<div id="modalPaiement" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:1000;align-items:center;justify-content:center;">
  <div style="background:var(--bg2);border:1px solid var(--border);border-radius:20px;padding:40px;width:100%;max-width:480px;position:relative;margin:24px;">

    <button onclick="fermerModal()" style="position:absolute;top:16px;right:16px;background:none;border:none;color:var(--txt-muted);cursor:pointer;font-size:1.1rem;">
      <i class="fas fa-times"></i>
    </button>

    <div style="font-family:'Playfair Display',serif;font-size:1.3rem;font-weight:700;color:var(--ink);margin-bottom:4px;">Paiement</div>
    <div id="modalSub" style="font-size:.82rem;color:var(--txt-muted);margin-bottom:24px;"></div>

    <form method="POST" action="{{ route('client.abonnement.payer') }}">
      @csrf
      <input type="hidden" name="formule" id="inputFormule">
      <input type="hidden" name="montant" id="inputMontant">

      {{-- Récap --}}
      <div style="padding:14px 16px;background:var(--surface);border:1px solid var(--border);border-radius:10px;margin-bottom:20px;">
        <div style="font-size:.72rem;font-weight:700;color:var(--txt-muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:10px;">Récapitulatif</div>
        <div style="display:flex;justify-content:space-between;font-size:.85rem;">
          <span style="color:var(--txt-muted);">Abonnement</span>
          <span id="recapLabel" style="color:var(--ink);font-weight:600;"></span>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:.85rem;margin-top:8px;padding-top:8px;border-top:1px solid var(--border);">
          <span style="color:var(--txt-muted);">Total</span>
          <span id="recapPrix" style="color:var(--gold);font-weight:700;font-size:.95rem;"></span>
        </div>
      </div>

      {{-- Méthode --}}
      <div style="margin-bottom:20px;">
        <div style="font-size:.78rem;font-weight:600;color:var(--txt-muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:10px;">Méthode de paiement</div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
          @foreach([['mobile_money','📱','Mobile Money','MTN / Moov'],['carte','💳','Carte bancaire','Visa / Mastercard']] as $m)
          <label style="display:flex;align-items:center;gap:10px;padding:12px;background:var(--surface);border:2px solid var(--border);border-radius:10px;cursor:pointer;transition:border-color .15s;" id="meth-{{ $m[0] }}">
            <input type="radio" name="methode" value="{{ $m[0] }}" {{ $loop->first ? 'checked' : '' }} style="accent-color:var(--gold);" onchange="selectMeth('{{ $m[0] }}')">
            <div>
              <div style="font-size:1rem;">{{ $m[1] }}</div>
              <div style="font-size:.78rem;font-weight:600;color:var(--ink);">{{ $m[2] }}</div>
              <div style="font-size:.68rem;color:var(--txt-muted);">{{ $m[3] }}</div>
            </div>
          </label>
          @endforeach
        </div>
      </div>

      <button type="submit" class="rl-btn" style="width:100%;justify-content:center;padding:13px;font-size:.9rem;">
        <i class="fas fa-lock"></i> Confirmer le paiement
      </button>
      <div style="text-align:center;font-size:.7rem;color:var(--txt-muted);margin-top:10px;">
        <i class="fas fa-shield-alt" style="color:var(--green);margin-right:4px;"></i>Paiement sécurisé via PayGate sandbox
      </div>
    </form>
  </div>
</div>

{{-- HISTORIQUE --}}
@if(isset($historique) && $historique->count() > 0)
<div class="rl-card" style="max-width:900px;margin:0 auto;">
  <div class="rl-card-header"><span class="rl-card-title">Historique des abonnements</span></div>
  <table class="rl-table">
    <thead><tr><th>Formule</th><th>Montant</th><th>Méthode</th><th>Date</th><th>Expiration</th><th>Statut</th></tr></thead>
    <tbody>
      @foreach($historique as $p)
      <tr>
        <td>{{ ucfirst($p->formule ?? 'mensuel') }}</td>
        <td>{{ number_format($p->montant,0,',',' ') }} F</td>
        <td>{{ $p->methode }}</td>
        <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d/m/Y') }}</td>
        <td>{{ $p->expiry_date ? \Carbon\Carbon::parse($p->expiry_date)->format('d/m/Y') : '—' }}</td>
        <td><span class="rl-badge rl-badge-green">Payé</span></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endif

@endsection

@section('scripts')
<script>
function ouvrirPaiement(id, prix, label) {
  document.getElementById('inputFormule').value = id;
  document.getElementById('inputMontant').value = prix;
  document.getElementById('modalSub').textContent = 'Formule ' + label;
  document.getElementById('recapLabel').textContent = 'Formule ' + label;
  document.getElementById('recapPrix').textContent = prix.toLocaleString('fr-FR') + ' FCFA';
  document.getElementById('modalPaiement').style.display = 'flex';
  selectMeth('mobile_money');
}
function fermerModal() {
  document.getElementById('modalPaiement').style.display = 'none';
}
function selectMeth(m) {
  ['mobile_money','carte'].forEach(x => {
    const el = document.getElementById('meth-'+x);
    if(el) el.style.borderColor = x===m ? 'var(--gold)' : 'var(--border)';
  });
}
document.getElementById('modalPaiement').addEventListener('click', function(e) {
  if(e.target === this) fermerModal();
});
</script>
@endsection