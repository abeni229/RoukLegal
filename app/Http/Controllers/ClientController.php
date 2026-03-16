<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    /**
     * Affiche le tableau de bord client.
     */
    public function dashboard()
    {
        try {
            $user = Auth::user();

            $stats        = $this->getDashboardStats($user);
            $subscription = $this->getSubscriptionStatus($user);
            $recentQuestions = $this->getRecentQuestions($user);

            return view('client.dashboard', array_merge($stats, $subscription, [
                'recentQuestions' => $recentQuestions,
                'withSidebar'     => true,
            ]));
        } catch (\Exception $e) {
            Log::error('Erreur dashboard client : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue.');
        }
    }

    /**
     * Affiche tous les articles disponibles.
     */
    public function articles()
    {
        $articles = Article::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('client.articles', [
            'articles'    => $articles,
            'withSidebar' => true,
        ]);
    }

    /**
     * Démarre l'essai gratuit pour le client.
     */
    public function startFreeTrial(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'client') {
            return response()->json(['success' => false, 'message' => 'Accès non autorisé']);
        }

        if ($user->canAccessResponses()) {
            return response()->json(['success' => false, 'message' => 'Vous avez déjà accès aux fonctionnalités premium']);
        }

        $user->startFreeTrial();

        return response()->json(['success' => true, 'message' => 'Essai gratuit activé avec succès ! Vous disposez de 7 jours.']);
    }

    /**
     * Liste tous les acteurs juridiques pour un client.
     */
    public function actors()
    {
       // Récupérer seulement les acteurs abonnés
$acteurs = User::where('role', 'acteur_juridique')
    ->whereHas('paiements', function($q) {
        $q->where('formule', 'trimestriel')
          ->whereNotNull('expiry_date')
          ->where('expiry_date', '>=', now());
    })
    ->with('profession')
    ->paginate(12);

        return view('client.acteurs', [
            'acteurs'     => $acteurs,
            'withSidebar' => true,
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
            'acteur'      => $user,
            'withSidebar' => true,
        ]);
    }

    /**
     * Affiche les questions du client.
     */
    public function questions()
    {
        $user = Auth::user();

        $questions = $user->questions()
            ->with(['reponses.acteur',  'article'])
            ->latest()
            ->paginate(10);

        return view('client.questions', [
            'questions'   => $questions,
            'withSidebar' => true,
        ]);
    }

    /**
     * Affiche les rendez-vous du client.
     */
    public function rendezVous()
    {
        $user = Auth::user();

        $rdvs = $user->rendezVous()
            ->with(['acteurJuridique', 'paiementRdv'])
            ->latest('date_heure')
            ->paginate(10);

        return view('client.rendez-vous', [
            'rdvs'        => $rdvs,
            'withSidebar' => true,
        ]);
    }

    /**
     * Affiche le formulaire de réservation pour un acteur donné.
     */
    public function reserver(User $acteur)
    {
        if ($acteur->role !== 'acteur_juridique') {
            abort(404);
        }

        $creneaux = $acteur->creneaux()
            ->where('actif', true)
            ->get()
            ->groupBy('jour_semaine');

        return view('client.reserver', [
            'acteur'      => $acteur,
            'creneaux'    => $creneaux,
            'withSidebar' => true,
        ]);
    }

    // -----------------------------------------------------------------------
    //  Méthodes privées
    // -----------------------------------------------------------------------

    /**
     * Statistiques de base du client.
     */
    private function getDashboardStats(User $user): array
    {
        return [
            'questionsCount' => $user->questions()->count(),
            'paymentsCount'  => $user->paiements()->count(),
        ];
    }

    /**
     * Statut d'abonnement / essai gratuit du client.
     */
    private function getSubscriptionStatus(User $user): array
    {
        $now = now();

        if ($user->trial_end && $user->trial_end >= $now) {
            return [
                'subscriptionType'     => 'trial',
                'subscriptionLabel'    => 'Essai gratuit',
                'subscriptionExpiry'   => $user->trial_end,
                'subscriptionDaysLeft' => (int) $now->diffInDays($user->trial_end),
            ];
        }

                // Abonnement payant actif
        $lastPaiement = $user->paiements()
            ->whereNotNull('expiry_date')
            ->where('expiry_date', '>=', $now)
            ->latest('created_at')
            ->first();

        if ($lastPaiement) {
            return [
                'subscriptionType'     => 'active',
                'subscriptionLabel'    => 'Abonnement actif',
                'subscriptionExpiry'   => $lastPaiement->expiry_date,
                'subscriptionDaysLeft' => (int) $now->diffInDays($lastPaiement->expiry_date),
            ];
        }

        if ($user->trial_end && $user->trial_end < $now) {
            return [
                'subscriptionType'     => 'expired',
                'subscriptionLabel'    => 'Essai expiré',
                'subscriptionExpiry'   => $user->trial_end,
                'subscriptionDaysLeft' => 0,
            ];
        }

        return [
            'subscriptionType'     => 'none',
            'subscriptionLabel'    => 'Aucun abonnement',
            'subscriptionExpiry'   => null,
            'subscriptionDaysLeft' => 0,
        ];
    }

    /**
     * 5 questions les plus récentes du client avec leurs réponses.
     */
    private function getRecentQuestions(User $user)
    {
        return $user->questions()
            ->with('reponses')
            ->latest()
            ->limit(5)
            ->get();
    }

    /**
     * Affiche la page de choix d'abonnement.
     */
public function abonnement()
{
    $user         = Auth::user();
    $subscription = $this->getSubscriptionStatus($user);
    $historique   = $user->paiements()
        ->where('formule', 'annuel')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('client.abonnement', array_merge($subscription, [
        'historique'  => $historique,
        'withSidebar' => true,
    ]));
}

public function payerAbonnement(Request $request)
{
    $request->validate(['formule' => 'required|in:annuel']);

    $montant = 5000;
    $mois    = 12;
    $expiry  = now()->addMonths($mois);

    $paiement = \App\Models\Paiement::create([
        'user_id'       => Auth::id(),
        'montant'       => $montant,
        'methode'       => 'sandbox',
        'statut'        => 'paye',
        'date_paiement' => now(),
        'formule'       => 'annuel',
        'expiry_date'   => $expiry,
    ]);

    Auth::user()->update([
        'is_subscribed'     => true,
        'subscription_end'  => $expiry,
    ]);

    return redirect()->route('client.abonnement')->with('status', 'Abonnement annuel activé jusqu\'au '.$expiry->format('d/m/Y').'.');
}


}