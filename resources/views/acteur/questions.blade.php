@extends('layouts.app')
@section('title', 'Questions Reçues - Acteur Juridique')
@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 style="color: var(--dark); font-weight: 700; margin-bottom: 0.5rem;">Questions Reçues</h1>
        <p style="color: #6b7280; margin: 0;">Questions posées sur vos articles</p>
    </div>
</div>

@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($questions->count() > 0)
    <div class="row g-4">
        @foreach($questions as $question)
        <div class="col-12" data-question-id="{{ $question->id }}">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="card-title mb-1">{{ $question->titre }}</h5>
                            <small class="text-muted">
                                De: {{ $question->user->nom }} |
                                Article: <a href="{{ route('articles.show', $question->article->id) }}" class="text-decoration-none">{{ $question->article->titre }}</a> |
                                Le {{ $question->created_at->format('d/m/Y à H:i') }}
                            </small>
                        </div>
                        <span class="badge bg-{{ $question->reponses->count() > 0 ? 'success' : 'warning' }}">
                            {{ $question->reponses->count() > 0 ? 'Répondu' : 'À répondre' }}
                        </span>
                    </div>

                    <p class="card-text mb-3">{{ $question->contenu }}</p>

                    @if($question->reponses->count() > 0)
                        <div class="border-start border-success border-3 ps-3 mb-3">
                            <h6 class="text-success mb-2">Votre réponse</h6>
                            <p class="mb-1">{{ $question->reponses->first()->contenu }}</p>
                            <small class="text-muted">
                                Répondu le {{ $question->reponses->first()->created_at->format('d/m/Y à H:i') }}
                            </small>
                        </div>
                        <button class="btn btn-outline-secondary btn-sm" onclick="editResponse({{ $question->id }}, '{{ addslashes($question->reponses->first()->contenu) }}')">
                            <i class="fas fa-edit"></i> Modifier la réponse
                        </button>
                    @else
                        <button class="btn btn-primary btn-sm" onclick="showResponseForm({{ $question->id }})">
                            <i class="fas fa-reply"></i> Répondre
                        </button>
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
        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
        <h4 class="text-muted">Aucune question reçue</h4>
        <p class="text-muted">Vous n'avez pas encore reçu de questions sur vos articles.</p>
        <a href="{{ route('articles.create') }}" class="btn btn-primary">
            <i class="fas fa-pen-fancy"></i> Écrire un article
        </a>
    </div>
@endif
@endsection

<!-- Modal de réponse -->
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

<script>
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

// Gérer la soumission du formulaire
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
});
</script>