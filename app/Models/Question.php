<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'article_id', 'titre', 'contenu', 'statut'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function reponses()
    {
        return $this->hasMany(Reponse::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
