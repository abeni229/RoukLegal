<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Question;
use App\Models\Reponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $clients = User::where('role', 'client')->count();
        $acteurs = User::where('role', 'acteur_juridique')->count();
        $questions = Question::count();
        $reponses = Reponse::count();

        // utilisateurs en essai gratuit
        $trials = User::where('role','client')
            ->whereNotNull('trial_end')
            ->where('trial_end', '>=', now())
            ->count();

        // progression mensuelle des paiements
        $paymentsByMonth = \App\Models\Paiement::selectRaw("DATE_FORMAT(date_paiement, '%Y-%m') as month, COUNT(*) as count, SUM(montant) as total")
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(6)
            ->get();

        // répartition par méthode de paiement
        $paymentsByMethod = \App\Models\Paiement::select('methode', \DB::raw('COUNT(*) as count'), \DB::raw('SUM(montant) as total'))
            ->groupBy('methode')
            ->get();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'clients' => $clients,
            'acteurs' => $acteurs,
            'questions' => $questions,
            'reponses' => $reponses,
            'trials' => $trials,
            'paymentsByMonth' => $paymentsByMonth,
            'paymentsByMethod' => $paymentsByMethod,
            'withSidebar' => true
        ]);
    }
}
