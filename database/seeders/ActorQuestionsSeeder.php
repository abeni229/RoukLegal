<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;
use App\Models\Question;

class ActorQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer un acteur juridique
        $acteur = User::where('role', 'acteur_juridique')->first();
        
        if (!$acteur) {
            echo 'Aucun acteur juridique trouvé.' . PHP_EOL;
            return;
        }

        // Récupérer les articles de cet acteur
        $articles = Article::where('user_id', $acteur->id)->get();
        
        if ($articles->isEmpty()) {
            echo 'Aucun article trouvé pour cet acteur.' . PHP_EOL;
            return;
        }

        // Récupérer un client
        $client = User::where('role', 'client')->first();
        
        if (!$client) {
            echo 'Aucun client trouvé.' . PHP_EOL;
            return;
        }

        // Créer une question sur chaque article
        foreach ($articles as $article) {
            Question::create([
                'user_id' => $client->id,
                'article_id' => $article->id,
                'titre' => 'Question sur ' . $article->title,
                'contenu' => 'J\'aimerais avoir plus de détails sur le sujet de cet article. Pouvez-vous m\'aider ?',
                'statut' => 'en_attente',
            ]);
        }

        echo count($articles) . ' questions créées avec succès.' . PHP_EOL;
    }
}
