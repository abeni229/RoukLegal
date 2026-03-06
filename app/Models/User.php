<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom', 'email', 'mot_de_passe', 'role', 'profession_id', 'profession_libre', 'description',
        'photo_professionnelle', 'profile_photo', 'theme',
        'is_subscribed', 'subscription_start', 'subscription_end', 'trial_end', 'articles_viewed_today', 'viewed_authors'
    ];

    /**
     * Le champ du mot de passe est "mot_de_passe" dans la base de données.
     * Laravel s'attend à "password", donc on redirige ici.
     */
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    /**
     * Masquer les champs sensibles lorsqu'on convertit le modèle en tableau/JSON.
     */
    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    // Un client peut poser plusieurs questions
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // Un acteur juridique peut répondre à plusieurs questions
    public function reponses()
    {
        return $this->hasMany(Reponse::class, 'acteurjuridique_id');
    }

    // Messages envoyés
    public function messagesEnvoyes()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Messages reçus
    public function messagesRecus()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // Paiements effectués (client)
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    // Rendez-vous
    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }

    // Notations données
    public function notationsDonnees()
    {
        return $this->hasMany(Notation::class);
    }

    /**
     * Profession attribuée à l'acteur juridique
     */
    public function profession()
    {
        return $this->belongsTo(Profession::class, 'profession_id');
    }

    /**
     * Articles écrits par l'acteur juridique
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Vérifie si l'utilisateur a accès aux réponses (abonnement actif ou essai)
     */
    public function canAccessResponses()
    {
        return $this->is_subscribed || 
               ($this->trial_end && now()->lessThanOrEqualTo($this->trial_end));
    }

    /**
     * Vérifie si l'utilisateur peut poser des questions
     */
    public function canAskQuestions()
    {
        return $this->canAccessResponses();
    }

    /**
     * Vérifie si l'utilisateur peut voir un article d'un auteur spécifique
     */
    public function canViewArticleFromAuthor($authorId)
    {
        if ($this->canAccessResponses()) {
            return true; // Abonnés peuvent voir tous les articles
        }

        // Pour les non-abonnés, vérifier la limite d'un article par auteur
        $viewedAuthors = json_decode($this->viewed_authors ?? '[]', true);
        return !in_array($authorId, $viewedAuthors);
    }

    /**
     * Marque un article comme vu pour cet auteur
     */
    public function markArticleViewedFromAuthor($authorId)
    {
        if (!$this->canAccessResponses()) {
            $viewedAuthors = json_decode($this->viewed_authors ?? '[]', true);
            if (!in_array($authorId, $viewedAuthors)) {
                $viewedAuthors[] = $authorId;
                $this->viewed_authors = json_encode($viewedAuthors);
                $this->articles_viewed_today = ($this->articles_viewed_today ?? 0) + 1;
                $this->save();
            }
        }
    }

    /**
     * Démarre l'essai gratuit de 2 semaines
     */
    public function startFreeTrial()
    {
        if (!$this->trial_end) {
            $this->trial_end = now()->addWeeks(2);
            $this->save();
        }
    }

    /**
     * Vérifie si l'utilisateur peut changer de rôle
     * Un utilisateur ne peut changer de rôle que s'il n'en a pas encore choisi un
     */
    public function canChangeRole()
    {
        return $this->role === null;
    }

    /**
     * Vérifie si l'utilisateur est un admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Vérifie si l'utilisateur est un acteur juridique
     */
    public function isActeurJuridique()
    {
        return $this->role === 'acteur_juridique';
    }

    /**
     * Vérifie si l'utilisateur est un client
     */
    public function isClient()
    {
        return $this->role === 'client';
    }
}