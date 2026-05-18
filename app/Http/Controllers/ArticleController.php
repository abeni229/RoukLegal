<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{

    
    /**
     * Afficher tous les articles (pour les clients)
     */
    public function index()
    {
        $articles = Article::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        
        return view('articles.index', [
            'articles' => $articles,
            'withSidebar' => false
        ]);
    }

    /**
     * Afficher un article spécifique avec les questions
     */
    public function show($id)
    {
        $article = Article::with('user', 'questions')->findOrFail($id);
        $user = Auth::user();
        
        // Vérifier si l'utilisateur peut voir cet article
        if ($user && $user->role === 'client') {
            if (!$user->canViewArticleFromAuthor($article->user_id)) {
                return redirect()->route('client.articles')->with('error', 
                    'Vous avez atteint la limite d\'articles consultables pour cet auteur. Souscrivez pour accéder à tous les articles.');
            }
            
            // Marquer l'article comme vu
            $user->markArticleViewedFromAuthor($article->user_id);
        }
        
        $article->increment('views');
        
        return view('articles.show', [
            'article' => $article,
            'withSidebar' => false,
            'canAskQuestion' => $user ? $user->canAskQuestions() : false
        ]);
    }

    /**
     * Afficher le formulaire de création d'article
     */
    public function create()
    {
        return view('articles.create', [
            'withSidebar' => true
        ]);
    }

    /**
     * Sauvegarder un nouvel article
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Article::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        return redirect()->route('articles.dashboard')
            ->with('status', 'Article créé avec succès!');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
       if (Auth::id() !== $article->user_id) abort(403);
        
        return view('articles.edit', [
            'article' => $article,
            'withSidebar' => true
        ]);
    }

    /**
     * Mettre à jour un article
     */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
       if (Auth::id() !== $article->user_id) abort(403);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $article->update($validated);

        return redirect()->route('articles.dashboard')
            ->with('status', 'Article mis à jour avec succès!');
    }

    /**
     * Supprimer un article
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
       if (Auth::id() !== $article->user_id) abort(403);
        
        $article->delete();

        return redirect()->route('articles.dashboard')
            ->with('status', 'Article supprimé avec succès!');
    }

    /**
     * Dashboard de l'acteur avec ses articles
     */
    public function dashboard()
    {
        $user = Auth::user();
        $articles = $user->articles()->orderBy('created_at', 'desc')->get();
        
        return view('articles.dashboard', [
            'articles' => $articles,
            'withSidebar' => true
        ]);
    }

    /**
     * Soumettre une question sur un article
     */
    public function storeQuestion(Request $request, $articleId)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'client' || !$user->canAskQuestions()) {
            return redirect()->back()->with('error', 'Vous devez être abonné ou en essai pour poser une question.');
        }

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'nullable|string|max:2000',
        ]);

        $article = Article::findOrFail($articleId);

        $question = new \App\Models\Question([
            'user_id' => Auth::id(),
            'article_id' => $articleId,
            'titre' => $validated['titre'],
            'contenu' => $validated['contenu'] ?? '',
            'statut' => 'en_attente'
        ]);
        $question->save();

        return redirect()->route('articles.show', $articleId)
            ->with('status', 'Votre question a été envoyée à ' . $article->user->nom . '!');
    }

    public function noter(Request $request, \App\Models\Article $article)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'client') {
            abort(403, 'Action non autorisée.');
        }
    
        $request->validate([
            'note'        => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:500',
        ]);

    \App\Models\Notation::updateOrCreate(
        [
            'user_id'           => Auth::id(),
            'acteurjuridique_id'=> $article->user_id,
        ],
        [
            'note'        => $request->note,
            'commentaire' => $request->commentaire,
            'question_id' => null,
        ]
    );

    return back()->with('status', 'Évaluation soumise avec succès.');
}

    
}

