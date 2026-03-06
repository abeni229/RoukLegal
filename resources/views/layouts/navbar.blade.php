<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-gavel" style="margin-right: 0.5rem;"></i>RoukLegal
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto" style="align-items: center;">
                @auth
                    <li class="nav-item" style="margin-right: 1.5rem;">
                        <span style="color: white; font-weight: 500;">
                            {{ Auth::user()->nom }}
                        </span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button class="btn btn-outline-light btn-sm" type="submit">
                                <i class="fas fa-sign-out-alt"></i> Déconnexion
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-light btn-sm" href="{{ route('register') }}" style="color: var(--primary); font-weight: 600;">Inscription</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
