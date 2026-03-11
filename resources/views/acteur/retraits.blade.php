@extends('layouts.app')

@section('title', 'Mes retraits — RoukLegal')

@section('page-title')
  Mon compte <span>/ Retraits</span>
@endsection

@section('content')

{{-- SOLDE --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:32px;">
  <div class="rl-stat-card" style="--accent:var(--green);">
    <div class="rl-stat-header"><span class="rl-stat-label">Solde disponible</span><span>💰</span></div>
    <div class="rl-stat-value">{{ number_format($soldeDisponible,0,',',' ') }} F</div>
    <div class="rl-stat-sub">Retraits confirmés déduits</div>
  </div>
  <div class="rl-stat-card" style="--accent:var(--gold);">
    <div class="rl-stat-header"><span class="rl-stat-label">Total gagné</span><span>📈</span></div>
    <div class="rl-stat-value">{{ number_format($totalGagne,0,',',' ') }} F</div>
    <div class="rl-stat-sub">Commissions RDV confirmés</div>
  </div>
  <div class="rl-stat-card" style="--accent:var(--orange);">
    <div class="rl-stat-header"><span class="rl-stat-label">En attente</span><span>⏳</span></div>
    <div class="rl-stat-value">{{ number_format($enAttente,0,',',' ') }} F</div>
    <div class="rl-stat-sub">Demandes en cours de traitement</div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 360px;gap:24px;align-items:start;">

  {{-- HISTORIQUE --}}
  <div class="rl-card">
    <div class="rl-card-header">
      <span class="rl-card-title">Historique des demandes</span>
      <span class="rl-badge rl-badge-gold">{{ $demandes->total() }}</span>
    </div>
    @if($demandes->count() > 0)
    <table class="rl-table">
      <thead>
        <tr><th>Date</th><th>Montant</th><th>Méthode</th><th>Numéro</th><th>Statut</th><th>Note admin</th></tr>
      </thead>
      <tbody>
        @foreach($demandes as $d)
        <tr>
          <td style="color:var(--txt-muted);white-space:nowrap;">{{ $d->created_at->format('d/m/Y') }}</td>
          <td style="font-weight:700;color:var(--gold);">{{ number_format($d->montant,0,',',' ') }} F</td>
          <td>{{ ucfirst(str_replace('_',' ',$d->methode)) }}</td>
          <td style="font-family:monospace;font-size:.8rem;">{{ $d->numero_compte }}</td>
          <td>
            @if($d->statut === 'en_attente')
              <span class="rl-badge rl-badge-orange">⏳ En attente</span>
            @elseif($d->statut === 'traite')
              <span class="rl-badge rl-badge-green">✅ Traité</span>
            @else
              <span class="rl-badge rl-badge-red">❌ Refusé</span>
            @endif
          </td>
          <td style="font-size:.78rem;color:var(--txt-muted);">{{ $d->note_admin ?? '—' }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div style="margin-top:16px;">{{ $demandes->links() }}</div>
    @else
    <div style="text-align:center;padding:40px;color:var(--txt-muted);">
      <div style="font-size:2.5rem;margin-bottom:12px;">💸</div>
      <div>Aucune demande de retrait pour le moment.</div>
    </div>
    @endif
  </div>

  {{-- FORMULAIRE --}}
  <div style="display:flex;flex-direction:column;gap:20px;position:sticky;top:calc(var(--topbar-h) + 24px);">

    @if($soldeDisponible > 0)
    <div class="rl-card">
      <div class="rl-card-header"><span class="rl-card-title">Nouvelle demande</span></div>

      <form method="POST" action="{{ route('acteur.retraits.store') }}">
        @csrf

        <div class="rl-form-group">
          <label class="rl-label">Montant à retirer (FCFA) <span style="color:var(--red)">*</span></label>
          <input type="number" name="montant" class="rl-input"
            min="1000" max="{{ $soldeDisponible }}"
            placeholder="Ex: 8000"
            value="{{ old('montant') }}" required>
          <div style="font-size:.72rem;color:var(--txt-muted);margin-top:4px;">
            Maximum disponible : <strong>{{ number_format($soldeDisponible,0,',',' ') }} F</strong>
          </div>
        </div>

        <div class="rl-form-group">
          <label class="rl-label">Méthode de retrait <span style="color:var(--red)">*</span></label>
          <select name="methode" class="rl-select" required onchange="updateLabel(this.value)">
            <option value="">— Choisir —</option>
            <option value="mtn_money" {{ old('methode')==='mtn_money' ? 'selected' : '' }}>📱 MTN Mobile Money</option>
            <option value="moov_money" {{ old('methode')==='moov_money' ? 'selected' : '' }}>📱 Moov Money</option>
            <option value="virement" {{ old('methode')==='virement' ? 'selected' : '' }}>🏦 Virement bancaire</option>
          </select>
        </div>

        <div class="rl-form-group">
          <label class="rl-label" id="numLabel">Numéro / IBAN <span style="color:var(--red)">*</span></label>
          <input type="text" name="numero_compte" class="rl-input"
            id="numInput"
            placeholder="Ex: 06 12 34 56 78"
            value="{{ old('numero_compte') }}" required>
        </div>

        <button type="submit" class="rl-btn" style="width:100%;justify-content:center;">
          <i class="fas fa-paper-plane"></i> Envoyer la demande
        </button>
      </form>
    </div>
    @else
    <div class="rl-card" style="text-align:center;padding:32px;">
      <div style="font-size:2rem;margin-bottom:12px;">⚠️</div>
      <div style="font-weight:600;color:var(--txt);margin-bottom:6px;">Solde insuffisant</div>
      <div style="font-size:.82rem;color:var(--txt-muted);">Vous n'avez pas encore de fonds disponibles à retirer.</div>
    </div>
    @endif

    {{-- Info --}}
    <div class="rl-card" style="background:linear-gradient(135deg,#111820,#1a2535);border-color:rgba(201,168,76,.2);">
      <div style="font-family:'Playfair Display',serif;font-size:.9rem;color:var(--gold);margin-bottom:12px;">ℹ️ Informations</div>
      <div style="display:flex;flex-direction:column;gap:8px;font-size:.78rem;color:rgba(255,255,255,.6);">
        <div>• Délai de traitement : 24 à 72h ouvrées</div>
        <div>• Montant minimum : 1 000 FCFA</div>
        <div>• Votre part : 80% de chaque RDV confirmé</div>
        <div>• Les demandes en attente bloquent le solde</div>
      </div>
    </div>

  </div>
</div>

@endsection

@section('scripts')
<script>
function updateLabel(val) {
  const lbl = document.getElementById('numLabel');
  const inp = document.getElementById('numInput');
  if(val === 'virement') {
    lbl.innerHTML = 'IBAN / Numéro de compte <span style="color:var(--red)">*</span>';
    inp.placeholder = 'Ex: BJ66 BJ012 34567 89012 34567 890';
  } else {
    lbl.innerHTML = 'Numéro Mobile Money <span style="color:var(--red)">*</span>';
    inp.placeholder = 'Ex: 06 12 34 56 78';
  }
}
</script>
@endsection