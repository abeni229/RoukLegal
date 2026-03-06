@extends('layouts.app')
@section('title', 'Dashboard - Administration')
@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 style="color: var(--dark); font-weight: 700; margin-bottom: 0.5rem;">Panneau d'administration</h1>
        <p style="color: #6b7280; margin: 0;">Vue d'ensemble de votre plateforme</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6 col-lg-5">
        <div class="stat-card primary">
            <i class="fas fa-users" style="font-size: 2rem; opacity: 0.8;"></i>
            <div class="stat-number">{{ $totalUsers }}</div>
            <div class="stat-label">Utilisateurs totaux</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-5">
        <div class="stat-card success">
            <i class="fas fa-user-tie" style="font-size: 2rem; opacity: 0.8;"></i>
            <div class="stat-number">{{ $clients }}</div>
            <div class="stat-label">Clients</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-5">
        <div class="stat-card warning">
            <i class="fas fa-briefcase" style="font-size: 2rem; opacity: 0.8;"></i>
            <div class="stat-number">{{ $acteurs }}</div>
            <div class="stat-label">Acteurs juridiques</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-5">
        <div class="stat-card secondary">
            <i class="fas fa-question-circle" style="font-size: 2rem; opacity: 0.8;"></i>
            <div class="stat-number">{{ $questions }}</div>
            <div class="stat-label">Questions</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-5">
        <div class="stat-card dark">
            <i class="fas fa-reply" style="font-size: 2rem; opacity: 0.8;"></i>
            <div class="stat-number">{{ $reponses }}</div>
            <div class="stat-label">Réponses</div>
        </div>
    </div>
    <div class="col-md-6 col-lg-5">
        <div class="stat-card info">
            <i class="fas fa-hourglass-start" style="font-size: 2rem; opacity: 0.8;"></i>
            <div class="stat-number">{{ $trials ?? 0 }}</div>
            <div class="stat-label">Essais gratuits actifs</div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title" style="font-weight: 700; color: var(--dark); margin-bottom: 1rem;">
                    <i class="fas fa-users"></i> Gestion utilisateurs
                </h5>
                <p style="color: #6b7280; margin-bottom: 1.5rem;">Gérez les utilisateurs et leurs rôles</p>
                <a href="#users" class="btn btn-primary">
                    <i class="fas fa-arrow-right"></i> Voir
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title" style="font-weight: 700; color: var(--dark); margin-bottom: 1rem;">
                    <i class="fas fa-shield-alt"></i> Modération
                </h5>
                <p style="color: #6b7280; margin-bottom: 1.5rem;">Contrôlez le contenu et gérez les signalements</p>
                <a href="#moderation" class="btn btn-primary">
                    <i class="fas fa-arrow-right"></i> Voir
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="font-weight: 700; color: var(--dark); margin-bottom: 1rem;">
                    <i class="fas fa-chart-line"></i> Progression des paiements (6 derniers mois)
                </h5>
                @if(isset($paymentsByMonth) && $paymentsByMonth->count())
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Mois</th>
                                <th>Nombre de paiements</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paymentsByMonth as $row)
                                <tr>
                                    <td>{{ $row->month }}</td>
                                    <td>{{ $row->count }}</td>
                                    <td>{{ number_format($row->total, 0, ',', ' ') }} FCFA</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Aucun paiement enregistré.</p>
                @endif

                @if(isset($paymentsByMethod) && $paymentsByMethod->count())
                    <h6 class="mt-4">Répartition par méthode</h6>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Méthode</th>
                                <th>Nb paiements</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paymentsByMethod as $row)
                                <tr>
                                    <td>{{ $row->methode ?? 'non spécifiée' }}</td>
                                    <td>{{ $row->count }}</td>
                                    <td>{{ number_format($row->total, 0, ',', ' ') }} FCFA</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>