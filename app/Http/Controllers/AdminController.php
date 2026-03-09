<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Question;
use App\Models\Reponse;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    /**
     * Affiche le tableau de bord de l'administrateur.
     */
    public function dashboard()
    {
        try {
            $stats        = $this->getGeneralStats();
            $paymentStats = $this->getPaymentStats();

            return view('admin.dashboard', array_merge($stats, $paymentStats, [
                'withSidebar' => true,
            ]));
        } catch (\Exception $e) {
            Log::error('Erreur chargement dashboard admin : ' . $e->getMessage());

            return redirect()->back()->with(
                'error',
                'Une erreur est survenue lors du chargement du tableau de bord.'
            );
        }
    }

    // -----------------------------------------------------------------------
    //  Méthodes privées
    // -----------------------------------------------------------------------

    /**
     * Statistiques générales (utilisateurs, questions, réponses, essais).
     */
    private function getGeneralStats(): array
    {
        // Mise en cache 10 minutes pour éviter trop de requêtes
        return Cache::remember('admin.general_stats', 600, function () {
            return [
                'totalUsers' => User::count(),
                'clients'    => User::where('role', 'client')->count(),
                'acteurs'    => User::where('role', 'acteur_juridique')->count(),
                'questions'  => Question::count(),
                'reponses'   => Reponse::count(),
                'trials'     => $this->getActiveTrialsCount(),
            ];
        });
    }

    /**
     * Nombre de clients actuellement en essai gratuit actif.
     */
    private function getActiveTrialsCount(): int
    {
        return User::where('role', 'client')
            ->whereNotNull('trial_end')
            ->where('trial_end', '>=', now())
            ->count();
    }

    /**
     * Statistiques de paiements : progression mensuelle + répartition par méthode.
     */
    private function getPaymentStats(): array
    {
        $paymentsByMonth = Cache::remember('admin.payments_by_month', 600, function () {
            return Paiement::selectRaw(
                    "DATE_FORMAT(date_paiement, '%Y-%m') as month,
                     COUNT(*) as count,
                     SUM(montant) as total"
                )
                ->groupBy('month')
                ->orderBy('month', 'desc')
                ->limit(6)
                ->get();
        });

        $paymentsByMethod = Cache::remember('admin.payments_by_method', 600, function () {
            return Paiement::select(
                    'methode',
                    DB::raw('COUNT(*) as count'),
                    DB::raw('SUM(montant) as total')
                )
                ->groupBy('methode')
                ->get();
        });

        return [
            'paymentsByMonth'  => $paymentsByMonth,
            'paymentsByMethod' => $paymentsByMethod,
        ];
    }

    public function utilisateurs()
{
    $clients = User::where('role', 'client')
        ->orderBy('created_at', 'desc')
        ->paginate(15);

    $acteurs = User::where('role', 'acteur_juridique')
        ->orderBy('created_at', 'desc')
        ->paginate(15);

    $essaisActifs = User::where('role', 'client')
        ->whereNotNull('trial_end')
        ->where('trial_end', '>=', now())
        ->get();

    return view('admin.utilisateurs', compact('clients', 'acteurs', 'essaisActifs'));
}

public function paiements()
{
    $paiements = \App\Models\Paiement::with(['user', 'acteurJuridique'])
        ->orderBy('created_at', 'desc')
        ->paginate(15);

    return view('admin.paiements', compact('paiements'));
}

public function commissions()
{
    $rdvs = \App\Models\RendezVous::with(['client', 'acteur'])
        ->whereIn('statut_paiement', ['confirme_acteur', 'confirmé_acteur'])
        ->orderBy('created_at', 'desc')
        ->paginate(15);

    $totalAdmin = $rdvs->sum('commission_admin');

    return view('admin.commissions', compact('rdvs', 'totalAdmin'));
}
}