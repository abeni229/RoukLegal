@extends('layouts.app')
@section('title', 'Tous les Articles')
@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 style="color: var(--dark); font-weight: 700; margin-bottom: 0.5rem;">
            <i class="fas fa-newspaper"></i> Articles et Blogs Juridiques
        </h1>
        <p style="color: #6b7280;">Découvrez l'expertise de nos professionnels juridiques</p>
    </div>
</div>

<!-- Search & Filter -->
<div class="row mb-4">
    <div class="col-md-6">
        <input type="text" class="form-control" placeholder="Rechercher un article..." id="searchInput">
    </div>
    <div class="col-md-6">
        <select class="form-select" id="professionFilter">
            <option value="">-- Tous les domaines --</option>
            <option value="droit-du-travail">Droit du travail</option>
            <option value="famille">Droit de la famille</option>
            <option value="immobilier">Immobilier</option>
            <option value="entreprise">Droit de l'entreprise</option>
        </select>
    </div>
</div>

@if($articles->count() > 0)
    <div class="d-flex flex-column gap-4">
        @foreach($articles as $article)
            <div class="card h-100 shadow-sm" style="transition: all 0.3s; cursor: pointer;">
                <div style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); 
                            height: 8px;"></div>
                <div class="card-body">
                    <div style="margin-bottom: 1rem;">
                        <div style="display: inline-block; background: #e0e7ff; color: var(--primary); 
                                   padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.8rem; 
                                   font-weight: 600;">
                            {{ $article->user->profession?->nom ?? 'Expert' }}
                        </div>
                    </div>
                    <h5 class="card-title" style="color: var(--dark); font-weight: 700; margin-bottom: 0.75rem; min-height: 3.2rem;">
                        {{ $article->title }}
                    </h5>
                    <p style="color: #6b7280; font-size: 0.95rem; margin-bottom: 1rem; min-height: 2.5rem;">
                        {{ Str::limit(strip_tags($article->content), 100) }}
                    </p>
                    <div style="margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                        <div style="display: flex; gap: 1rem; font-size: 0.85rem; color: #6b7280;">
                            <small><i class="fas fa-eye"></i> {{ $article->views }} vues</small>
                            <small><i class="fas fa-comments"></i> {{ $article->questions()->count() }} questions</small>
                            <small><i class="fas fa-calendar"></i> {{ $article->created_at->format('d M') }}</small>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); 
                                   border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div style="flex: 1;">
                            <p style="margin: 0; font-weight: 600; color: var(--dark); font-size: 0.9rem;">
                                {{ $article->user->nom }}
                            </p>
                            <small style="color: #6b7280;">Expert juridique</small>
                        </div>
                    </div>
                    <a href="{{ route('articles.show', $article->id) }}" class="btn btn-primary w-100">
                        <i class="fas fa-arrow-right"></i> Lire l'article
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $articles->links() }}
    </div>
@else
    <div class="card text-center py-5">
        <div class="card-body">
            <i class="fas fa-newspaper" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem;"></i>
            <h5 class="card-title" style="color: var(--dark); font-weight: 700;">Aucun article disponible</h5>
            <p style="color: #6b7280;">Les articles seront bientôt disponibles</p>
        </div>
    </div>
@endif

<style>
    .card {
        border: none;
        border-radius: 0.75rem;
    }
    
    .card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
        transform: translateY(-5px);
    }
</style>

<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        const query = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            const description = card.querySelector('p').textContent.toLowerCase();
            if (title.includes(query) || description.includes(query)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
@endsection
