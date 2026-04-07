<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Affiche l'accueil public ou redirige l'utilisateur vers son tableau de bord.
     */
    public function index()
    {
        if (!Auth::check()) {
            $query = User::where('role', 'acteur_juridique')->with('profession');
            $total = $query->count();
            $actors = $query->take(100)->get();
            $hasMore = $total > 100;
            
            return view('welcome', compact('actors', 'hasMore'));
        }
        
        $user = Auth::user();
        
        if ($user->role === null) {
            return redirect()->route('auth.selectRole');
        }
        
        return match($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'acteur_juridique' => redirect()->route('acteur.dashboard'),
            'client' => redirect()->route('client.dashboard'),
            default => redirect()->route('auth.selectRole'),
        };
    }
}
