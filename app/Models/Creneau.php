<?php
// app/Models/Creneau.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Creneau extends Model
{
    protected $table = 'creneaux';

    protected $fillable = [
        'acteurjuridique_id',
        'jour_semaine',
        'heure_debut',
        'heure_fin',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    // Ordre des jours pour affichage calendrier
    const JOURS = [
        'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'
    ];

    public function acteur()
    {
        return $this->belongsTo(User::class, 'acteurjuridique_id');
    }

    // Retourne la prochaine date réelle pour ce jour de semaine
    public function prochaineDate(): \Carbon\Carbon
    {
        $jours = [
            'lundi'    => 1, 'mardi'  => 2, 'mercredi' => 3,
            'jeudi'    => 4, 'vendredi' => 5, 'samedi' => 6, 'dimanche' => 7,
        ];
        $cible = $jours[$this->jour_semaine];
        $today = now()->isoWeekday();
        $diff  = $cible >= $today ? $cible - $today : 7 - $today + $cible;
        return now()->addDays($diff)->setTimeFromTimeString($this->heure_debut);
    }
}