<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    use HasFactory;

    protected $table = 'rendez_vous';

    protected $fillable = [
        'user_id', 'acteurjuridique_id', 'date_heure', 'statut', 'sujet'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function acteur()
    {
        return $this->belongsTo(User::class, 'acteurjuridique_id');
    }
}
