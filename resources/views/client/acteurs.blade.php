@extends('layouts.app')
@section('title', 'Annuaire des acteurs juridiques')
@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 style="color: var(--dark); font-weight: 700;">Acteurs juridiques</h1>
        <p style="color: #6b7280;">Retrouvez les professionnels disponibles sur la plateforme.</p>
    </div>
</div>

<div class="d-flex flex-column gap-4">
    @foreach($acteurs as $acteur)
        <div class="card">
            <div class="row g-0">
                @if($acteur->photo_professionnelle)
                    <div class="col-md-4">
                        <img src="{{ asset('storage/'.$acteur->photo_professionnelle) }}" alt="Photo {{ $acteur->nom }}" class="img-fluid rounded-start" style="height:100%;object-fit:cover;">
                    </div>
                @endif
                <div class="col-md-8">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title" style="font-weight:700;"><a href="{{ route('client.acteur.show', ['user' => $acteur->id]) }}" class="text-decoration-none text-dark">{{ $acteur->nom }}</a></h5>
                        <p class="card-subtitle mb-2 text-muted">
                            {{ $acteur->profession?->nom ?? $acteur->profession_libre ?? 'Non renseignée' }}
                        </p>
                        <p class="card-text flex-grow-1" style="font-size:0.9rem;">{{ Str::limit($acteur->description, 120) }}</p>
                        <div class="mt-3">
                            @if(Auth::user()->canAccessResponses())
                                <a href="{{ route('messages.conversation', ['user' => $acteur->id]) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-envelope"></i> Contacter
                                </a>
                            @else
                                <span class="text-muted" title="Abonnement requis">✉️ abonnement requis</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-4">
    {{ $acteurs->links() }}
</div>
@endsection