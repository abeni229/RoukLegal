<?php

namespace App\Http\Controllers;

use App\Models\Creneau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreneauController extends Controller
{
    // GET /acteur/creneaux
    public function index()
    {
        $creneaux = Creneau::where('acteurjuridique_id', Auth::id())
            ->orderByRaw("FIELD(jour_semaine,'lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche')")
            ->orderBy('heure_debut')
            ->get()
            ->groupBy('jour_semaine');

        return view('acteur.creneaux', compact('creneaux'));
    }

    // POST /acteur/creneaux
    public function store(Request $request)
    {
        $request->validate([
            'jour_semaine' => 'required|in:lundi,mardi,mercredi,jeudi,vendredi,samedi,dimanche',
            'heure_debut'  => 'required|date_format:H:i',
            'heure_fin'    => 'required|date_format:H:i|after:heure_debut',
        ]);

        // Vérifier chevauchement
        $chevauchement = Creneau::where('acteurjuridique_id', Auth::id())
            ->where('jour_semaine', $request->jour_semaine)
            ->where('actif', true)
            ->where(function ($q) use ($request) {
                $q->whereBetween('heure_debut', [$request->heure_debut, $request->heure_fin])
                  ->orWhereBetween('heure_fin',  [$request->heure_debut, $request->heure_fin]);
            })->exists();

        if ($chevauchement) {
            return back()->withErrors(['heure_debut' => 'Ce créneau chevauche un créneau existant.']);
        }

        Creneau::create([
            'acteurjuridique_id' => Auth::id(),
            'jour_semaine'       => $request->jour_semaine,
            'heure_debut'        => $request->heure_debut,
            'heure_fin'          => $request->heure_fin,
            'actif'              => true,
        ]);

        return back()->with('status', 'Créneau ajouté avec succès.');
    }

    // PATCH /acteur/creneaux/{creneau}/toggle
    public function toggle(Creneau $creneau)
    {
        abort_if($creneau->acteurjuridique_id !== Auth::id(), 403);
        $creneau->update(['actif' => !$creneau->actif]);
        return back()->with('status', 'Statut du créneau mis à jour.');
    }

    // DELETE /acteur/creneaux/{creneau}
    public function destroy(Creneau $creneau)
    {
        abort_if($creneau->acteurjuridique_id !== Auth::id(), 403);
        $creneau->delete();
        return back()->with('status', 'Créneau supprimé.');
    }

    // API publique : créneaux d'un acteur (pour le client)
    // GET /acteur/{acteur}/creneaux-disponibles
    public function disponibles($acteurId)
    {
        $creneaux = Creneau::where('acteurjuridique_id', $acteurId)
            ->where('actif', true)
            ->orderByRaw("FIELD(jour_semaine,'lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche')")
            ->orderBy('heure_debut')
            ->get();

        return response()->json($creneaux);
    }
}