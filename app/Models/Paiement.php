<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $table = 'paiements';

    protected $fillable = [
        'user_id',
        'acteurjuridique_id',
        'question_id',
        'montant',
        'methode',
        'statut',
        'date_paiement',
        'formule',
        'expiry_date',
    ];

    protected $casts = [
        'date_paiement' => 'datetime',
        'expiry_date'   => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function acteur()
    {
        return $this->belongsTo(User::class, 'acteurjuridique_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}