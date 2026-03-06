<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;
use App\Models\Question;
use App\Models\Reponse;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un acteur juridique de test
        $acteur = User::create([
            'nom' => 'Me. Dupont',
            'email' => 'acteur2@test.com',
            'mot_de_passe' => Hash::make('password'),
            'role' => 'acteur_juridique',
            'profession_id' => 1,
            'profession_libre' => null,
            'description' => 'Avocat spécialisé en droit des affaires avec 10 ans d\'expérience.',
            // pour tests, on peut déposer une image dans storage/app/public/acteurs/photos/dummy.jpg
            'photo_professionnelle' => null,
            'is_subscribed' => false,
        ]);

        // create additional 5 actors
        for ($i = 3; $i <= 7; $i++) {
            User::create([
                'nom' => "Acteur $i",
                'email' => "acteur{$i}@test.com",
                'mot_de_passe' => Hash::make('password'),
                'role' => 'acteur_juridique',
                'profession_libre' => 'Consultant juridique niveau ' . $i,
                'description' => 'Description de l\'acteur ' . $i,
                'photo_professionnelle' => null,
                'is_subscribed' => false,
            ]);
        }

        // Créer un client de test
        $client = User::create([
            'nom' => 'Jean Client',
            'email' => 'client2@test.com',
            'mot_de_passe' => Hash::make('password'),
            'role' => 'client',
            'is_subscribed' => false,
        ]);

        // additional clients
        for ($j = 2; $j <= 3; $j++) {
            User::create([
                'nom' => "Client $j",
                'email' => "client{$j}@test.com",
                'mot_de_passe' => Hash::make('password'),
                'role' => 'client',
                'is_subscribed' => false,
            ]);
        }

        // Créer un article de test
        $article = Article::create([
            'user_id' => $acteur->id,
            'title' => 'Guide du droit des contrats',
            'content' => 'Le droit des contrats est une branche essentielle du droit civil...',
            'views' => 15,
        ]);

        // Créer une question de test
        $question = Question::create([
            'user_id' => $client->id,
            'article_id' => $article->id,
            'titre' => 'Comment résilier un contrat ?',
            'contenu' => 'J\'ai signé un contrat de service mais je souhaite le résilier. Quelles sont mes options ?',
            'statut' => 'en_attente',
        ]);

        // Créer une réponse de test
        Reponse::create([
            'question_id' => $question->id,
            'acteurjuridique_id' => $acteur->id,
            'contenu' => 'Pour résilier un contrat, vous devez généralement respecter les conditions prévues dans le contrat lui-même...',
        ]);

        // Un paiement de test pour montrer la progression
        \App\Models\Paiement::create([
            'user_id' => $client->id,
            'acteurjuridique_id' => $acteur->id,
            'question_id' => $question->id,
            'montant' => 5000,
            'methode' => 'carte',
            'statut' => 'completed',
            'date_paiement' => now(),
        ]);

        // Mettre à jour le statut de la question
        $question->update(['statut' => 'repondu']);
    }
}
