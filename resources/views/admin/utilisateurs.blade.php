@extends('layouts.app')

@section('title', 'Utilisateurs — Admin RoukLegal')

@section('page-title')
  Admin <span>/ Utilisateurs</span>
@endsection

@section('content')
@php
  $clients  = \App\Models\User::where('role','client')->orderBy('created_at','desc')->get();
  $acteurs  = \App\Models\User::where('role','acteur_juridique')->orderBy('created_at','desc')->get();
  $essais   = \App\Models\User::where('role','client')->whereNotNull('trial_end')->where('trial_end','>=',now())->get();
  $expires  = \App\Models\User::where('role','client')->whereNotNull('trial_end')->where('trial_end','<',now())->whereDoesntHave('paiements', fn($q) => $q->whereNotNull('expiry_date')->where('expiry_date','>=',now()))->get();
@endphp

{{-- STATS --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:32px;">
  @foreach([
    ['👥','Total clients',$clients->count(),'var(--gold)'],
    ['⚖️','Acteurs juridiques',$acteurs->count(),'var(--blue)'],
    ['⏳','En essai gratuit',$essais->count(),'var(--orange)'],
    ['⚠️','Essai expiré',$expires->count(),'var(--red)'],
  ] as $s)
  <div class="rl-stat-card" style="--accent:{{ $s[3] }};">
    <div class="rl-stat-header"><span class="rl-stat-label">{{ $s[1] }}</span><span>{{ $s[0] }}</span></div>
    <div class="rl-stat-value">{{ $s[2] }}</div>
  </div>
  @endforeach
</div>

{{-- ONGLETS --}}
<div style="display:flex;gap:8px;margin-bottom:24px;" id="tabs">
  @foreach([['clients','👤 Clients'],['acteurs','⚖️ Acteurs'],['essais','⏳ Essais actifs'],['expires','⚠️ Essais expirés']] as $t)
  <button onclick="showTab('{{ $t[0] }}')" id="tab-{{ $t[0] }}"
    style="padding:8px 18px;border-radius:8px;border:1px solid var(--border);font-family:'DM Sans',sans-serif;font-size:.8rem;cursor:pointer;transition:all .15s;
    background:{{ $loop->first ? 'var(--gold-dim)' : 'transparent' }};
    color:{{ $loop->first ? 'var(--gold)' : 'var(--txt-muted)' }};
    border-color:{{ $loop->first ? 'var(--gold)' : 'var(--border)' }};">
    {{ $t[1] }}
  </button>
  @endforeach
</div>

{{-- CLIENTS --}}
<div id="panel-clients">
  <div class="rl-card">
    <div class="rl-card-header">
      <span class="rl-card-title">Liste des clients</span>
      <span class="rl-badge rl-badge-gold">{{ $clients->count() }}</span>
    </div>
    <table class="rl-table">
      <thead><tr><th>Nom</th><th>Email</th><th>Inscription</th><th>Abonnement</th><th>Essai</th></tr></thead>
      <tbody>
        @forelse($clients as $u)
        <tr>
          <td><strong>{{ $u->nom }}</strong></td>
          <td style="color:var(--txt-muted);">{{ $u->email }}</td>
          <td style="color:var(--txt-muted);">{{ $u->created_at->format('d/m/Y') }}</td>
          <td>
            @php
              $abonne = $u->paiements()->whereNotNull('expiry_date')->where('expiry_date','>=',now())->exists();
            @endphp
            @if($abonne)
              <span class="rl-badge rl-badge-green">Abonné</span>
            @else
              <span class="rl-badge" style="background:var(--surface2);color:var(--txt-muted);">Aucun</span>
            @endif
          </td>
          <td>
            @if($u->trial_end)
              @if($u->trial_end >= now())
                <span class="rl-badge rl-badge-gold">{{ now()->diffInDays($u->trial_end) }}j restants</span>
              @else
                <span class="rl-badge" style="background:var(--red-dim);color:var(--red);">Expiré</span>
              @endif
            @else
              <span style="color:var(--txt-muted);font-size:.75rem;">—</span>
            @endif
          </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;color:var(--txt-muted);padding:24px;">Aucun client</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- ACTEURS --}}
<div id="panel-acteurs" style="display:none;">
  <div class="rl-card">
    <div class="rl-card-header">
      <span class="rl-card-title">Acteurs juridiques</span>
      <span class="rl-badge rl-badge-blue">{{ $acteurs->count() }}</span>
    </div>
    <table class="rl-table">
      <thead><tr><th>Nom</th><th>Email</th><th>Profession</th><th>Inscription</th><th>RDV</th></tr></thead>
      <tbody>
        @forelse($acteurs as $u)
        <tr>
          <td><strong>{{ $u->nom }}</strong></td>
          <td style="color:var(--txt-muted);">{{ $u->email }}</td>
          <td>
            <span class="rl-badge rl-badge-gold">{{ $u->profession?->nom ?? $u->profession_libre ?? 'Non défini' }}</span>
          </td>
          <td style="color:var(--txt-muted);">{{ $u->created_at->format('d/m/Y') }}</td>
          <td style="color:var(--txt-muted);">{{ $u->rendezVous()->count() }} RDV</td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;color:var(--txt-muted);padding:24px;">Aucun acteur juridique</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- ESSAIS ACTIFS --}}
<div id="panel-essais" style="display:none;">
  <div class="rl-card">
    <div class="rl-card-header">
      <span class="rl-card-title">Clients en essai gratuit</span>
      <span class="rl-badge rl-badge-gold">{{ $essais->count() }}</span>
    </div>
    <table class="rl-table">
      <thead><tr><th>Nom</th><th>Email</th><th>Fin d'essai</th><th>Jours restants</th></tr></thead>
      <tbody>
        @forelse($essais as $u)
        <tr>
          <td><strong>{{ $u->nom }}</strong></td>
          <td style="color:var(--txt-muted);">{{ $u->email }}</td>
          <td>{{ \Carbon\Carbon::parse($u->trial_end)->format('d/m/Y H:i') }}</td>
          <td><span class="rl-badge rl-badge-gold">{{ now()->diffInDays($u->trial_end) }} jours</span></td>
        </tr>
        @empty
        <tr><td colspan="4" style="text-align:center;color:var(--txt-muted);padding:24px;">Aucun essai en cours</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- ESSAIS EXPIRÉS --}}
<div id="panel-expires" style="display:none;">
  <div class="rl-card">
    <div class="rl-card-header">
      <span class="rl-card-title">Essais expirés sans abonnement</span>
      <span class="rl-badge" style="background:var(--red-dim);color:var(--red);">{{ $expires->count() }}</span>
    </div>
    <table class="rl-table">
      <thead><tr><th>Nom</th><th>Email</th><th>Essai expiré le</th><th>Inscription</th></tr></thead>
      <tbody>
        @forelse($expires as $u)
        <tr>
          <td><strong>{{ $u->nom }}</strong></td>
          <td style="color:var(--txt-muted);">{{ $u->email }}</td>
          <td style="color:var(--red);">{{ \Carbon\Carbon::parse($u->trial_end)->format('d/m/Y') }}</td>
          <td style="color:var(--txt-muted);">{{ $u->created_at->format('d/m/Y') }}</td>
        </tr>
        @empty
        <tr><td colspan="4" style="text-align:center;color:var(--txt-muted);padding:24px;">Aucun essai expiré</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection

@section('scripts')
<script>
function showTab(name) {
  ['clients','acteurs','essais','expires'].forEach(t => {
    document.getElementById('panel-'+t).style.display = t===name ? 'block' : 'none';
    const btn = document.getElementById('tab-'+t);
    btn.style.background    = t===name ? 'var(--gold-dim)' : 'transparent';
    btn.style.color         = t===name ? 'var(--gold)' : 'var(--txt-muted)';
    btn.style.borderColor   = t===name ? 'var(--gold)' : 'var(--border)';
  });
}
</script>
@endsection