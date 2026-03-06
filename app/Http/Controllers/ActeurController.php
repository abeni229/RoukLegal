<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use App\Models\Question;
use App\Models\Reponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActeurController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $assigned = $user->reponses()->count();
        // if a free-text profession was specified, create a dummy object for view convenience
        $profession = $user->profession;
        if (!$profession && $user->profession_libre) {
            $profession = (object) ['nom' => $user->profession_libre];
        }
        $articles = $user->articles()->count();
        
        return view('acteur.dashboard', [
            'assigned' => $assigned,
            'profession' => $profession,
            'articles' => $articles,
            'withSidebar' => true
        ]);
    }

    /**
     * Éditer le profil et la description
     */
    public function editProfile()
    {
        $professions = Profession::all();
        $user = Auth::user();
        return view('acteur.profile', compact('professions', 'user'));
    }

    /**
     * Mettre à jour le profil et la description
     */
    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'profession_id' => 'nullable|exists:profession,id',
            'profession_libre' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:5000',
            // allow up to 15MB images (15360 KB)
            'photo_professionnelle' => 'nullable|image|max:15360',
            'remove_professional' => 'nullable|boolean',
        ]);

        $user = Auth::user();
        $user->profession_id = $data['profession_id'] ?? null;
        // if user provided a free text profession, save it; otherwise clear it
        $user->profession_libre = $data['profession_libre'] ?? null;
        $user->description = $data['description'] ?? null;

        // handle photo removal or upload
        if ($request->has('remove_professional') && $request->remove_professional) {
            if ($user->photo_professionnelle) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->photo_professionnelle);
            }
            $user->photo_professionnelle = null;
        }
        if ($request->hasFile('photo_professionnelle')) {
            $path = $request->file('photo_professionnelle')->store('acteurs/photos', 'public');
            $user->photo_professionnelle = $path;
        }

        $user->save();

        return redirect()->route('acteur.dashboard')->with('status', 'Profil mis à jour');
    }

    /**
     * Affiche les questions reçues par l'acteur
     */
    public function questions()
    {
        $user = Auth::user();
        
        // Questions liées aux articles de cet acteur
        $questions = Question::whereHas('article', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with(['user', 'article', 'reponses'])
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        
        return view('acteur.questions', [
            'questions' => $questions,
            'withSidebar' => true
        ]);
    }

    /**
     * Répondre à une question
     */
    public function respondToQuestion(Request $request, Question $question)
    {
        $request->validate([
            'contenu' => 'required|string|min:10|max:5000',
        ]);

        // Vérifier que la question appartient à un article de cet acteur
        if ($question->article->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez pas répondre à cette question.');
        }

        // Créer la réponse
        Reponse::create([
            'question_id' => $question->id,
            'acteurjuridique_id' => Auth::id(),
            'contenu' => $request->contenu,
        ]);

        // Mettre à jour le statut de la question
        $question->update(['statut' => 'repondu']);

        // Si le client n'a pas d'abonnement actif, démarrer l'essai gratuit
        $client = $question->user;
        if (!$client->canAccessResponses()) {
            $client->startFreeTrial();
        }

        return redirect()->route('acteur.questions')->with('status', 'Réponse envoyée avec succès');
    }
}

