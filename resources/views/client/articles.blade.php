@extends('layouts.app')
@section('title', 'Articles et Conseils Juridiques')
@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 style="color: var(--dark); font-weight: 700; margin-bottom: 0.5rem;">
            <i class="fas fa-newspaper"></i> Articles et Conseils Juridiques
        </h1>
        <p style="color: #6b7280;">Consultez les articles de nos experts et posez vos questions directement</p>
    </div>
</div>

@if($articles->count() > 0)
    <div class="d-flex flex-column gap-4">
        @foreach($articles as $article)
            <div class="card h-100 shadow-sm hover-card">
                <!-- Header with color -->
                <div style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); 
                            height: 120px; display: flex; align-items: flex-end; padding: 1.5rem 1.5rem 0;">
                    <div style="display: inline-block; background: rgba(255,255,255,0.2); 
                               color: white; padding: 0.5rem 1rem; border-radius: 9999px; 
                               font-size: 0.85rem; font-weight: 600; backdrop-filter: blur(10px);">
                        {{ $article->user->profession?->nom ?? 'Expert' }}
                    </div>
                </div>

                <div class="card-body">
                    <h5 class="card-title" style="color: var(--dark); font-weight: 700; margin-bottom: 0.75rem; min-height: 3.2rem;">
                        {{ $article->title }}
                    </h5>
                    
                    <p style="color: #6b7280; font-size: 0.95rem; margin-bottom: 1rem; min-height: 2.5rem;">
                        {{ Str::limit(strip_tags($article->content), 100) }}...
                    </p>

                    <!-- Author info -->
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; 
                               padding-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); 
                                   border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0;">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div style="flex: 1;">
                            <p style="margin: 0; font-weight: 600; color: var(--dark); font-size: 0.9rem;">
                                {{ $article->user->nom }}
                            </p>
                            <small style="color: #6b7280;">{{ $article->created_at->format('d M Y') }}</small>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div style="display: flex; gap: 1rem; font-size: 0.85rem; color: #6b7280; margin-bottom: 1.5rem;">
                        <small><i class="fas fa-eye"></i> {{ $article->views }} vus</small>
                        <small><i class="fas fa-comments"></i> {{ $article->questions()->count() }}</small>
                    </div>

                    <!-- Action buttons -->
                    <div class="d-grid gap-2">
                        @if(Auth::user()->canViewArticleFromAuthor($article->user_id))
                            <a href="{{ route('articles.show', $article->id) }}" class="btn btn-primary">
                                <i class="fas fa-book-open"></i> Lire l'article
                            </a>
                        @else
                            <button class="btn btn-outline-primary" onclick="showSubscriptionModal()">
                                <i class="fas fa-lock"></i> Article limité
                            </button>
                        @endif
                        @if(Auth::user()->canAskQuestions())
                            <a href="{{ route('articles.show', $article->id) }}#questions" class="btn btn-outline-secondary">
                                <i class="fas fa-question-circle"></i> Poser une question
                            </a>
                        @else
                            <button class="btn btn-outline-secondary" onclick="showSubscriptionModal()">
                                <i class="fas fa-lock"></i> Questions limitées
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-5">
        {{ $articles->links() }}
    </div>
@else
    <div class="card text-center py-5">
        <div class="card-body">
            <i class="fas fa-newspaper" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem;"></i>
            <h5 class="card-title" style="color: var(--dark); font-weight: 700; margin-bottom: 0.5rem;">
                Aucun article disponible pour le moment
            </h5>
            <p style="color: #6b7280; margin-bottom: 1.5rem;">
                Les professionnels du réseau publient régulièrement des articles utiles
            </p>
            <a href="{{ route('client.dashboard') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Retour au dashboard
            </a>
        </div>
    </div>
@endif

<style>
    .card {
        border: none;
        border-radius: 0.75rem;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .hover-card {
        cursor: pointer;
    }
    
    .hover-card:hover {
        box-shadow: 0 14px 40px rgba(0, 0, 0, 0.18) !important;
        transform: translateY(-8px) scale(1.02);
        background: linear-gradient(135deg, #f5f5dc, #e7d5b5); /* beige gradient */
    }
    
    .hover-card:hover .card-title {
        color: #ffffff;
    }
</style>
@endsection

<!-- Modal d'abonnement -->
<div class="modal fade" id="subscriptionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Accès complet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Pour accéder à tous les articles et poser des questions aux experts, vous devez souscrire à notre service.</p>
                <div class="row">
                    <div class="col-12">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <h5 class="card-title">Abonnement Mensuel</h5>
                                <h3 class="text-primary mb-3">50€<small class="text-muted">/mois</small></h3>
                                <p class="card-text">
                                    <i class="fas fa-check text-success"></i> Accès illimité aux articles<br>
                                    <i class="fas fa-check text-success"></i> Questions directes aux experts<br>
                                    <i class="fas fa-check text-success"></i> Accès aux réponses<br>
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
