<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Affiche le tableau de bord client.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $questionsCount = $user->questions()->count();
        $paymentsCount = $user->paiements()->count();

        return view('client.dashboard', [
            'questionsCount' => $questionsCount,
            'paymentsCount' => $paymentsCount,
            'withSidebar' => true
        ]);
    }

    /**
     * Affiche tous les articles disponibles
     */
    public function articles()
    {
        $articles = Article::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        
        return view('client.articles', [
            'articles' => $articles,
            'withSidebar' => true
        ]);
    }

    /**
     * Démarre l'essai gratuit pour le client
     */
    public function startFreeTrial(Request $request)
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur est un client
        if ($user->role !== 'client') {
            return response()->json(['success' => false, 'message' => 'Accès non autorisé']);
        }
        
        // Vérifier si l'utilisateur a déjà un essai ou un abonnement
        if ($user->canAccessResponses()) {
            return response()->json(['success' => false, 'message' => 'Vous avez déjà accès aux fonctionnalités premium']);
        }
        
        // Démarrer l'essai gratuit
        $user->startFreeTrial();
        
        return response()->json(['success' => true, 'message' => 'Essai gratuit activé avec succès']);
    }

    /**
     * Liste tous les acteurs juridiques pour un client.
     */
    public function actors()
    {
        $acteurs = User::where('role', 'acteur_juridique')
            ->orderBy('nom')
            ->paginate(12);

        return view('client.acteurs', [
            'acteurs' => $acteurs,
            'withSidebar' => true
        ]);
    }

    /**
     * Affiche le profil public d'un acteur pour un client.
     */
    public function showActor(User $user)
    {
        if ($user->role !== 'acteur_juridique') {
            abort(404);
        }

        return view('client.acteur', [
            'acteur' => $user,
            'withSidebar' => true
        ]);
    }
}
