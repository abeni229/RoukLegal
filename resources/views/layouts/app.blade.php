<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<title>@yield('title', 'RoukLegal')</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --ink:         #0d1117;
    --sidebar:     #111820;
    --gold:        #c9a84c;
    --gold-lt:     #e8c87a;
    --gold-dim:    rgba(201,168,76,.15);
    --surface:     #ffffff;
    --surface2:    #f5f6f8;
    --border:      #e4e6eb;
    --txt:         #2c3140;
    --txt-muted:   #7a8099;
    --green:       #27ae60;
    --green-dim:   rgba(39,174,96,.12);
    --orange:      #e67e22;
    --orange-dim:  rgba(230,126,34,.12);
    --red:         #e74c3c;
    --red-dim:     rgba(231,76,60,.12);
    --blue:        #2980b9;
    --blue-dim:    rgba(41,128,185,.12);
    --purple:      #8e44ad;
    --radius:      12px;
    --shadow:      0 4px 24px rgba(0,0,0,.07);
    --sidebar-w:   260px;
    --topbar-h:    68px;
  }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--surface2);
    color: var(--txt);
    display: flex;
    min-height: 100vh;
  }

  /* ── SIDEBAR ── */
  .rl-sidebar {
    width: var(--sidebar-w);
    background: var(--sidebar);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    position: fixed;
    left: 0; top: 0; bottom: 0;
    z-index: 100;
    border-right: 1px solid rgba(255,255,255,.04);
    overflow-y: auto;
  }

  .rl-sidebar-logo {
    padding: 28px 24px 20px;
    border-bottom: 1px solid rgba(255,255,255,.06);
    flex-shrink: 0;
  }
  .rl-sidebar-logo .wordmark {
    font-family: 'Playfair Display', serif;
    font-size: 1.45rem;
    font-weight: 700;
    color: var(--gold);
    text-decoration: none;
    display: block;
  }
  .rl-sidebar-logo .tagline {
    font-size: .72rem;
    color: rgba(255,255,255,.35);
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-top: 3px;
  }

  /* Mini profil (acteur uniquement) */
  .sidebar-profile {
    margin: 12px;
    border-radius: 10px;
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.07);
    padding: 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
  }
  .profile-avatar {
    width: 56px; height: 56px;
    border-radius: 50%;
    background: var(--gold-dim);
    border: 2px solid var(--gold);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Playfair Display', serif;
    font-size: 1.3rem; font-weight: 700;
    color: var(--gold);
    overflow: hidden;
  }
  .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
  .profile-name { font-size: .88rem; font-weight: 600; color: rgba(255,255,255,.85); text-align: center; }
  .profile-profession { font-size: .72rem; color: var(--gold); background: var(--gold-dim); padding: 2px 10px; border-radius: 20px; }
  .profile-edit { font-size: .72rem; color: rgba(255,255,255,.3); text-decoration: none; }
  .profile-edit:hover { color: var(--gold-lt); }

  .rl-sidebar-section {
    font-size: .65rem;
    letter-spacing: 1.8px;
    text-transform: uppercase;
    color: rgba(255,255,255,.25);
    padding: 20px 24px 8px;
    flex-shrink: 0;
  }

  .rl-sidebar nav { flex: 1; padding: 4px 12px; }

  .rl-nav-item {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 10px 14px;
    border-radius: 8px;
    color: rgba(255,255,255,.55);
    text-decoration: none;
    font-size: .88rem;
    font-weight: 400;
    transition: background .18s, color .18s;
    margin-bottom: 2px;
  }
  .rl-nav-item:hover { background: rgba(255,255,255,.06); color: rgba(255,255,255,.85); }
  .rl-nav-item.active { background: var(--gold-dim); color: var(--gold-lt); font-weight: 500; }
  .rl-nav-item i { width: 18px; text-align: center; flex-shrink: 0; font-size: .9rem; }
  .rl-nav-badge {
    margin-left: auto;
    background: var(--red);
    color: white;
    font-size: .68rem;
    font-weight: 700;
    padding: 1px 7px;
    border-radius: 20px;
    min-width: 20px;
    text-align: center;
  }
  .rl-nav-badge.gold { background: var(--gold); color: var(--ink); }

  /* Footer sidebar */
  .rl-sidebar-footer {
    padding: 16px 20px;
    border-top: 1px solid rgba(255,255,255,.06);
    flex-shrink: 0;
  }
  .rl-sidebar-footer .user-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
  }
  .rl-sidebar-footer .avatar {
    width: 34px; height: 34px;
    border-radius: 50%;
    background: var(--gold-dim);
    border: 1.5px solid var(--gold);
    display: flex; align-items: center; justify-content: center;
    font-size: .8rem; font-weight: 700;
    color: var(--gold);
    overflow: hidden;
    flex-shrink: 0;
  }
  .rl-sidebar-footer .avatar img { width: 100%; height: 100%; object-fit: cover; }
  .rl-sidebar-footer .user-name { font-size: .82rem; color: rgba(255,255,255,.8); font-weight: 500; }
  .rl-sidebar-footer .user-role { font-size: .7rem; color: rgba(255,255,255,.3); }
  .rl-logout-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    width: 100%;
    padding: 8px 10px;
    border-radius: 7px;
    background: transparent;
    border: 1px solid rgba(231,76,60,.25);
    color: rgba(231,76,60,.7);
    font-family: 'DM Sans', sans-serif;
    font-size: .8rem;
    font-weight: 500;
    cursor: pointer;
    transition: background .18s, color .18s, border-color .18s;
  }
  .rl-logout-btn:hover { background: rgba(231,76,60,.12); color: var(--red); border-color: rgba(231,76,60,.5); }

  /* ── MAIN ── */
  .rl-main {
    margin-left: var(--sidebar-w);
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }

  /* ── TOPBAR ── */
  .rl-topbar {
    height: var(--topbar-h);
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 32px;
    position: sticky; top: 0; z-index: 50;
    flex-shrink: 0;
  }
  .rl-topbar .page-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem;
    color: var(--ink);
  }
  .rl-topbar .page-title span { color: var(--gold); }
  .rl-topbar-right { display: flex; align-items: center; gap: 12px; }
  .rl-date-pill {
    font-size: .78rem;
    color: var(--txt-muted);
    background: var(--surface2);
    padding: 6px 14px;
    border-radius: 20px;
    border: 1px solid var(--border);
  }
  .rl-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--gold);
    color: var(--ink);
    font-family: 'DM Sans', sans-serif;
    font-size: .82rem;
    font-weight: 600;
    padding: 8px 18px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: background .18s, transform .15s;
  }
  .rl-btn:hover { background: var(--gold-lt); transform: translateY(-1px); color: var(--ink); }
  .rl-btn-outline {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: transparent;
    color: var(--gold);
    font-family: 'DM Sans', sans-serif;
    font-size: .82rem;
    font-weight: 600;
    padding: 8px 18px;
    border-radius: 8px;
    border: 1.5px solid var(--gold);
    cursor: pointer;
    text-decoration: none;
    transition: background .18s;
  }
  .rl-btn-outline:hover { background: var(--gold-dim); color: var(--gold); }

  /* ── CONTENT ── */
  .rl-content { padding: 32px; flex: 1; }

  /* ── CARDS ── */
  .rl-card {
    background: var(--surface);
    border-radius: var(--radius);
    padding: 24px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
  }
  .rl-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
  }
  .rl-card-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.05rem;
    color: var(--ink);
  }
  .rl-card-badge {
    font-size: .72rem;
    color: var(--gold);
    background: var(--gold-dim);
    padding: 3px 10px;
    border-radius: 20px;
    font-weight: 600;
  }
  .rl-card-link { font-size: .78rem; color: var(--gold); font-weight: 600; text-decoration: none; }
  .rl-card-link:hover { text-decoration: underline; }

  /* ── STAT CARD ── */
  .rl-stat-card {
    background: var(--surface);
    border-radius: var(--radius);
    padding: 22px 24px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    position: relative;
    overflow: hidden;
    transition: transform .2s, box-shadow .2s;
  }
  .rl-stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 32px rgba(0,0,0,.1); }
  .rl-stat-card::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: var(--accent, var(--gold));
    border-radius: var(--radius) var(--radius) 0 0;
  }
  .rl-stat-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
  .rl-stat-label { font-size: .75rem; color: var(--txt-muted); text-transform: uppercase; letter-spacing: .8px; font-weight: 500; }
  .rl-stat-value { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: var(--ink); line-height: 1; }
  .rl-stat-sub { font-size: .75rem; color: var(--txt-muted); margin-top: 6px; }

  /* ── ALERTS ── */
  .rl-alert {
    padding: 14px 18px;
    border-radius: 10px;
    font-size: .88rem;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .rl-alert-success { background: var(--green-dim); color: var(--green); border: 1px solid rgba(39,174,96,.25); }
  .rl-alert-error   { background: var(--red-dim);   color: var(--red);   border: 1px solid rgba(231,76,60,.25); }
  .rl-alert-warning { background: var(--orange-dim);color: var(--orange);border: 1px solid rgba(230,126,34,.25); }
  .rl-alert-info    { background: var(--blue-dim);  color: var(--blue);  border: 1px solid rgba(41,128,185,.25); }

  /* ── TABLE ── */
  .rl-table { width: 100%; border-collapse: collapse; }
  .rl-table thead th {
    text-align: left;
    font-size: .72rem;
    text-transform: uppercase;
    letter-spacing: .8px;
    color: var(--txt-muted);
    padding: 10px 14px;
    border-bottom: 1px solid var(--border);
  }
  .rl-table tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
  .rl-table tbody tr:last-child { border-bottom: none; }
  .rl-table tbody tr:hover { background: var(--surface2); }
  .rl-table tbody td { padding: 13px 14px; font-size: .84rem; color: var(--txt); }

  /* ── BADGES ── */
  .rl-badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: .72rem; font-weight: 600; }
  .rl-badge-gold    { background: var(--gold-dim);   color: var(--gold); }
  .rl-badge-green   { background: var(--green-dim);  color: var(--green); }
  .rl-badge-red     { background: var(--red-dim);    color: var(--red); }
  .rl-badge-orange  { background: var(--orange-dim); color: var(--orange); }
  .rl-badge-blue    { background: var(--blue-dim);   color: var(--blue); }
  .rl-badge-purple  { background: rgba(142,68,173,.12); color: var(--purple); }

  /* ── FORM ── */
  .rl-form-group { margin-bottom: 20px; }
  .rl-label { display: block; font-size: .82rem; font-weight: 500; color: var(--txt); margin-bottom: 6px; }
  .rl-input, .rl-textarea, .rl-select {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: .88rem;
    color: var(--txt);
    background: var(--surface);
    transition: border-color .18s, box-shadow .18s;
    outline: none;
  }
  .rl-input:focus, .rl-textarea:focus, .rl-select:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 3px var(--gold-dim);
  }
  .rl-textarea { resize: vertical; min-height: 120px; }

  /* ── ANIMATIONS ── */
  @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
  .fade-up { animation: fadeUp .4s ease both; }

  /* ── SCROLLBAR ── */
  ::-webkit-scrollbar { width: 6px; }
  ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

  /* ── NO SIDEBAR (pages publiques) ── */
  .rl-main.no-sidebar { margin-left: 0; }

  @yield('styles')
</style>
</head>
<body>

@auth
<aside class="rl-sidebar">
  {{-- Logo --}}
  <div class="rl-sidebar-logo">
    <a class="wordmark" href="{{ route('home') }}">RoukLegal</a>
    <div class="tagline">
      @if(Auth::user()->role === 'admin') Administration
      @elseif(Auth::user()->role === 'acteur_juridique') Espace Acteur Juridique
      @else Espace Client
      @endif
    </div>
  </div>

  {{-- Mini profil acteur --}}
  @if(Auth::user()->role === 'acteur_juridique')
  @php
    $profession = Auth::user()->profession ?? (Auth::user()->profession_libre ? (object)['nom' => Auth::user()->profession_libre] : null);
  @endphp
  <div class="sidebar-profile">
    <div class="profile-avatar">
      @if(Auth::user()->photo_professionnelle)
        <img src="{{ asset('storage/'.Auth::user()->photo_professionnelle) }}" alt="Photo"/>
      @elseif(Auth::user()->profile_photo)
        <img src="{{ asset('storage/'.Auth::user()->profile_photo) }}" alt="Photo"/>
      @else
        {{ strtoupper(substr(Auth::user()->nom, 0, 2)) }}
      @endif
    </div>
    <div class="profile-name">{{ Auth::user()->nom }}</div>
    @if($profession)
      <div class="profile-profession">{{ $profession->nom }}</div>
    @endif
    <a href="{{ route('acteur.profile') }}" class="profile-edit">Modifier le profil →</a>
  </div>
  @endif

  {{-- Navigation --}}
  <div class="rl-sidebar-section">Menu</div>
  <nav>

    {{-- ══════════════ CLIENT ══════════════ --}}
    @if(Auth::user()->role === 'client')
      <a class="rl-nav-item {{ request()->routeIs('client.dashboard') ? 'active' : '' }}"
         href="{{ route('client.dashboard') }}">
        <i class="fas fa-home"></i> Tableau de bord
      </a>
      <a class="rl-nav-item {{ request()->routeIs('client.acteurs','client.acteur.show') ? 'active' : '' }}"
         href="{{ route('client.acteurs') }}">
        <i class="fas fa-balance-scale"></i> Acteurs juridiques
      </a>
      <a class="rl-nav-item {{ request()->routeIs('client.articles') ? 'active' : '' }}"
         href="{{ route('client.articles') }}">
        <i class="fas fa-newspaper"></i> Articles
      </a>
      <a class="rl-nav-item {{ request()->routeIs('client.questions') ? 'active' : '' }}"
         href="{{ route('client.questions') }}">
        <i class="fas fa-question-circle"></i> Mes questions
      </a>
      {{-- Rendez-vous client --}}
      <a class="rl-nav-item {{ request()->routeIs('client.rendezVous','client.reserver') ? 'active' : '' }}"
         href="{{ route('client.rendezVous') }}">
        <i class="fas fa-calendar-check"></i> Mes rendez-vous
        @php
          $rdvClientAttente = \App\Models\RendezVous::where('user_id', Auth::id())
            ->whereIn('statut_paiement', ['payé','validé_admin'])->count();
        @endphp
        @if($rdvClientAttente > 0)
          <span class="rl-nav-badge gold">{{ $rdvClientAttente }}</span>
        @endif
      </a>
      <a class="rl-nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }}"
         href="{{ route('messages.index') }}">
        <i class="fas fa-comments"></i> Messagerie
      </a>
      <div class="rl-sidebar-section">Compte</div>
      <a class="rl-nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}"
         href="{{ route('settings.edit') }}">
        <i class="fas fa-cog"></i> Paramètres
      </a>

    {{-- ══════════════ ACTEUR JURIDIQUE ══════════════ --}}
    @elseif(Auth::user()->role === 'acteur_juridique')
      <a class="rl-nav-item {{ request()->routeIs('acteur.dashboard') ? 'active' : '' }}"
         href="{{ route('acteur.dashboard') }}">
        <i class="fas fa-home"></i> Tableau de bord
      </a>
      <a class="rl-nav-item {{ request()->routeIs('acteur.questions') ? 'active' : '' }}"
         href="{{ route('acteur.questions') }}">
        <i class="fas fa-question-circle"></i> Questions reçues
      </a>
      <a class="rl-nav-item {{ request()->routeIs('articles.dashboard') ? 'active' : '' }}"
         href="{{ route('articles.dashboard') }}">
        <i class="fas fa-newspaper"></i> Mes articles
      </a>
      <a class="rl-nav-item {{ request()->routeIs('articles.create') ? 'active' : '' }}"
         href="{{ route('articles.create') }}">
        <i class="fas fa-pen"></i> Nouvel article
      </a>

      {{-- Rendez-vous acteur --}}
      <div style="height:1px;background:rgba(255,255,255,.06);margin:8px 14px;"></div>
      <div class="rl-sidebar-section" style="padding-top:12px;">Rendez-vous</div>
      <a class="rl-nav-item {{ request()->routeIs('acteur.creneaux*') ? 'active' : '' }}"
         href="{{ route('acteur.creneaux') }}">
        <i class="fas fa-clock"></i> Mes créneaux
        @php
          $creneauxActifs = \App\Models\Creneau::where('acteurjuridique_id', Auth::id())->where('actif', true)->count();
        @endphp
        @if($creneauxActifs === 0)
          <span class="rl-nav-badge" style="background:var(--orange);">!</span>
        @endif
      </a>
      <a class="rl-nav-item {{ request()->routeIs('acteur.rendezVous') ? 'active' : '' }}"
         href="{{ route('acteur.rendezVous') }}">
        <i class="fas fa-calendar-check"></i> Rendez-vous reçus
        @php
          $rdvActeurAttente = \App\Models\RendezVous::where('acteurjuridique_id', Auth::id())
            ->where('statut_paiement', 'validé_admin')->count();
        @endphp
        @if($rdvActeurAttente > 0)
          <span class="rl-nav-badge">{{ $rdvActeurAttente }}</span>
        @endif
      </a>

      <div style="height:1px;background:rgba(255,255,255,.06);margin:8px 14px;"></div>
      <a class="rl-nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }}"
         href="{{ route('messages.index') }}">
        <i class="fas fa-comments"></i> Messagerie
      </a>
      <a class="rl-nav-item {{ request()->routeIs('acteur.profile') ? 'active' : '' }}"
         href="{{ route('acteur.profile') }}">
        <i class="fas fa-id-card"></i> Mon profil
      </a>
      <div class="rl-sidebar-section">Compte</div>
      <a class="rl-nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}"
         href="{{ route('settings.edit') }}">
        <i class="fas fa-cog"></i> Paramètres
      </a>

    {{-- ══════════════ ADMIN ══════════════ --}}
    @elseif(Auth::user()->role === 'admin')
      <a class="rl-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
         href="{{ route('admin.dashboard') }}">
        <i class="fas fa-chart-line"></i> Tableau de bord
      </a>
      <a class="rl-nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}"
         href="#">
        <i class="fas fa-users"></i> Utilisateurs
      </a>
      <a class="rl-nav-item {{ request()->routeIs('admin.paiements') ? 'active' : '' }}"
         href="#">
        <i class="fas fa-credit-card"></i> Paiements
      </a>
      <a class="rl-nav-item {{ request()->routeIs('admin.commissions') ? 'active' : '' }}"
         href="#">
        <i class="fas fa-percentage"></i> Commissions
      </a>

      {{-- Rendez-vous admin --}}
      <div style="height:1px;background:rgba(255,255,255,.06);margin:8px 14px;"></div>
      <div class="rl-sidebar-section" style="padding-top:12px;">Rendez-vous</div>
      <a class="rl-nav-item {{ request()->routeIs('admin.rendezVous') ? 'active' : '' }}"
         href="{{ route('admin.rendezVous') }}">
        <i class="fas fa-calendar-alt"></i> Rendez-vous
        @php
          $rdvAdminAttente = \App\Models\RendezVous::where('statut_paiement', 'payé')->count();
        @endphp
        @if($rdvAdminAttente > 0)
          <span class="rl-nav-badge">{{ $rdvAdminAttente }}</span>
        @endif
      </a>

      <div class="rl-sidebar-section">Compte</div>
      <a class="rl-nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}"
         href="{{ route('settings.edit') }}">
        <i class="fas fa-cog"></i> Paramètres
      </a>
    @endif

  </nav>

  {{-- Footer --}}
  <div class="rl-sidebar-footer">
    <div class="user-row">
      <div class="avatar">
        @if(Auth::user()->profile_photo)
          <img src="{{ asset('storage/'.Auth::user()->profile_photo) }}" alt=""/>
        @else
          {{ strtoupper(substr(Auth::user()->nom, 0, 2)) }}
        @endif
      </div>
      <div>
        <div class="user-name">{{ Auth::user()->nom }}</div>
        <div class="user-role">
          @if(Auth::user()->role === 'admin') Super Admin
          @elseif(Auth::user()->role === 'acteur_juridique') Acteur Juridique
          @else Client
          @endif
        </div>
      </div>
    </div>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="rl-logout-btn">
        <i class="fas fa-sign-out-alt"></i> Se déconnecter
      </button>
    </form>
  </div>
</aside>
@endauth

{{-- MAIN --}}
<div class="rl-main {{ !Auth::check() ? 'no-sidebar' : '' }}">

  {{-- TOPBAR --}}
  @auth
  <header class="rl-topbar">
    <div class="page-title">
      @yield('page-title', 'RoukLegal')
    </div>
    <div class="rl-topbar-right">
      <div class="rl-date-pill" id="rl-date"></div>
      @yield('topbar-actions')
    </div>
  </header>
  @endauth

  {{-- ALERTS --}}
  <div style="padding: 0 32px; margin-top: 16px;">
    @if(session('status'))
      <div class="rl-alert rl-alert-success"><i class="fas fa-check-circle"></i> {{ session('status') }}</div>
    @endif
    @if(session('error'))
      <div class="rl-alert rl-alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif
    @if($errors->any())
      <div class="rl-alert rl-alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
      </div>
    @endif
  </div>

  {{-- PAGE CONTENT --}}
  <div class="rl-content">
    @yield('content')
  </div>
</div>

<script>
  const d = new Date();
  const el = document.getElementById('rl-date');
  if (el) el.textContent = d.toLocaleDateString('fr-FR', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
</script>
@yield('scripts')
</body>
</html>