@extends('layouts.app')
@section('title', 'Paramètres')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="font-weight: 700; color: var(--dark); margin-bottom: 2rem;">
                    <i class="fas fa-cog"></i> Paramètres du compte
                </h2>

                @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i> {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="nom" class="form-label" style="font-weight: 600; color: var(--dark);">
                            <i class="fas fa-user"></i> Nom complet
                        </label>
                        <input type="text" id="nom" name="nom" class="form-control" value="{{ old('nom', $user->nom) }}">
                        @error('nom')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label" style="font-weight: 600; color: var(--dark);">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                        @error('email')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="profile_photo" class="form-label" style="font-weight: 600; color: var(--dark);">
                            <i class="fas fa-user"></i> Photo de profil
                        </label>
                        @if($user->profile_photo)
                            <div class="mb-2 d-flex align-items-center gap-3">
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Photo de profil" class="rounded" style="width:100px; height:100px; object-fit:cover;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="remove_photo" name="remove_photo">
                                    <label class="form-check-label" for="remove_photo">
                                        Supprimer la photo
                                    </label>
                                </div>
                            </div>
                        @endif
                        <input type="file" id="profile_photo" name="profile_photo" class="form-control">
                        @error('profile_photo')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="theme" class="form-label" style="font-weight: 600; color: var(--dark);">
                            <i class="fas fa-adjust"></i> Thème
                        </label>
                        <select name="theme" id="theme" class="form-select">
                            <option value="light" {{ $user->theme === 'light' ? 'selected' : '' }}>Clair</option>
                            <option value="dark" {{ $user->theme === 'dark' ? 'selected' : '' }}>Sombre</option>
                        </select>
                        @error('theme')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-primary btn-lg" type="submit">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                    <a href="{{ auth()->user()->role==='acteur_juridique' ? route('acteur.dashboard') : route('client.dashboard') }}" class="btn btn-secondary btn-lg ms-2">
                        <i class="fas fa-arrow-left"></i> Retour au tableau de bord
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection