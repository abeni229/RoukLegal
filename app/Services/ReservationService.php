<?php

namespace App\Services;

use App\Models\Creneau;
use App\Models\PaiementRdv;
use App\Models\RendezVous;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class ReservationService
{
    /**
     * Tente de réserver un rendez-vous et d'initier son paiement de façon atomique.
     * 
     * @return RendezVous L'instance du RDV nouvellement créé.
     * @throws Exception S'il y a un conflit d'horaire ou si le créneau est invalide.
     */
    public function reserverAvecPaiement(array $data, User $acteur, int $userId): RendezVous
    {
        $creneau = Creneau::where('id', $data['creneau_id'])
            ->where('acteurjuridique_id', $acteur->id)
            ->where('actif', true)
            ->firstOrFail();

        // Constants can be accessed from model globally or service
        $conflit = RendezVous::where('acteurjuridique_id', $acteur->id)
            ->where('date_heure', $data['date_heure'])
            ->whereNotIn('statut_paiement', ['refuse', 'rembourse'])
            ->exists();

        if ($conflit) {
            throw new Exception("Ce créneau est déjà réservé.");
        }

        return DB::transaction(function () use ($data, $acteur, $creneau, $userId) {
            $rdv = RendezVous::create([
                'user_id'            => $userId,
                'acteurjuridique_id' => $acteur->id,
                'creneau_id'         => $creneau->id,
                'date_heure'         => $data['date_heure'],
                'sujet'              => $data['sujet'],
                'statut'             => 'en_attente',
                'montant'            => 10000,
                'statut_paiement'    => 'paye', // Idéalement, Enum StatutPaiement::PAYE plus tard
                'commission_admin'   => 2000,
                'commission_acteur'  => 8000,
            ]);

            $paiement = PaiementRdv::create([
                'rdv_id'            => $rdv->id,
                'user_id'           => $userId,
                'montant'           => 10000,
                'methode'           => $data['methode'],
                'statut'            => 'confirme',
                'paygate_reference' => PaiementRdv::genererReference(),
            ]);

            $rdv->update(['paiement_id' => $paiement->paygate_reference]);

            return $rdv;
        });
    }
}
