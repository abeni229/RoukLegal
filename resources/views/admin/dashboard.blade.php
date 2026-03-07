@extends('layouts.app')

@section('title', 'Dashboard Admin — RoukLegal')

@section('page-title')
  Tableau de bord <span>/ Admin</span>
@endsection

@section('content')
<div style="display:flex;flex-direction:column;gap:28px;">

  {{-- STAT CARDS --}}
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:20px;">

    <div class="rl-stat-card fade-up" style="--accent:var(--gold);animation-delay:.05s">
      <div class="rl-stat-header">
        <span class="rl-stat-label">Total Utilisateurs</span>
        <span>👥</span>
      </div>
      <div class="rl-stat-value">{{ $totalUsers }}</div>
      <div class="rl-stat-sub">Tous rôles confondus</div>
    </div>

    <div class="rl-stat-card fade-up" style="--accent:var(--blue);animation-delay:.1s">
      <div class="rl-stat-header">
        <span class="rl-stat-label">Clients</span>
        <span>🧑‍💼</span>
      </div>
      <div class="rl-stat-value">{{ $clients }}</div>
      <div class="rl-stat-sub">Comptes actifs</div>
    </div>

    <div class="rl-stat-card fade-up" style="--accent:var(--purple);animation-delay:.15s">
      <div class="rl-stat-header">
        <span class="rl-stat-label">Acteurs Juridiques</span>
        <span>⚖️</span>
      </div>
      <div class="rl-stat-value">{{ $acteurs }}</div>
      <div class="rl-stat-sub">Avocats, notaires…</div>
    </div>

    <div class="rl-stat-card fade-up" style="--accent:var(--green);animation-delay:.2s">
      <div class="rl-stat-header">
        <span class="rl-stat-label">Questions</span>
        <span>❓</span>
      </div>
      <div class="rl-stat-value">{{ $questions }}</div>
      <div class="rl-stat-sub">Total posées</div>
    </div>

    <div class="rl-stat-card fade-up" style="--accent:var(--orange);animation-delay:.25s">
      <div class="rl-stat-header">
        <span class="rl-stat-label">Réponses</span>
        <span>💬</span>
      </div>
      <div class="rl-stat-value">{{ $reponses }}</div>
      <div class="rl-stat-sub">Taux : <strong style="color:var(--green)">{{ $questions > 0 ? round(($reponses/$questions)*100) : 0 }}%</strong></div>
    </div>

    <div class="rl-stat-card fade-up" style="--accent:var(--red);animation-delay:.3s">
      <div class="rl-stat-header">
        <span class="rl-stat-label">Essais Actifs</span>
        <span>⏳</span>
      </div>
      <div class="rl-stat-value">{{ $trials }}</div>
      <div class="rl-stat-sub">Essais gratuits en cours</div>
    </div>

  </div>

  {{-- BOTTOM GRID --}}
  <div style="display:grid;grid-template-columns:1.6fr 1fr;gap:24px;">

    {{-- Revenus mensuels --}}
    <div class="rl-card fade-up" style="animation-delay:.35s">
      <div class="rl-card-header">
        <span class="rl-card-title">Revenus mensuels</span>
        <span class="rl-card-badge">6 derniers mois</span>
      </div>
      <div style="display:flex;flex-direction:column;gap:14px;">
        @php $maxTotal = $paymentsByMonth->max('total') ?: 1; @endphp
        @foreach($paymentsByMonth as $row)
        @php $pct = round(($row->total / $maxTotal) * 100); @endphp
        <div style="display:flex;align-items:center;gap:12px;">
          <span style="font-size:.78rem;color:var(--txt-muted);width:50px;text-align:right;flex-shrink:0;">
            {{ \Carbon\Carbon::createFromFormat('Y-m', $row->month)->format('M') }}
          </span>
          <div style="flex:1;background:var(--surface2);border-radius:20px;height:10px;overflow:hidden;">
            <div style="width:{{ $pct }}%;height:100%;border-radius:20px;background:linear-gradient(90deg,var(--gold),var(--gold-lt));transition:width 1s cubic-bezier(.22,1,.36,1);"></div>
          </div>
          <span style="font-size:.78rem;font-weight:600;color:var(--ink);width:80px;">{{ number_format($row->total,0,',',' ') }} F</span>
        </div>
        @endforeach
      </div>
    </div>

    {{-- Méthodes de paiement --}}
    <div class="rl-card fade-up" style="animation-delay:.4s">
      <div class="rl-card-header">
        <span class="rl-card-title">Méthodes de paiement</span>
        <span class="rl-card-badge">Répartition</span>
      </div>
      @php $colors = ['var(--gold)','var(--blue)','var(--green)','var(--red)','var(--purple)']; $i=0; @endphp
      <div style="display:flex;flex-direction:column;gap:14px;">
        @foreach($paymentsByMethod as $m)
        <div style="display:flex;align-items:center;justify-content:space-between;padding:13px 16px;background:var(--surface2);border-radius:10px;border:1px solid var(--border);">
          <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:10px;height:10px;border-radius:50%;background:{{ $colors[$i % count($colors)] }};"></div>
            <div>
              <div style="font-size:.85rem;font-weight:500;">{{ ucfirst($m->methode) }}</div>
              <div style="font-size:.72rem;color:var(--txt-muted);">{{ $m->count }} transaction(s)</div>
            </div>
          </div>
          <div style="font-size:.88rem;font-weight:700;">{{ number_format($m->total,0,',',' ') }} F</div>
        </div>
        @php $i++; @endphp
        @endforeach
      </div>
    </div>

  </div>
</div>
@endsection