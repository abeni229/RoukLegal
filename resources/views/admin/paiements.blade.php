@extends('layouts.app')

@section('title', 'Paiements — Admin RoukLegal')

@section('page-title')
  Admin <span>/ Paiements</span>
@endsection

@section('content')
@php
  $paiements = \App\Models\Paiement::with('client')
    ->orderBy('created_at','desc')
    ->get();

  $totalAbonnements = $paiements->whereNotNull('formule')->sum('montant');
  $totalRdv = \App\Models\PaiementRdv::where('statut','confirme')->sum('montant');
  $commission = \App\Models\RendezVous::whereIn('statut_paiement',['confirme_acteur','confirmé_acteur'])->sum('commission_admin');
@endphp

{{-- STATS --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:32px;">
  <div class="rl-stat-card" style="--accent:var(--gold);">
    <div class="rl-stat-header"><span class="rl-stat-label">Total abonnements</span><span>💳</span></div>
    <div class="rl-stat-value">{{ number_format($totalAbonnements,0,',',' ') }} F</div>
  </div>
  <div class="rl-stat-card" style="--accent:var(--blue);">
    <div class="rl-stat-header"><span class="rl-stat-label">Total RDV encaissés</span><span>📅</span></div>
    <div class="rl-stat-value">{{ number_format($totalRdv,0,',',' ') }} F</div>
  </div>
  <div class="rl-stat-card" style="--accent:var(--green);">
    <div class="rl-stat-header"><span class="rl-stat-label">Commissions admin (RDV)</span><span>💰</span></div>
    <div class="rl-stat-value">{{ number_format($commission,0,',',' ') }} F</div>
  </div>
</div>

{{-- ABONNEMENTS --}}
<div class="rl-card" style="margin-bottom:28px;">
  <div class="rl-card-header">
    <span class="rl-card-title">Paiements d'abonnements</span>
    <span class="rl-badge rl-badge-gold">{{ $paiements->whereNotNull('formule')->count() }}</span>
  </div>
  <table class="rl-table">
    <thead>
      <tr><th>Client</th><th>Formule</th><th>Montant</th><th>Méthode</th><th>Date</th><th>Expiration</th><th>Statut</th></tr>
    </thead>
    <tbody>
      @forelse($paiements->whereNotNull('formule') as $p)
      <tr>
        <td>
          <div style="font-weight:600;">{{ $p->client?->nom ?? '—' }}</div>
          <div style="font-size:.72rem;color:var(--txt-muted);">{{ $p->client?->email }}</div>
        </td>
        <td><span class="rl-badge rl-badge-gold">{{ ucfirst($p->formule) }}</span></td>
        <td style="font-weight:600;color:var(--gold);">{{ number_format($p->montant,0,',',' ') }} F</td>
        <td style="color:var(--txt-muted);">{{ ucfirst($p->methode) }}</td>
        <td style="color:var(--txt-muted);">{{ $p->created_at->format('d/m/Y') }}</td>
        <td>
          @if($p->expiry_date)
            @if($p->expiry_date >= now())
              <span class="rl-badge rl-badge-green">{{ \Carbon\Carbon::parse($p->expiry_date)->format('d/m/Y') }}</span>
            @else
              <span class="rl-badge" style="background:var(--red-dim);color:var(--red);">Expiré</span>
            @endif
          @else
            <span style="color:var(--txt-muted);">—</span>
          @endif
        </td>
        <td><span class="rl-badge rl-badge-green">Confirmé</span></td>
      </tr>
      @empty
      <tr><td colspan="7" style="text-align:center;color:var(--txt-muted);padding:24px;">Aucun paiement d'abonnement</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- PAIEMENTS RDV --}}
<div class="rl-card">
  <div class="rl-card-header">
    <span class="rl-card-title">Paiements de rendez-vous</span>
    <span class="rl-badge rl-badge-blue">{{ \App\Models\PaiementRdv::count() }}</span>
  </div>
  <table class="rl-table">
    <thead>
      <tr><th>Référence</th><th>Client</th><th>Montant</th><th>Méthode</th><th>Date</th><th>Statut</th></tr>
    </thead>
    <tbody>
      @forelse(\App\Models\PaiementRdv::with(['rdv.client'])->orderBy('created_at','desc')->get() as $p)
      <tr>
        <td style="font-family:monospace;font-size:.75rem;color:var(--txt-muted);">{{ $p->paygate_reference }}</td>
        <td>
          <div style="font-weight:600;">{{ $p->rdv?->client?->nom ?? '—' }}</div>
          <div style="font-size:.72rem;color:var(--txt-muted);">{{ $p->rdv?->client?->email }}</div>
        </td>
        <td style="font-weight:600;color:var(--gold);">{{ number_format($p->montant,0,',',' ') }} F</td>
        <td style="color:var(--txt-muted);">{{ ucfirst($p->methode) }}</td>
        <td style="color:var(--txt-muted);">{{ $p->created_at->format('d/m/Y H:i') }}</td>
        <td>
          @if($p->statut === 'confirme')
            <span class="rl-badge rl-badge-green">Confirmé</span>
          @elseif($p->statut === 'rembourse')
            <span class="rl-badge" style="background:var(--red-dim);color:var(--red);">Remboursé</span>
          @else
            <span class="rl-badge rl-badge-gold">{{ ucfirst($p->statut) }}</span>
          @endif
        </td>
      </tr>
      @empty
      <tr><td colspan="6" style="text-align:center;color:var(--txt-muted);padding:24px;">Aucun paiement RDV</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

@endsection