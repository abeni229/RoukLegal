<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandeRetrait extends Model
{
    protected $table = 'demandes_retrait';

    protected $fillable = [
        'user_id',
        'montant',
        'methode',
        'numero_compte',
        'statut',
        'note_admin',
    ];

    public function acteur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}