@extends('layouts.app')
@section('title', 'Dashboard - Acteur Juridique')
@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex align-items-center">
        @if(Auth::user()->profile_photo)
            <img src="{{ asset('storage/'.Auth::user()->profile_photo) }}" alt="Profil" class="rounded-circle me-3" style="width:60px;height:60px;object-fit:cover;">
        @endif
        <div>
            <h1 style="color: var(--dark); font-weight: 700; margin-bottom: 0.5rem;">Bonjour, {{ Auth::user()->nom }}</h1>
            <p style="color: #6b7280; margin: 0;">
                Professionnel en: <strong>{{ $profession?->nom ?? Auth::user()->profession_libre ?? 'Non défini' }}</strong>
            </p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6 col-lg-3">
        <div class="stat-card primary">
            <i class="fas fa-reply" style="font-size: 2rem; opacity: 0.8;"></i>
            <div class="stat-number">{{ $assigned }}</div>
            <div class="stat-label">Réponses fournies</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card secondary">
            <i class="fas fa-newspaper" style="font-size: 2rem; opacity: 0.8;"></i>
            <div class="stat-number">{{ $articles }}</div>
            <div class="stat-label">Articles publiés</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card warning">
            <i class="fas fa-briefcase" style="font-size: 2rem; opacity: 0.8;"></i>
            <div class="stat-number">{{ $profession ? '1' : '0' }}</div>
            <div class="stat-label">Spécialités</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="stat-card dark">
            <i class="fas fa-star" style="font-size: 2rem; opacity: 0.8;"></i>
            <div class="stat-number">4.8</div>
            <div class="stat-label">Votre notation</div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title" style="font-weight: 700; color: var(--dark); margin-bottom: 1rem;">
                    <i class="fas fa-briefcase"></i> Votre profil professionnel
                </h5>
                <p style="color: #6b7280; margin-bottom: 0.75rem;">
                    Spécialité: <strong>{{ $profession?->nom ?? 'Non définie' }}</strong>
                </p>
                @if(Auth::user()->description)
                    <div class="d-flex align-items-start">
                        @if(Auth::user()->photo_professionnelle)
                            <img src="{{ asset('storage/' . Auth::user()->photo_professionnelle) }}" alt="Photo pro" class="rounded me-3" style="width:80px; height:80px; object-fit:cover;">
                        @endif
                        <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 1.5rem;">
                            {{ Str::limit(Auth::user()->description, 150) }}
                        </p>
                    </div>
                @else
                    <p style="color: #d1d5db; font-style: italic; margin-bottom: 1.5rem;">
                        Veuillez ajouter une description professionnelle
                    </p>
                @endif
                <a href="{{ route('acteur.profile') }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Modifier profil
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title" style="font-weight: 700; color: var(--dark); margin-bottom: 1rem;">
                    <i class="fas fa-newspaper"></i> Gérer vos articles
                </h5>
                <p style="color: #6b7280; margin-bottom: 1.5rem;">
                    Vous avez écrit <strong>{{ $articles }}</strong> article(s)<br>
                    Partagez votre expertise avec nos clients
                </p>
                <a href="{{ route('articles.dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-right"></i> Voir mes articles
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="font-weight: 700; color: var(--dark); margin-bottom: 0.5rem;">
                    <i class="fas fa-chart-bar"></i> Actions rapides
                </h5>
                <div class="row g-2 mt-2">
                    <div class="col-md-4">
                        <a href="{{ route('articles.create') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-pen-fancy"></i> Nouvel article
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('articles.dashboard') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-folder-open"></i> Mes articles
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('acteur.questions') }}" class="btn btn-outline-warning w-100">
                            <i class="fas fa-comments"></i> Mes réponses
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
