@extends('layouts.app')
@section('title', 'Dashboard - Client')
@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex align-items-center">
        @if(Auth::user()->profile_photo)
            <img src="{{ asset('storage/'.Auth::user()->profile_photo) }}" alt="Profil" class="rounded-circle me-3" style="width:60px;height:60px;object-fit:cover;">
        @endif
        <div>
            <h1 style="color: var(--dark); font-weight: 700; margin-bottom: 0.5rem;">Bienvenue, {{ Auth::user()->nom }}</h1>
            <p style="color: #6b7280; margin: 0;">Gérez vos questions, consultations et paiements</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6 col-lg-4">
        <div class="stat-card primary">
            <i class="fas fa-question-circle" style="font-size: 2rem; opacity: 0.8;"></i>
            <div class="stat-number">{{ $questionsCount ?? 0 }}</div>
            <div class="stat-label">Questions posées</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="stat-card success">
            <i class="fas fa-credit-card" style="font-size: 2rem; opacity: 0.8;"></i>
            <div class="stat-number">{{ $paymentsCount ?? 0 }}</div>
            <div class="stat-label">Paiements</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="stat-card warning">
            <i class="fas fa-newspaper" style="font-size: 2rem; opacity: 0.8;"></i>
            <div class="stat-number">0</div>
            <div class="stat-label">Articles lus</div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title" style="font-weight: 700; color: var(--dark); margin-bottom: 1rem;">
                    <i class="fas fa-list"></i> Vos questions récentes
                </h5>
                <p style="color: #6b7280; margin-bottom: 1.5rem;">Accédez à vos questions et suivez les réponses</p>
                <a href="{{ route('client.questions') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-right"></i> Voir toutes
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title" style="font-weight: 700; color: var(--dark); margin-bottom: 1rem;">
                    <i class="fas fa-newspaper"></i> Articles Juridiques
                </h5>
                <p style="color: #6b7280; margin-bottom: 1.5rem;">Consultez les articles de nos experts</p>
                <a href="{{ route('client.articles') }}" class="btn btn-primary">
                    <i class="fas fa-book-open"></i> Lire les articles
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="font-weight: 700; color: var(--dark); margin-bottom: 1rem;">
                    <i class="fas fa-plus-circle"></i> Poser une question
                </h5>
                <p style="color: #6b7280; margin-bottom: 1.5rem;">Contactez directement nos experts juridiques</p>
                <a href="#new-question" class="btn btn-success btn-lg">
                    <i class="fas fa-question-circle"></i> Nouvelle question
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>