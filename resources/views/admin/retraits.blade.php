@extends('layouts.app')

@section('title', 'Demandes de retrait — Admin RoukLegal')

@section('page-title')
  Admin <span>/ Retraits</span>
@endsection

@section('content')

{{-- STATS --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:32px;">
  <div class="rl-stat-card" style="--accent:var(--orange);">
    <div class="rl-stat-header"><span class="rl-stat-label">En attente</span><span>⏳</span></div>
    <div class="rl-stat-value">{{ $stats['en_attente'] }}</div>
  </div>
  <div class="rl-stat-card" style="--accent:var(--gold);">
    <div class="rl-stat-header"><span class="rl-stat-label">Montant à verser</span><span>💸</span></div>
    <div class="rl-stat-value">{{ number_format($stats['montant_attente'],0,',',' ') }} F</div>
  </div>
  <div class="rl-stat-card" style="--accent:var(--green);">
    <div class="rl-stat-header"><span class="rl-stat-label">Traités</span><span>✅</span></div>
    <div class="rl-stat-value">{{ $stats['traites'] }}</div>
  </div>
  <div class="rl-stat-card" style="--accent:var(--green);">
    <div class="rl-stat-header"><span class="rl-stat-label">Total versé</span><span>💰</span></div>
    <div class="rl-stat-value">{{ number_format($stats['montant_traite'],0,',',' ') }} F</div>
  </div>
</div>

@if($stats['en_attente'] > 0)
<div class="rl-alert rl-alert-warning" style="margin-bottom:24px;">
  <i class="fas fa-exclamation-triangle"></i>
  <strong>{{ $stats['en_attente'] }} demande(s)</strong> en attente de traitement pour un total de <strong>{{ number_format($stats['montant_attente'],0,',',' ') }} FCFA</strong>
</div>
@endif

<div class="rl-card">
  <div class="rl-card-header">
    <span class="rl-card-title">Toutes les demandes</span>
    <span class="rl-badge rl-badge-gold">{{ $demandes->total() }}</span>
  </div>
  <table class="rl-table">
    <thead>
      <tr><th>Date</th><th>Acteur</th><th>Montant</th><th>Méthode</th><th>Numéro</th><th>Statut</th><th>Actions</th></tr>
    </thead>
    <tbody>
      @forelse($demandes as $d)
      <tr>
        <td style="color:var(--txt-muted);white-space:nowrap;">{{ $d->created_at->format('d/m/Y H:i') }}</td>
        <td>
          <div style="font-weight:600;">{{ $d->acteur?->nom ?? '—' }}</div>
          <div style="font-size:.72rem;color:var(--txt-muted);">{{ $d->acteur?->email }}</div>
        </td>
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
        <td>
          @if($d->statut === 'en_attente')
          <div style="display:flex;flex-direction:column;gap:6px;">
            <form method="POST" action="{{ route('admin.retraits.traiter', $d->id) }}">
              @csrf
              <button type="submit" class="rl-btn" style="padding:6px 12px;font-size:.72rem;white-space:nowrap;background:var(--green);">
                <i class="fas fa-check"></i> Marquer traité
              </button>
            </form>
            <button onclick="ouvrirRefus({{ $d->id }})"
              style="display:flex;align-items:center;gap:5px;padding:6px 12px;background:var(--red-dim);border:1px solid rgba(231,76,60,.3);border-radius:8px;color:var(--red);font-size:.72rem;cursor:pointer;white-space:nowrap;">
              <i class="fas fa-times"></i> Refuser
            </button>
          </div>
          @else
            @if($d->note_admin)
            <div style="font-size:.72rem;color:var(--txt-muted);font-style:italic;">{{ $d->note_admin }}</div>
            @else
            <span style="color:var(--txt-muted);">—</span>
            @endif
          @endif
        </td>
      </tr>
      @empty
      <tr><td colspan="7" style="text-align:center;color:var(--txt-muted);padding:32px;">Aucune demande de retrait</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="margin-top:16px;">{{ $demandes->links() }}</div>
</div>

{{-- MODAL REFUS --}}
<div id="modalRefus" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:1000;align-items:center;justify-content:center;">
  <div style="background:var(--surface);border-radius:16px;padding:32px;width:100%;max-width:420px;margin:24px;">
    <div style="font-family:'Playfair Display',serif;font-size:1.1rem;color:var(--ink);margin-bottom:16px;">Motif du refus</div>
    <form method="POST" id="formRefus">
      @csrf
      <div class="rl-form-group">
        <label class="rl-label">Note pour l'acteur</label>
        <textarea name="note_admin" class="rl-textarea" placeholder="Ex: Numéro incorrect, solde insuffisant…" rows="3"></textarea>
      </div>
      <div style="display:flex;gap:10px;">
        <button type="submit" style="flex:1;padding:10px;background:var(--red);color:white;border:none;border-radius:8px;cursor:pointer;font-family:'DM Sans',sans-serif;font-weight:600;">
          Confirmer le refus
        </button>
        <button type="button" onclick="fermerRefus()" style="padding:10px 16px;background:transparent;border:1px solid var(--border);border-radius:8px;cursor:pointer;color:var(--txt-muted);">
          Annuler
        </button>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
function ouvrirRefus(id) {
  document.getElementById('formRefus').action = '/admin/retraits/' + id + '/refuser';
  document.getElementById('modalRefus').style.display = 'flex';
}
function fermerRefus() {
  document.getElementById('modalRefus').style.display = 'none';
}
document.getElementById('modalRefus').addEventListener('click', function(e) {
  if(e.target === this) fermerRefus();
});
</script>
@endsection