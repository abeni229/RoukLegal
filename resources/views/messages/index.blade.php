@extends('layouts.app')
@section('title', 'Mes conversations')
@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="fw-bold">Mes conversations</h2>
        @php
            $home = Auth::user() && Auth::user()->role === 'acteur_juridique' ? route('acteur.dashboard') : route('client.dashboard');
        @endphp
        <a href="{{ $home }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Retour au tableau de bord
        </a>
    </div>
    <div class="col-12">
        <p class="text-muted">Choisissez une conversation pour échanger</p>
    </div>
</div>

<div class="list-group">
    @forelse($users as $u)
        <a href="{{ route('messages.conversation', ['user' => $u->id]) }}" class="list-group-item list-group-item-action">
            {{ $u->nom }}
            <small class="text-muted d-block">
                {{ $u->role === 'acteur_juridique' ? 'Professionnel' : ($u->role === 'client' ? 'Client' : '') }}
            </small>
        </a>
    @empty
        <p>Aucune conversation pour le moment.</p>
    @endforelse
</div>
@endsection