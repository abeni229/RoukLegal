<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'content', 'views'];

    /**
     * Un article est écrit par un utilisateur (acteur juridique)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Un article peut avoir plusieurs questions pointant vers lui
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}

