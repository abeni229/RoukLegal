@extends('layouts.app')

@section('title', 'Commissions — Admin RoukLegal')

@section('page-title')
  Admin <span>/ Commissions</span>
@endsection

@section('content')
@php
  $rdvs = \App\Models\RendezVous::with(['client','acteur'])
    ->whereIn('statut_paiement',['confirme_acteur','confirmé_acteur'])
    ->orderBy('created_at','desc')
    ->get();

  $totalAdmin   = $rdvs->sum('commission_admin');
  $totalActeurs = $rdvs->sum('commission_acteur');
  $totalBrut    = $rdvs->sum('montant');

  // Par acteur
  $parActeur = $rdvs->groupBy('acteurjuridique_id')->map(fn($g) => [
    'nom'        => $g->first()->acteur?->nom ?? '—',
    'count'      => $g->count(),
    'commission' => $g->sum('commission_acteur'),
  ])->sortByDesc('commission');
@endphp

{{-- STATS --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:32px;">
  <div class="rl-stat-card" style="--accent:var(--gold);">
    <div class="rl-stat-header"><span class="rl-stat-label">Total brut RDV</span><span>💵</span></div>
    <div class="rl-stat-value">{{ number_format($totalBrut,0,',',' ') }} F</div>
  </div>
  <div class="rl-stat-card" style="--accent:var(--green);">
    <div class="rl-stat-header"><span class="rl-stat-label">Commission admin (20%)</span><span>🏛️</span></div>
    <div class="rl-stat-value">{{ number_format($totalAdmin,0,',',' ') }} F</div>
  </div>
  <div class="rl-stat-card" style="--accent:var(--blue);">
    <div class="rl-stat-header"><span class="rl-stat-label">Reversé aux acteurs (80%)</span><span>⚖️</span></div>
    <div class="rl-stat-value">{{ number_format($totalActeurs,0,',',' ') }} F</div>
  </div>
</div>

{{-- PAR ACTEUR --}}
<div class="rl-card" style="margin-bottom:28px;">
  <div class="rl-card-header">
    <span class="rl-card-title">Commissions par acteur</span>
    <span class="rl-badge rl-badge-gold">{{ $parActeur->count() }} acteur(s)</span>
  </div>
  <table class="rl-table">
    <thead>
      <tr><th>Acteur</th><th>RDV confirmés</th><th>À reverser (80%)</th></tr>
    </thead>
    <tbody>
      @forelse($parActeur as $a)
      <tr>
        <td><strong>{{ $a['nom'] }}</strong></td>
        <td><span class="rl-badge rl-badge-blue">{{ $a['count'] }} RDV</span></td>
        <td style="font-weight:700;color:var(--gold);">{{ number_format($a['commission'],0,',',' ') }} F</td>
      </tr>
      @empty
      <tr><td colspan="3" style="text-align:center;color:var(--txt-muted);padding:24px;">Aucune commission</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- DÉTAIL --}}
<div class="rl-card">
  <div class="rl-card-header">
    <span class="rl-card-title">Détail des RDV confirmés</span>
    <span class="rl-badge rl-badge-green">{{ $rdvs->count() }}</span>
  </div>
  <table class="rl-table">
    <thead>
      <tr><th>Date</th><th>Client</th><th>Acteur</th><th>Sujet</th><th>Montant</th><th>Admin (20%)</th><th>Acteur (80%)</th></tr>
    </thead>
    <tbody>
      @forelse($rdvs as $r)
      <tr>
        <td style="color:var(--txt-muted);white-space:nowrap;">{{ \Carbon\Carbon::parse($r->date_heure)->format('d/m/Y H:i') }}</td>
        <td>{{ $r->client?->nom ?? '—' }}</td>
        <td><span class="rl-badge rl-badge-gold">{{ $r->acteur?->nom ?? '—' }}</span></td>
        <td style="color:var(--txt-muted);font-size:.8rem;">{{ Str::limit($r->sujet,40) }}</td>
        <td style="font-weight:600;">{{ number_format($r->montant,0,',',' ') }} F</td>
        <td style="color:var(--green);font-weight:600;">{{ number_format($r->commission_admin,0,',',' ') }} F</td>
        <td style="color:var(--blue);font-weight:600;">{{ number_format($r->commission_acteur,0,',',' ') }} F</td>
      </tr>
      @empty
      <tr><td colspan="7" style="text-align:center;color:var(--txt-muted);padding:24px;">Aucun RDV confirmé</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

@endsection