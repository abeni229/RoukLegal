@extends('layouts.app')
@section('title', 'Créer un Nouvel Article')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="font-weight: 700; color: var(--dark); margin-bottom: 2rem;">
                    <i class="fas fa-pen-fancy"></i> Créer un Nouvel Article
                </h2>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('articles.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="form-label" style="font-weight: 600; color: var(--dark);">
                            <i class="fas fa-heading"></i> Titre de l'article
                        </label>
                        <input type="text" id="title" name="title" class="form-control form-control-lg" 
                               value="{{ old('title') }}" required
                               placeholder="Ex: Les droits des locataires...">
                        @error('title')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="content" class="form-label" style="font-weight: 600; color: var(--dark);">
                            <i class="fas fa-file-alt"></i> Contenu de l'article
                        </label>
                        <textarea id="content" name="content" class="form-control" rows="12" required
                                  placeholder="Écrivez votre article ici...">{{ old('content') }}</textarea>
                        <small class="form-text text-muted mt-2">
                            <i class="fas fa-info-circle"></i> Soyez détaillé et explicite pour aider les clients
                        </small>
                        @error('content')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Publier l'article
                        </button>
                        <a href="{{ route('articles.dashboard') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white;">
            <div class="card-body">
                <h5 class="card-title" style="font-weight: 700;">Conseils pour votre article</h5>
                <ul style="font-size: 0.9rem; margin-bottom: 0;">
                    <li><strong>Titre accrocheur</strong> - Résumez le sujet en quelques mots</li>
                    <li><strong>Structure claire</strong> - Utilisez des paragraphes</li>
                    <li><strong>Contenu utile</strong> - Répondez aux questions communes</li>
                    <li><strong>Professionnalisme</strong> - Soyez précis et factuel</li>
                    <li><strong>Détails importants</strong> - Incluez les cas pratiques</li>
                </ul>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="card-title" style="font-weight: 700; color: var(--dark);">
                    <i class="fas fa-lightbulb"></i> Sujets populaires
                </h6>
                <ul style="font-size: 0.9rem; margin-bottom: 0; color: #6b7280;">
                    <li>Droit du travail</li>
                    <li>Droit de la famille</li>
                    <li>Contrats et obligations</li>
                    <li>Question de propriété</li>
                    <li>Conseils fiscaux</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    textarea {
        font-family: 'Inter', sans-serif;
        resize: vertical;
    }
</style>
@endsection
