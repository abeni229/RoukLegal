<?php

namespace Database\Seeders;

use App\Models\Profession;
use App\Models\User;
use App\Models\Article;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed professions first
        $professions = [
            ['nom' => 'Droit civil', 'description' => 'Spécialisé en droit civil et contrats'],
            ['nom' => 'Droit pénal', 'description' => 'Spécialisé en droit pénal et procédure'],
            ['nom' => 'Droit commercial', 'description' => 'Spécialisé en droit des affaires'],
            ['nom' => 'Droit du travail', 'description' => 'Spécialisé en droit du travail'],
            ['nom' => 'Droit immobilier', 'description' => 'Spécialisé en droit immobilier'],
        ];

        foreach ($professions as $profession) {
            Profession::firstOrCreate(['nom' => $profession['nom']], $profession);
        }

        // Seed test users (éviter les doublons)
        $client = User::firstOrCreate(
            ['email' => 'client@test.com'],
            [
                'nom' => 'Client Test',
                'mot_de_passe' => Hash::make('password123'),
                'role' => 'client',
            ]
        );

        $acteur = User::firstOrCreate(
            ['email' => 'avocat@test.com'],
            [
                'nom' => 'Avocat Test',
                'mot_de_passe' => Hash::make('password123'),
                'role' => 'acteur_juridique',
                'profession_id' => Profession::where('nom', 'Droit civil')->first()?->id,
            ]
        );

        // Créer un seul admin (éviter les doublons)
        User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'nom' => 'Administrateur',
                'mot_de_passe' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Créer des articles pour l'acteur si aucun n'existe
        if ($acteur->articles()->count() === 0) {
            $articles = [
                [
                    'title' => 'Guide complet du droit des contrats',
                    'content' => 'Le droit des contrats est une branche essentielle du droit civil. Un contrat est un accord entre deux ou plusieurs parties qui crée des obligations. Les éléments essentiels d\'un contrat sont le consentement des parties, la capacité à contracter, et une cause licite. Nous vous expliquons comment rédiger un bon contrat.',
                ],
                [
                    'title' => 'Les droits du travailleur',
                    'content' => 'Tout employé a des droits fondamentaux en matière de droit du travail. Ces droits incluent un salaire minimum, des congés payés, une protection contre le licenciement abusif, et le droit à la sécurité. Découvrez vos droits et obligations en tant que salarié.',
                ],
                [
                    'title' => 'Procédures de divorce',
                    'content' => 'Le divorce est une procédure complexe qui peut être contentieuse ou amiable. Il existe plusieurs types de divorces selon la situation. Nous vous expliquons le processus, les documents nécessaires, et vos droits concernant la garde des enfants et la pension alimentaire.',
                ],
            ];

            foreach ($articles as $article) {
                Article::create([
                    'user_id' => $acteur->id,
                    'title' => $article['title'],
                    'content' => $article['content'],
                    'views' => 0,
                ]);
            }
        }

        // Créer des questions si aucune n'existe
        if (Question::count() === 0) {
            $articlesOfActeur = Article::where('user_id', $acteur->id)->get();
            foreach ($articlesOfActeur as $article) {
                Question::create([
                    'user_id' => $client->id,
                    'article_id' => $article->id,
                    'titre' => 'Question : Comment appliquer ceci dans ma situation ?',
                    'contenu' => 'J\'aimerais savoir comment appliquer les principes mentionnés dans votre article ' . $article->title . ' à mon cas spécifique. Pouvez-vous m\'aider avec des exemples concrets ?',
                    'statut' => 'en_attente',
                ]);
            }
        }
    }
}
