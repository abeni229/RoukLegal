<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Profession extends Model
{
    use HasFactory;

    // table name is singular in migration
    protected $table = 'profession';

    protected $fillable = [
        'nom', 'description'
    ];

    public function acteurs()
    {
        return $this->hasMany(User::class, 'profession_id');
    }
}
