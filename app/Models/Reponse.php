<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id', 'acteurjuridique_id', 'contenu'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function acteur()
    {
        return $this->belongsTo(User::class, 'acteurjuridique_id');
    }
}
