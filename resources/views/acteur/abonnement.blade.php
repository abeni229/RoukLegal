@extends('layouts.app')

@section('title', 'Mon Abonnement — RoukLegal')

@section('page-title')
  Mon compte <span>/ Abonnement</span>
@endsection

@section('content')
<div style="max-width:600px;margin:0 auto;display:flex;flex-direction:column;gap:24px;">

  {{-- STATUT ACTUEL --}}
  <div class="rl-card" style="background:linear-gradient(135deg,#111820,#1a2535);border-color:rgba(201,168,76,.2);">
    <div style="display:flex;align-items:center;justify-content:space-between;gap:20px;flex-wrap:wrap;">
      <div>
        <div style="font-size:.72rem;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:1.5px;margin-bottom:6px;">Statut abonnement</div>
        @if($abonne)
          <div style="font-family:'Playfair Display',serif;font-size:1.3rem;font-weight:700;color:var(--green);">✅ Abonnement actif</div>
          @if($expiry)
          <div style="font-size:.82rem;color:rgba(255,255,255,.5);margin-top:4px;">
            Expire le <strong style="color:rgba(255,255,255,.8);">{{ \Carbon\Carbon::parse($expiry)->format('d/m/Y') }}</strong>
            — dans <strong style="color:var(--gold);">{{ now()->diffInDays($expiry) }} jours</strong>
          </div>
          @endif
        @else
          <div style="font-family:'Playfair Display',serif;font-size:1.3rem;font-weight:700;color:var(--red);">⚠️ Aucun abonnement actif</div>
          <div style="font-size:.82rem;color:rgba(255,255,255,.5);margin-top:4px;">Votre profil est masqué des clients</div>
        @endif
      </div>
      <div style="font-size:3rem;">⚖️</div>
    </div>
  </div>

  {{-- OFFRE --}}
  @if(!$abonne || now()->diffInDays($expiry) <= 15)
  <div class="rl-card" style="border:2px solid var(--gold);position:relative;overflow:hidden;">
    <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(to right,var(--gold),var(--gold-lt));"></div>

    <div style="text-align:center;margin-bottom:24px;">
      <div style="font-size:.7rem;letter-spacing:2px;text-transform:uppercase;color:var(--gold);font-weight:600;margin-bottom:8px;">Offre unique</div>
      <div style="font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:700;color:var(--ink);">Abonnement trimestriel</div>
      <div style="font-size:.88rem;color:var(--txt-muted);margin-top:4px;">Accès complet pendant 3 mois</div>
    </div>

    <div style="text-align:center;margin-bottom:28px;">
      <div style="font-family:'Playfair Display',serif;font-size:3rem;font-weight:700;color:var(--gold);line-height:1;">5 000</div>
      <div style="font-size:.88rem;color:var(--txt-muted);">FCFA / 3 mois</div>
    </div>

    <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:28px;">
      @foreach([
        'Profil visible par tous les clients',
        'Réception de questions illimitées',
        'Prise de rendez-vous activée',
        'Messagerie avec les clients',
        'Publication d\'articles',
        'Commissions sur les RDV (80%)',
      ] as $avantage)
      <div style="display:flex;align-items:center;gap:10px;font-size:.85rem;color:var(--txt);">
        <span style="color:var(--green);font-size:.9rem;">✓</span> {{ $avantage }}
      </div>
      @endforeach
    </div>

    <button type="button" onclick="ouvrirModal()" class="rl-btn" style="width:100%;justify-content:center;padding:14px;font-size:.95rem;">
      <i class="fas fa-lock-open"></i>
      {{ $abonne ? 'Renouveler mon abonnement' : 'S\'abonner maintenant — 5 000 FCFA/3 mois' }}
    </button>

    <div style="text-align:center;font-size:.72rem;color:var(--txt-muted);margin-top:12px;">
      Paiement simulé (sandbox) • Renouvellement manuel
    </div>
  </div>
  @else
  <div class="rl-card" style="text-align:center;padding:32px;">
    <div style="font-size:2.5rem;margin-bottom:12px;">🎉</div>
    <div style="font-family:'Playfair Display',serif;font-size:1.1rem;color:var(--ink);margin-bottom:8px;">Votre abonnement est actif</div>
    <div style="font-size:.85rem;color:var(--txt-muted);">Vous pouvez renouveler à partir de 15 jours avant l'expiration.</div>
  </div>
  @endif

  {{-- HISTORIQUE --}}
  @if($historique->count() > 0)
  <div class="rl-card">
    <div class="rl-card-header">
      <span class="rl-card-title">Historique des paiements</span>
      <span class="rl-badge rl-badge-gold">{{ $historique->count() }}</span>
    </div>
    <table class="rl-table">
      <thead><tr><th>Date</th><th>Montant</th><th>Période</th><th>Expiration</th></tr></thead>
      <tbody>
        @foreach($historique as $p)
        <tr>
          <td style="color:var(--txt-muted);">{{ $p->created_at->format('d/m/Y') }}</td>
          <td style="font-weight:600;color:var(--gold);">{{ number_format($p->montant,0,',',' ') }} FCFA</td>
          <td><span class="rl-badge rl-badge-blue">3 mois</span></td>
          <td>
            @if($p->expiry_date)
              @if(\Carbon\Carbon::parse($p->expiry_date)->isFuture())
                <span class="rl-badge rl-badge-green">{{ \Carbon\Carbon::parse($p->expiry_date)->format('d/m/Y') }}</span>
              @else
                <span class="rl-badge rl-badge-red">Expiré</span>
              @endif
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif

</div>

{{-- MODAL PAIEMENT SANDBOX --}}
<div id="modalPaiement" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:1000;align-items:center;justify-content:center;">
  <div style="background:var(--surface);border-radius:20px;padding:40px;width:100%;max-width:460px;margin:24px;position:relative;">
    <button onclick="fermerModal()" style="position:absolute;top:16px;right:16px;background:none;border:none;color:var(--txt-muted);cursor:pointer;font-size:1.1rem;"><i class="fas fa-times"></i></button>

    <div style="font-family:'Playfair Display',serif;font-size:1.3rem;font-weight:700;color:var(--ink);margin-bottom:4px;">Paiement sandbox</div>
    <div style="font-size:.82rem;color:var(--txt-muted);margin-bottom:24px;">Abonnement trimestriel — RoukLegal</div>

    {{-- Récap --}}
    <div style="padding:14px 16px;background:var(--surface2);border:1px solid var(--border);border-radius:10px;margin-bottom:20px;">
      <div style="display:flex;justify-content:space-between;font-size:.85rem;margin-bottom:8px;">
        <span style="color:var(--txt-muted);">Formule</span>
        <span style="font-weight:600;">Trimestriel (3 mois)</span>
      </div>
      <div style="display:flex;justify-content:space-between;font-size:.85rem;padding-top:8px;border-top:1px solid var(--border);">
        <span style="color:var(--txt-muted);">Total</span>
        <span style="color:var(--gold);font-weight:700;font-size:.95rem;">5 000 FCFA</span>
      </div>
    </div>

    {{-- Méthode --}}
    <div style="margin-bottom:20px;">
      <div style="font-size:.78rem;font-weight:600;color:var(--txt-muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:10px;">Méthode de paiement</div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
        @foreach([['mobile_money','📱','Mobile Money','MTN / Moov'],['carte','💳','Carte bancaire','Visa / Mastercard']] as $m)
        <label style="display:flex;align-items:center;gap:10px;padding:12px;background:var(--surface2);border:2px solid var(--border);border-radius:10px;cursor:pointer;transition:border-color .15s;" id="meth-{{ $m[0] }}">
          <input type="radio" name="methode_display" value="{{ $m[0] }}" {{ $loop->first ? 'checked' : '' }} style="accent-color:var(--gold);" onchange="selectMeth('{{ $m[0] }}')">
          <div>
            <div style="font-size:1rem;">{{ $m[1] }}</div>
            <div style="font-size:.78rem;font-weight:600;color:var(--ink);">{{ $m[2] }}</div>
            <div style="font-size:.68rem;color:var(--txt-muted);">{{ $m[3] }}</div>
          </div>
        </label>
        @endforeach
      </div>
    </div>

    {{-- Info sandbox --}}
    <div style="padding:12px 14px;background:var(--gold-dim);border:1px solid rgba(201,168,76,.3);border-radius:8px;font-size:.75rem;color:var(--gold);margin-bottom:20px;">
      <strong>Mode sandbox :</strong> aucun vrai paiement n'est effectué
    </div>

    <form method="POST" action="{{ route('acteur.abonnement.payer') }}">
      @csrf
      <input type="hidden" name="methode" id="methodeInput" value="mobile_money">
      <button type="submit" class="rl-btn" style="width:100%;justify-content:center;padding:13px;font-size:.9rem;">
        <i class="fas fa-lock"></i> Confirmer le paiement — 5 000 FCFA
      </button>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
function ouvrirModal() {
  document.getElementById('modalPaiement').style.display = 'flex';
  selectMeth('mobile_money');
}
function fermerModal() {
  document.getElementById('modalPaiement').style.display = 'none';
}
function selectMeth(m) {
  document.getElementById('methodeInput').value = m;
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