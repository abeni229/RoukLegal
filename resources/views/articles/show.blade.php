@extends('layouts.app')
@section('title', $article->title)
@section('content')
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('articles.index') }}" class="btn btn-sm btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Retour aux articles
        </a>
        <h1 style="color: var(--dark); font-weight: 700; margin-bottom: 1rem;">{{ $article->title }}</h1>
        <div style="color: #6b7280; font-size: 0.95rem;">
            <small><i class="fas fa-user"></i> Par <strong>{{ $article->user->nom }}</strong> ({{ $article->user->profession?->nom ?? 'N/A' }})</small>
            &nbsp;|&nbsp;
            <small><i class="fas fa-calendar"></i> {{ $article->created_at->format('d/m/Y') }}</small>
            &nbsp;|&nbsp;
            <small><i class="fas fa-eye"></i> {{ $article->views }} vues</small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-body">
                <div style="line-height: 1.8; color: #374151; word-wrap: break-word;">
                    {!! nl2br(e($article->content)) !!}
                </div>
            </div>
        </div>

        <!-- Questions Section -->
        <div class="card mb-4">
            <div class="card-header" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: white; font-weight: 700;">
                <i class="fas fa-comments"></i> Questions des clients ({{ $article->questions()->count() }})
            </div>
            <div class="card-body">
                @if($article->questions()->count() > 0)
                    @foreach($article->questions()->with('user')->get() as $question)
                        <div style="border-bottom: 1px solid #e5e7eb; padding-bottom: 1.5rem; margin-bottom: 1.5rem;" data-question-id="{{ $question->id }}">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <strong style="color: var(--dark);">{{ $question->user->nom }}</strong>
                                    <small style="color: #6b7280;">
                                        • {{ $question->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                @if(Auth::user() && Auth::user()->id === $article->user_id && Auth::user()->role === 'acteur_juridique')
                                    @if($question->reponses()->count() > 0)
                                        <span class="badge bg-success">Répondu</span>
                                    @else
                                        <button class="btn btn-sm btn-primary" onclick="showResponseForm({{ $question->id }})">
                                            <i class="fas fa-reply"></i> Répondre
                                        </button>
                                    @endif
                                @endif
                            </div>
                            <p style="color: #374151; margin-bottom: 0;">{{ $question->titre }}</p>
                            @if(Auth::user() && Auth::user()->id === $article->user_id && Auth::user()->role === 'acteur_juridique' && $question->reponses()->count() > 0)
                                <div class="border-start border-success border-3 ps-3 mt-2">
                                    <h6 class="text-success mb-2">Votre réponse</h6>
                                    <p class="mb-1">{{ $question->reponses->first()->contenu }}</p>
                                    <small class="text-muted">
                                        Répondu le {{ $question->reponses->first()->created_at->format('d/m/Y à H:i') }}
                                    </small>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p style="color: #6b7280; text-align: center; padding: 2rem 0; margin: 0;">
                        <i class="fas fa-comment-slash" style="font-size: 2rem; opacity: 0.5; display: block; margin-bottom: 0.5rem;"></i>
                        Aucune question pour le moment
                    </p>
                @endif
            </div>
        </div>

        @if(Auth::user() && Auth::user()->id === $article->user_id && Auth::user()->role === 'acteur_juridique')
            <a href="{{ route('acteur.questions') }}" class="btn btn-info mb-3">
                <i class="fas fa-question-circle"></i> Gérer toutes mes questions
            </a>
        @endif

        <!-- New Question Form -->
        @if(Auth::user() && Auth::user()->role === 'client')
            @if($canAskQuestion)
                <div class="card">
                    <div class="card-header" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: white; font-weight: 700;">
                        <i class="fas fa-question-circle"></i> Poser une question
                    </div>
                    <div class="card-body">
                        @if(session('status'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="fas fa-check-circle"></i> {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('articles.storeQuestion', $article->id) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="titre" class="form-label">Votre question:</label>
                                <input type="text" id="titre" name="titre" class="form-control" 
                                       placeholder="Posez votre question..." required value="{{ old('titre') }}">
                                @error('titre')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="contenu" class="form-label">Description (optionnel):</label>
                                <textarea name="contenu" id="contenu" class="form-control" rows="4" 
                                          placeholder="Donnez plus de détails...">{{ old('contenu') }}</textarea>
                                @error('contenu')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-send"></i> Envoyer la question
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="card border-warning">
                    <div class="card-body text-center">
                        <i class="fas fa-lock fa-2x text-warning mb-3"></i>
                        <h5 class="card-title">Accès limité</h5>
                        <p class="card-text">Pour poser des questions aux experts, vous devez souscrire à notre service.</p>
                        <button class="btn btn-warning" onclick="showSubscriptionModal()">
                            <i class="fas fa-credit-card"></i> Souscrire maintenant
                        </button>
                    </div>
                </div>
            @endif
        @else
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle"></i> 
                <strong>Vous devez être connecté en tant que client pour poser une question.</strong>
                <a href="{{ route('login') }}" class="alert-link">Se connecter</a>
            </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-user-tie" style="font-size: 2.5rem;"></i>
                </div>
                <h6 style="color: var(--dark); font-weight: 700; margin-bottom: 0.5rem;">{{ $article->user->nom }}</h6>
                <p style="color: var(--primary); font-weight: 600; margin-bottom: 1rem;">{{ $article->user->profession?->nom ?? 'Professionnel' }}</p>
                
                @if($article->user->description)
                    <div style="background: #f9fafb; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; text-align: left;">
                        <small style="color: #6b7280;">
                            {{ Str::limit($article->user->description, 200) }}
                        </small>
                    </div>
                @endif

                <a href="#" class="btn btn-primary w-100 mb-2" onclick="alert('Fonctionnalité à implémenter'); return false;">
                    <i class="fas fa-envelope"></i> Contacter
                </a>
                <a href="#" class="btn btn-outline-primary w-100" onclick="alert('Fonctionnalité à implémenter'); return false;">
                    <i class="fas fa-user-plus"></i> Ajouter
                </a>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="card-title" style="font-weight: 700; color: var(--dark); margin-bottom: 1rem;">
                    <i class="fas fa-star"></i> Notation
                </h6>
                <div style="text-align: center; font-size: 1.5rem;">
                    <span style="color: #fbbf24;">★★★★★</span>
                    <p style="margin-top: 0.5rem; color: #6b7280; font-size: 0.9rem;">4.8/5 (120 avis)</p>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="card-title" style="font-weight: 700; color: var(--dark); margin-bottom: 1rem;">
                    <i class="fas fa-chart-bar"></i> Articles connexes
                </h6>
                @php
                    $relatedArticles = $article->user->articles()
                        ->where('id', '!=', $article->id)
                        ->limit(3)
                        ->get();
                @endphp
                
                @if($relatedArticles->count() > 0)
                    @foreach($relatedArticles as $related)
                        <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e5e7eb;">
                            <a href="{{ route('articles.show', $related->id) }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">
                                {{ Str::limit($related->title, 40) }}
                            </a>
                            <small style="display: block; color: #6b7280; margin-top: 0.25rem;">
                                <i class="fas fa-eye"></i> {{ $related->views }}
                            </small>
                        </div>
                    @endforeach
                @else
                    <p style="color: #6b7280; font-size: 0.9rem; margin: 0;">
                        Pas d'autres articles
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Modal de réponse (pour acteurs) -->
<div class="modal fade" id="responseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Répondre à la question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="" id="responseForm">
                @csrf
                <div class="modal-body">
                    <div id="responseError" class="alert alert-danger" style="display: none;"></div>
                    <div class="mb-3">
                        <label for="responseTitle" class="form-label">Question</label>
                        <div id="responseTitle" class="form-control-plaintext" style="border: 1px solid #dee2e6; padding: 0.375rem 0.75rem; border-radius: 0.375rem; background: #f8f9fa;"></div>
                    </div>
                    <div class="mb-3">
                        <label for="responseContent" class="form-label">Votre réponse</label>
                        <textarea class="form-control" id="responseContent" name="contenu" rows="6" required
                                  placeholder="Fournissez une réponse claire et complète à la question..."></textarea>
                        <div class="form-text">Minimum 10 caractères, maximum 5000 caractères.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Envoyer la réponse
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal d'abonnement -->
<div class="modal fade" id="subscriptionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Accès aux réponses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Pour accéder aux réponses des experts et poser des questions, vous devez souscrire à notre service.</p>
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
            },
            body: JSON.stringify({}),
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                window.location.reload();
            }
        });
    }
}

// response modal helpers (same as acteur.questions)
function showResponseForm(questionId) {
    const questionText = document.querySelector('[data-question-id="' + questionId + '"] .card-title')?.textContent || '';
    const form = document.getElementById('responseForm');
    form.action = `/acteur/questions/${questionId}/respond`;
    document.getElementById('responseTitle').textContent = questionText;
    document.getElementById('responseContent').value = '';
    document.getElementById('responseError').style.display = 'none';
    const modal = new bootstrap.Modal(document.getElementById('responseModal'));
    modal.show();
}

function editResponse(questionId, currentContent) {
    const questionText = document.querySelector('[data-question-id="' + questionId + '"] .card-title')?.textContent || '';
    const form = document.getElementById('responseForm');
    form.action = `/acteur/questions/${questionId}/respond`;
    document.getElementById('responseTitle').textContent = questionText;
    document.getElementById('responseContent').value = currentContent;
    document.getElementById('responseError').style.display = 'none';
    const modal = new bootstrap.Modal(document.getElementById('responseModal'));
    modal.show();
}

// validate response form
document.getElementById('responseForm')?.addEventListener('submit', function(e) {
    const errorDiv = document.getElementById('responseError');
    const content = document.getElementById('responseContent');
    if (content.value.trim().length < 10) {
        e.preventDefault();
        errorDiv.textContent = 'La réponse doit contenir au minimum 10 caractères.';
        errorDiv.style.display = 'block';
    } else if (content.value.trim().length > 5000) {
        e.preventDefault();
        errorDiv.textContent = 'La réponse ne doit pas dépasser 5000 caractères.';
        errorDiv.style.display = 'block';
    }
});// existing subscription functions continue
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
