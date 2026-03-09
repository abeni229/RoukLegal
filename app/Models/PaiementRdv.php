<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaiementRdv extends Model
{
    protected $table = 'paiements_rdv';

    protected $fillable = [
        'rdv_id', 'user_id', 'montant', 'methode',
        'statut', 'paygate_reference', 'remboursement_at',
    ];

    protected $casts = [
        'remboursement_at' => 'datetime',
    ];

    public function rdv()
    {
        return $this->belongsTo(RendezVous::class, 'rdv_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function genererReference(): string
    {
        return 'PG-SANDBOX-' . strtoupper(uniqid());
    }
}