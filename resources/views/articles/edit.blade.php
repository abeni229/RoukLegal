@extends('layouts.app')
@section('title', 'Éditer Article')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="font-weight: 700; color: var(--dark); margin-bottom: 2rem;">
                    <i class="fas fa-edit"></i> Éditer votre article
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

                <form method="POST" action="{{ route('articles.update', $article->id) }}">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="form-label" style="font-weight: 600; color: var(--dark);">
                            <i class="fas fa-heading"></i> Titre de l'article
                        </label>
                        <input type="text" id="title" name="title" class="form-control form-control-lg" 
                               value="{{ $article->title }}" required>
                        @error('title')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="content" class="form-label" style="font-weight: 600; color: var(--dark);">
                            <i class="fas fa-file-alt"></i> Contenu de l'article
                        </label>
                        <textarea id="content" name="content" class="form-control" rows="12" required>{{ $article->content }}</textarea>
                        @error('content')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Mettre à jour
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
        <div class="card">
            <div class="card-body">
                <h6 class="card-title" style="font-weight: 700; color: var(--dark);">
                    <i class="fas fa-chart-bar"></i> Statistiques
                </h6>
                <div style="margin-bottom: 1rem;">
                    <small style="color: #6b7280;">Vues:</small>
                    <p style="margin: 0; font-weight: 600; color: var(--primary);">{{ $article->views }}</p>
                </div>
                <div style="margin-bottom: 1rem;">
                    <small style="color: #6b7280;">Questions:</small>
                    <p style="margin: 0; font-weight: 600; color: var(--primary);">{{ $article->questions()->count() }}</p>
                </div>
                <div>
                    <small style="color: #6b7280;">Publié le:</small>
                    <p style="margin: 0; font-weight: 600;">{{ $article->created_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="card-title" style="font-weight: 700; color: var(--dark);">
                    <i class="fas fa-actions"></i> Actions
                </h6>
                <a href="{{ route('articles.show', $article->id) }}" class="btn btn-sm btn-info w-100 mb-2">
                    <i class="fas fa-eye"></i> Voir public
                </a>
                <a href="{{ route('articles.dashboard') }}" class="btn btn-sm btn-secondary w-100">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
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
