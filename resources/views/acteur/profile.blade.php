@extends('layouts.app')
@section('title', 'Mon Profil - Acteur Juridique')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="font-weight: 700; color: var(--dark); margin-bottom: 2rem;">
                    <i class="fas fa-user-cog"></i> Modifier votre profil professionnel
                </h2>

                @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i> {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('acteur.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="profession_id" class="form-label" style="font-weight: 600; color: var(--dark);">
                            <i class="fas fa-briefcase"></i> Choisir votre spécialité juridique
                        </label>
                        <select id="profession_id" name="profession_id" class="form-select form-control-lg">
                            <option value="">-- Sélectionnez une spécialité --</option>
                            @foreach($professions as $prof)
                                <option value="{{ $prof->id }}" {{ $user->profession_id == $prof->id ? 'selected' : '' }}>
                                    {{ $prof->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('profession_id')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="profession_libre" class="form-label" style="font-weight: 600; color: var(--dark);">
                            <i class="fas fa-pencil-alt"></i> Autre spécialité (si non listée)
                        </label>
                        <input type="text" id="profession_libre" name="profession_libre" class="form-control" value="{{ old('profession_libre', $user->profession_libre) }}" placeholder="Entrez votre profession exact...">
                        @error('profession_libre')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="photo_professionnelle" class="form-label" style="font-weight: 600; color: var(--dark);">
                            <i class="fas fa-camera"></i> Photo professionnelle
                        </label>
                        @if($user->photo_professionnelle)
                            <div class="mb-2 d-flex align-items-center gap-3">
                                <img src="{{ asset('storage/' . $user->photo_professionnelle) }}" alt="Photo pro" class="img-fluid rounded" style="max-height:150px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="remove_professional" name="remove_professional">
                                    <label class="form-check-label" for="remove_professional">
                                        Supprimer la photo
                                    </label>
                                </div>
                            </div>
                        @endif
                        <input type="file" id="photo_professionnelle" name="photo_professionnelle" class="form-control">
                        <small class="form-text text-muted mt-2">
                            Formats acceptés : jpeg/png, taille max 2 Mo.
                        </small>
                        @error('photo_professionnelle')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label" style="font-weight: 600; color: var(--dark);">
                            <i class="fas fa-pencil-alt"></i> Votre description professionnelle
                        </label>
                        <textarea id="description" name="description" class="form-control" rows="6" placeholder="Présentez-vous, vos expériences et domaines d'expertise...">{{ $user->description }}</textarea>
                        <small class="form-text text-muted mt-2">
                            <i class="fas fa-info-circle"></i> Décrivez votre profil professionnel en détail (expériences, formations, domaines d'expertise, etc.)
                        </small>
                        @error('description')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-primary btn-lg" type="submit">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                        <a href="{{ route('acteur.dashboard') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white;">
            <div class="card-body text-center">
                <i class="fas fa-info-circle" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <h5 class="card-title" style="font-weight: 700;">Conseils pour votre profil</h5>
                <ul style="text-align: left; font-size: 0.9rem; opacity: 0.95; margin-bottom: 0;">
                    <li>✓ Spécifiez votre spécialité juridique</li>
                    <li>✓ Listez vos domaines d'expertise</li>
                    <li>✓ Mentionnez vos formations</li>
                    <li>✓ Décrivez votre expérience</li>
                    <li>✓ Soyez précis et professionnel</li>
                </ul>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="card-title" style="font-weight: 700; color: var(--dark);">
                    <i class="fas fa-briefcase"></i> Spécialité actuelle
                </h6>
                <p style="margin: 0; color: var(--primary); font-weight: 600;">
                    {{ $user->profession?->nom ?? $user->profession_libre ?? 'Non définie' }}
                </p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="card-title" style="font-weight: 700; color: var(--dark);">
                    <i class="fas fa-article"></i> Vos articles
                </h6>
                <p style="margin: 0.5rem 0;">
                    <a href="{{ route('articles.dashboard') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-arrow-right"></i> Gérer vos articles
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection