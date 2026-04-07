<?php

namespace App\Http\Controllers;

use App\Models\Creneau;
use App\Models\PaiementRdv;
use App\Models\RendezVous;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\InitierPaiementRequest;
use App\Services\ReservationService;

class RendezVousController extends Controller
{
    const STATUT_PAYE            = 'paye';
    const STATUT_VALIDE_ADMIN    = 'valide_admin';
    const STATUT_CONFIRME_ACTEUR = 'confirme_acteur';
    const STATUT_REFUSE          = 'refuse';
    const STATUT_REMBOURSE       = 'rembourse';

    // ── CLIENT ──────────────────────────────────

    public function reserver(User $acteur)
    {
        abort_if($acteur->role !== 'acteur_juridique', 404);
        $creneaux = Creneau::where('acteurjuridique_id', $acteur->id)
            ->where('actif', true)
            ->orderByRaw("FIELD(jour_semaine,'lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche')")
            ->orderBy('heure_debut')
            ->get()->groupBy('jour_semaine');
        return view('client.reserver', compact('acteur', 'creneaux'));
    }

 public function initierPaiement(InitierPaiementRequest $request, User $acteur, ReservationService $reservationService)
{
    abort_if($acteur->role !== 'acteur_juridique', 404);

    try {
        $reservationService->reserverAvecPaiement(
            $request->validated(),
            $acteur,
            Auth::id()
        );
    } catch (\Exception $e) {
        return back()->withErrors(['date_heure' => $e->getMessage()]);
    }

    return redirect()->route('client.rendezVous')
        ->with('status', 'RDV réservé et paiement confirmé. En attente de validation admin.');
}

    public function clientIndex()
    {
        $rdvs = RendezVous::where('user_id', Auth::id())
            ->with(['acteur', 'paiement'])->orderByDesc('date_heure')->paginate(10);
        return view('client.rendez-vous', compact('rdvs'));
    }

    // ── ACTEUR ──────────────────────────────────

    public function acteurIndex()
    {
        $rdvs = RendezVous::where('acteurjuridique_id', Auth::id())
            ->with(['client', 'paiement'])->orderByDesc('date_heure')->paginate(10);
        return view('acteur.rendez-vous', compact('rdvs'));
    }

    public function confirmer(RendezVous $rdv)
    {
        abort_if($rdv->acteurjuridique_id !== Auth::id(), 403);
        abort_if(!in_array($rdv->statut_paiement, [self::STATUT_VALIDE_ADMIN, 'valide_admin', 'validé_admin']), 403);
        $rdv->update(['statut' => 'confirme', 'statut_paiement' => self::STATUT_CONFIRME_ACTEUR]);
        return back()->with('status', 'Rendez-vous confirmé.');
    }

    public function refuser(RendezVous $rdv)
    {
        abort_if($rdv->acteurjuridique_id !== Auth::id(), 403);
        abort_if(!in_array($rdv->statut_paiement, [self::STATUT_VALIDE_ADMIN, 'valide_admin', 'validé_admin']), 403);
        DB::transaction(function () use ($rdv) {
            $rdv->update(['statut' => 'annule', 'statut_paiement' => self::STATUT_REMBOURSE]);
            $rdv->paiement?->update(['statut' => 'rembourse', 'remboursement_at' => now()]);
        });
        return back()->with('status', 'RDV refusé. Le client sera remboursé.');
    }

    // ── ADMIN ──────────────────────────────────

    public function adminIndex()
    {
        $rdvs = RendezVous::with(['client', 'acteur', 'paiement'])
            ->orderByDesc('created_at')->paginate(15);
        $stats = [
        'total'         => RendezVous::count(),
        'en_attente'    => RendezVous::whereIn('statut_paiement', ['paye', 'payé'])->count(),
        'validés'       => RendezVous::whereIn('statut_paiement', ['valide_admin', 'validé_admin'])->count(),
        'confirmés'     => RendezVous::whereIn('statut_paiement', ['confirme_acteur', 'confirmé_acteur'])->count(),
        'remboursés'    => RendezVous::whereIn('statut_paiement', ['rembourse', 'remboursé'])->count(),
        'revenus_total' => RendezVous::whereIn('statut_paiement', ['confirme_acteur', 'confirmé_acteur'])->sum('commission_admin'),
    ];
        return view('admin.rendez-vous', compact('rdvs', 'stats'));
    }

    public function validerAdmin(RendezVous $rdv)
    {
        abort_if(!in_array($rdv->statut_paiement, ['paye', 'payé']), 403);
        $rdv->update(['statut_paiement' => self::STATUT_VALIDE_ADMIN]);
        return back()->with('status', 'Paiement validé. L\'acteur peut confirmer le rendez-vous.');
    }

    public function rembourserAdmin(RendezVous $rdv)
    {
        abort_if(!in_array($rdv->statut_paiement, ['paye', 'payé', 'valide_admin', 'validé_admin']), 403);
        DB::transaction(function () use ($rdv) {
            $rdv->update(['statut' => 'annule', 'statut_paiement' => self::STATUT_REMBOURSE]);
            $rdv->paiement?->update(['statut' => 'rembourse', 'remboursement_at' => now()]);
        });
        return back()->with('status', 'Remboursement effectué.');
    }
}