<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    protected $table = 'rendez_vous';

    protected $fillable = [
        'user_id', 'acteurjuridique_id', 'creneau_id',
        'date_heure', 'statut', 'sujet',
        'montant', 'statut_paiement', 'paiement_id',
        'commission_admin', 'commission_acteur',
    ];

    protected $casts = [
        'date_heure' => 'datetime',
        'montant'    => 'integer',
    ];

    const STATUTS_PAIEMENT = [
        'en_attente'       => ['label' => 'En attente',       'color' => 'orange'],
        'payé'             => ['label' => 'Payé',             'color' => 'blue'],
        'validé_admin'     => ['label' => 'Validé admin',     'color' => 'blue'],
        'confirmé_acteur'  => ['label' => 'Confirmé',         'color' => 'green'],
        'refusé'           => ['label' => 'Refusé',           'color' => 'red'],
        'remboursé'        => ['label' => 'Remboursé',        'color' => 'purple'],
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function acteur()
    {
        return $this->belongsTo(User::class, 'acteurjuridique_id');
    }

    public function creneau()
    {
        return $this->belongsTo(Creneau::class);
    }

    public function paiement()
    {
        return $this->hasOne(PaiementRdv::class, 'rdv_id');
    }

    public function getStatutLabelAttribute(): string
    {
        return self::STATUTS_PAIEMENT[$this->statut_paiement]['label'] ?? $this->statut_paiement;
    }

    public function getStatutColorAttribute(): string
    {
        return self::STATUTS_PAIEMENT[$this->statut_paiement]['color'] ?? 'gray';
    }

    public function peutEtreRembourse(): bool
    {
        return in_array($this->statut_paiement, ['payé', 'validé_admin'])
            && $this->created_at->diffInHours(now()) >= 24;
    }
}