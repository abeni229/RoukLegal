@extends('layouts.app')
@section('title', 'Choisir votre rôle')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card" style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white; border: none;">
            <div class="card-body text-center py-5">
                <h2 class="card-title" style="font-weight: 700; margin-bottom: 1rem;">
                    <i class="fas fa-user-tie"></i> Bienvenue, {{ Auth::user()->nom }}!
                </h2>
                <p style="font-size: 1.1rem; margin-bottom: 2rem; opacity: 0.95;">
                    Sélectionnez votre rôle pour accéder à votre tableau de bord
                </p>
            </div>
        </div>

        <div class="row g-4 mt-2">
            <!-- Client Option -->
            <div class="col-md-6">
                <form method="POST" action="{{ route('auth.selectRole') }}" class="h-100">
                    @csrf
                    <input type="hidden" name="role" value="client">
                    <button type="submit" class="btn btn-white h-100 w-100 p-4" style="border: 2px solid var(--primary); background: white; text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center; border-radius: 0.75rem; transition: all 0.3s;">
                        <i class="fas fa-user" style="font-size: 3rem; color: var(--primary); margin-bottom: 1rem;"></i>
                        <h5 style="color: var(--dark); font-weight: 700; margin: 0;">Client</h5>
                        <p style="color: #6b7280; font-size: 0.9rem; margin-top: 0.5rem; margin-bottom: 0;">
                            Posez vos questions juridiques
                        </p>
                    </button>
                </form>
            </div>

            <!-- Acteur Juridique Option -->
            <div class="col-md-6">
                <form method="POST" action="{{ route('auth.selectRole') }}" class="h-100">
                    @csrf
                    <input type="hidden" name="role" value="acteur_juridique">
                    <button type="submit" class="btn btn-white h-100 w-100 p-4" style="border: 2px solid var(--secondary); background: white; text-align: center; display: flex; flex-direction: column; justify-content: center; align-items: center; border-radius: 0.75rem; transition: all 0.3s;">
                        <i class="fas fa-briefcase" style="font-size: 3rem; color: var(--secondary); margin-bottom: 1rem;"></i>
                        <h5 style="color: var(--dark); font-weight: 700; margin: 0;">Acteur Juridique</h5>
                        <p style="color: #6b7280; font-size: 0.9rem; margin-top: 0.5rem; margin-bottom: 0;">
                            Répondez aux questions
                        </p>
                    </button>
                </form>
            </div>
        </div>

        <div class="text-center mt-4">
            <p style="color: #6b7280;">
                <strong>Attention :</strong> Ce choix est définitif. Vous ne pourrez pas changer de rôle ultérieurement.
            </p>
        </div>
    </div>
</div>

<style>
    .btn-white:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection
