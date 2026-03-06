@extends('layouts.app')
@section('title', 'Profil de ' . $acteur->nom)
@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">{{ $acteur->nom }}</h2>
        <p class="text-muted">
            {{ $acteur->profession?->nom ?? $acteur->profession_libre ?? 'Profession non renseignée' }}
        </p>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        @if($acteur->photo_professionnelle)
            <img src="{{ asset('storage/'.$acteur->photo_professionnelle) }}" class="img-fluid rounded mb-3" alt="Photo {{ $acteur->nom }}">
        @endif
        <div class="mb-3">
            <a href="{{ route('messages.conversation', ['user'=>$acteur->id]) }}" class="btn btn-primary w-100 {{ Auth::user()->canAccessResponses() ? '' : 'disabled' }}">
                <i class="fas fa-envelope"></i> Contacter
            </a>
            @if(!Auth::user()->canAccessResponses())
                <small class="text-danger">(abonnement requis)</small>
            @endif
        </div>
    </div>
    <div class="col-md-8">
        <h5>Description professionnelle</h5>
        <p>{{ $acteur->description ?? 'Aucune description fournie.' }}</p>
        <h5>Articles publiés</h5>
        @if($acteur->articles->count())
            <ul>
                @foreach($acteur->articles as $article)
                    <li><a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a></li>
                @endforeach
            </ul>
        @else
            <p>Aucun article publié.</p>
        @endif
    </div>
</div>
@endsection