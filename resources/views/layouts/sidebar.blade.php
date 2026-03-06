<div class="sidebar">
    @if(Auth::user()->role === 'client')
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}" href="{{ route('client.dashboard') }}">
                    <i class="fas fa-home"></i> Tableau de bord
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('client.acteurs') ? 'active' : '' }}" href="{{ route('client.acteurs') }}">
                    <i class="fas fa-briefcase"></i> Acteurs juridiques
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('messages.index') }}">
                    <i class="fas fa-envelope"></i> Mes messages
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#questions">
                    <i class="fas fa-question-circle"></i> Mes questions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#payments">
                    <i class="fas fa-credit-card"></i> Mes paiements
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.edit') }}">
                    <i class="fas fa-cog"></i> Paramètres
                </a>
            </li>
        </ul>
    @elseif(Auth::user()->role === 'acteur_juridique')
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('acteur.dashboard') ? 'active' : '' }}" href="{{ route('acteur.dashboard') }}">
                    <i class="fas fa-home"></i> Tableau de bord
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('acteur.profile') ? 'active' : '' }}" href="{{ route('acteur.profile') }}">
                    <i class="fas fa-briefcase"></i> Ma profession
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('messages.index') }}">
                    <i class="fas fa-envelope"></i> Mes messages
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#responses">
                    <i class="fas fa-reply"></i> Mes réponses
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#ratings">
                    <i class="fas fa-star"></i> Évaluations
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.edit') }}">
                    <i class="fas fa-cog"></i> Paramètres
                </a>
            </li>
        </ul>
    @elseif(Auth::user()->role === 'admin')
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#users">
                    <i class="fas fa-users"></i> Utilisateurs
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#moderation">
                    <i class="fas fa-shield-alt"></i> Modération
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.edit') }}">
                    <i class="fas fa-cog"></i> Paramètres
                </a>
            </li>
        </ul>
    @endif
</div>
