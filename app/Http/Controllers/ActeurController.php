<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use App\Models\Question;
use App\Models\Reponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ActeurController extends Controller
{
    /**
     * Tableau de bord de l'acteur juridique.
     */
    public function dashboard()
    {
        try {
            $user      = Auth::user();
            $stats     = $this->getDashboardStats($user);
            $profession = $this->resolveProfession($user);
            $recentQuestions = $this->getRecentQuestions($user);

            return view('acteur.dashboard', array_merge($stats, [
                'profession'      => $profession,
                'recentQuestions' => $recentQuestions,
                'withSidebar'     => true,
            ]));
        } catch (\Exception $e) {
            Log::error('Erreur dashboard acteur : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors du chargement.');
        }
    }

    /**
     * Formulaire d'édition du profil.
     */
    public function editProfile()
    {
        return view('acteur.profile', [
            'professions' => Profession::all(),
            'user'        => Auth::user(),
        ]);
    }

    /**
     * Mise à jour du profil.
     */
    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'profession_id'         => 'nullable|exists:profession,id',
            'profession_libre'      => 'nullable|string|max:255',
            'description'           => 'nullable|string|max:5000',
            'photo_professionnelle' => 'nullable|image|max:15360',
            'remove_professional'   => 'nullable|boolean',
        ]);

        try {
            $user = Auth::user();
            $user->profession_id    = $data['profession_id'] ?? null;
            $user->profession_libre = $data['profession_libre'] ?? null;
            $user->description      = $data['description'] ?? null;

            $this->handlePhotoUpload($request, $user);

            $user->save();

            return redirect()->route('acteur.dashboard')->with('status', 'Profil mis à jour avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur mise à jour profil acteur : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Impossible de mettre à jour le profil.');
        }
    }

    /**
     * Liste des questions reçues (paginées).
     */
    public function questions()
    {
        $user = Auth::user();

        $questions = Question::whereHas('article', fn($q) => $q->where('user_id', $user->id))
            ->with(['user', 'article', 'reponses'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('acteur.questions', [
            'questions'   => $questions,
            'withSidebar' => true,
        ]);
    }

    /**
     * Répondre à une question.
     */
    public function respondToQuestion(Request $request, Question $question)
    {
        $request->validate([
            'contenu' => 'required|string|min:10|max:5000',
        ]);

        if ($question->article->user_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez pas répondre à cette question.');
        }

        try {
            Reponse::create([
                'question_id'         => $question->id,
                'acteurjuridique_id'  => Auth::id(),
                'contenu'             => $request->contenu,
            ]);

            $question->update(['statut' => 'repondu']);

            // Activer l'essai gratuit du client si nécessaire
            $client = $question->user;
            if (!$client->canAccessResponses()) {
                $client->startFreeTrial();
            }

            return redirect()->route('acteur.questions')->with('status', 'Réponse envoyée avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur réponse question : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Impossible d\'envoyer la réponse.');
        }
    }

    // -----------------------------------------------------------------------
    //  Méthodes privées
    // -----------------------------------------------------------------------

    /**
     * Statistiques du dashboard : réponses, articles, questions en attente.
     */
    private function getDashboardStats($user): array
    {
        $totalQuestions  = Question::whereHas('article', fn($q) => $q->where('user_id', $user->id))->count();
        $pendingQuestions = Question::whereHas('article', fn($q) => $q->where('user_id', $user->id))
            ->where('statut', '!=', 'repondu')
            ->count();

        return [
            'assigned'         => $user->reponses()->count(),
            'articles'         => $user->articles()->count(),
            'totalQuestions'   => $totalQuestions,
            'pendingQuestions' => $pendingQuestions,
        ];
    }

    /**
     * Résout la profession (relation ou texte libre).
     */
    private function resolveProfession($user): object|null
    {
        if ($user->profession) {
            return $user->profession;
        }
        if ($user->profession_libre) {
            return (object) ['nom' => $user->profession_libre];
        }
        return null;
    }

    /**
     * 5 questions récentes avec leurs réponses.
     */
    private function getRecentQuestions($user)
    {
        return Question::whereHas('article', fn($q) => $q->where('user_id', $user->id))
            ->with(['user', 'reponses'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Gère la suppression et/ou l'upload de la photo professionnelle.
     */
    private function handlePhotoUpload(Request $request, $user): void
    {
        if ($request->boolean('remove_professional') && $user->photo_professionnelle) {
            Storage::disk('public')->delete($user->photo_professionnelle);
            $user->photo_professionnelle = null;
        }

        if ($request->hasFile('photo_professionnelle')) {
            $path = $request->file('photo_professionnelle')->store('acteurs/photos', 'public');
            $user->photo_professionnelle = $path;
        }
    }
}