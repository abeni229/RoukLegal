@extends('layouts.app')
@section('title', 'Mes Articles')
@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h1 style="color: var(--dark); font-weight: 700; margin-bottom: 0.5rem;">
                <i class="fas fa-newspaper"></i> Mes Articles
            </h1>
            <p style="color: #6b7280; margin: 0;">Gérez vos articles et blogs juridiques</p>
        </div>
        <a href="{{ route('articles.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle"></i> Nouvel article
        </a>
    </div>
</div>

@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        <i class="fas fa-check-circle"></i> {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($articles->isEmpty())
    <div class="card text-center py-5">
        <div class="card-body">
            <i class="fas fa-newspaper" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem;"></i>
            <h5 class="card-title" style="color: var(--dark); font-weight: 700; margin-bottom: 0.5rem;">Aucun article yet</h5>
            <p style="color: #6b7280; margin-bottom: 1.5rem;">Commencez à partager votre expertise et vos expériences</p>
            <a href="{{ route('articles.create') }}" class="btn btn-primary">
                <i class="fas fa-pen-fancy"></i> Créer votre premier article
            </a>
        </div>
    </div>
@else
    <div class="d-flex flex-column gap-4">
        @foreach($articles as $article)
            <div class="card h-100 shadow-sm hover-shadow" style="transition: all 0.3s;">
                <div class="card-body">
                    <h5 class="card-title" style="color: var(--dark); font-weight: 700; margin-bottom: 1rem; min-height: 3rem;">
                        {{ $article->title }}
                    </h5>
                    <div class="mb-3">
                        <small style="color: #6b7280;">
                            <i class="fas fa-calendar"></i> {{ $article->created_at->format('d M Y') }}
                        </small>
                        <br>
                        <small style="color: #6b7280;">
                            <i class="fas fa-eye"></i> {{ $article->views }} vus
                        </small>
                        <br>
                        <small style="color: var(--primary); font-weight: 600;">
                            <i class="fas fa-comments"></i> {{ $article->questions()->count() }} question(s)
                        </small>
                    </div>
                    <p style="color: #6b7280; font-size: 0.9rem; margin-bottom: 1.5rem;">
                        {{ Str::limit(strip_tags($article->content), 100) }}
                    </p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('articles.show', $article->id) }}" class="btn btn-sm btn-info flex-grow-1">
                            <i class="fas fa-eye"></i> Voir
                        </a>
                        <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-sm btn-warning flex-grow-1">
                            <i class="fas fa-edit"></i> Éditer
                        </a>
                        <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display: inline-block; flex-grow: 1;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger w-100" onclick="return confirm('Confirmez la suppression?')">
                                <i class="fas fa-trash"></i> Supp
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<style>
    .hover-shadow:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
        transform: translateY(-5px);
    }
</style>
@endsection
