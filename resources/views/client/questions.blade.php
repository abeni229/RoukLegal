@extends('layouts.app')
@section('title', 'Mes Questions - Client')
@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 style="color: var(--dark); font-weight: 700; margin-bottom: 0.5rem;">Mes Questions</h1>
        <p style="color: #6b7280; margin: 0;">Suivez vos questions et consultez les réponses</p>
    </div>
</div>

@if($questions->count() > 0)
    <div class="row g-4">
        @foreach($questions as $question)
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="card-title mb-1">{{ $question->titre }}</h5>
                            <small class="text-muted">
                                Posée le {{ $question->created_at->format('d/m/Y à H:i') }}
                                @if($question->article)
                                    - Article: <a href="{{ route('articles.show', $question->article->id) }}" class="text-decoration-none">{{ $question->article->titre }}</a>
                                @endif
                            </small>
                        </div>
                        <span class="badge bg-{{ $question->statut === 'repondu' ? 'success' : ($question->statut === 'en_attente' ? 'warning' : 'secondary') }}">
                            {{ $question->statut === 'repondu' ? 'Répondu' : ($question->statut === 'en_attente' ? 'En attente' : 'Fermé') }}
                        </span>
                    </div>

                    <p class="card-text mb-3">{{ $question->contenu }}</p>

                    @if($question->reponses->count() > 0)
                        @if(Auth::user()->canAccessResponses())
                            <div class="border-start border-primary border-3 ps-3 mb-3">
                                <h6 class="text-primary mb-2">Réponse de {{ $question->reponses->first()->acteur->nom }}</h6>
                                <p class="mb-1">{{ $question->reponses->first()->contenu }}</p>
                                <small class="text-muted">
                                    Répondu le {{ $question->reponses->first()->created_at->format('d/m/Y à H:i') }}
                                </small>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-lock"></i> Cette réponse nécessite un abonnement.
                                <a href="#" class="alert-link" onclick="showSubscriptionModal()">Souscrire maintenant</a>
                            </div>
                        @endif
                    @else
                        <div class="text-muted">
                            <i class="fas fa-clock"></i> En attente de réponse
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $questions->links() }}
    </div>
@else
    <div class="text-center py-5">
        <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
        <h4 class="text-muted">Aucune question posée</h4>
        <p class="text-muted">Vous n'avez pas encore posé de questions.</p>
        <a href="{{ route('client.articles') }}" class="btn btn-primary">
            <i class="fas fa-newspaper"></i> Découvrir les articles
        </a>
    </div>
@endif
@endsection

<!-- Modal d'abonnement -->
<div class="modal fade" id="subscriptionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Accès aux réponses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Pour accéder aux réponses des experts, vous devez souscrire à notre service.</p>
                <div class="row">
                    <div class="col-12">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <h5 class="card-title">Abonnement Mensuel</h5>
                                <h3 class="text-primary mb-3">50€<small class="text-muted">/mois</small></h3>
                                <p class="card-text">
                                    <i class="fas fa-check text-success"></i> Accès illimité aux réponses<br>
                                    <i class="fas fa-check text-success"></i> Consultation d'articles illimitée<br>
                                    <i class="fas fa-check text-success"></i> Questions directes aux experts<br>
                                    <i class="fas fa-check text-success"></i> Support prioritaire
                                </p>
                                <button class="btn btn-primary" onclick="subscribe()">
                                    <i class="fas fa-credit-card"></i> Souscrire maintenant
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card border-success">
                            <div class="card-body text-center">
                                <h5 class="card-title text-success">Essai Gratuit</h5>
                                <h4 class="text-success mb-3">2 semaines gratuites</h4>
                                <p class="card-text">
                                    <i class="fas fa-check text-success"></i> Accès complet pendant 14 jours<br>
                                    <i class="fas fa-check text-success"></i> Toutes les fonctionnalités<br>
                                    <i class="fas fa-check text-success"></i> Sans engagement<br>
                                    <i class="fas fa-info-circle text-info"></i> Annulable à tout moment
                                </p>
                                <button class="btn btn-success" onclick="startFreeTrial()">
                                    <i class="fas fa-play"></i> Commencer l'essai gratuit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle"></i> Essai gratuit de 2 semaines disponible pour les nouveaux utilisateurs.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showSubscriptionModal() {
    var modal = new bootstrap.Modal(document.getElementById('subscriptionModal'));
    modal.show();
}

function subscribe() {
    alert('Fonctionnalité de paiement à implémenter');
    // Ici on intégrera Stripe ou un autre système de paiement
}

function startFreeTrial() {
    if (confirm('Êtes-vous sûr de vouloir commencer votre essai gratuit de 2 semaines ?')) {
        fetch('/client/start-trial', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Essai gratuit activé ! Vous avez maintenant accès à toutes les fonctionnalités pendant 2 semaines.');
                location.reload();
            } else {
                alert('Erreur: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue. Veuillez réessayer.');
        });
    }
}
</script>