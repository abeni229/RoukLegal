<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'acteurjuridique_id', 'question_id', 'note', 'commentaire', 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function acteur()
    {
        return $this->belongsTo(User::class, 'acteurjuridique_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
