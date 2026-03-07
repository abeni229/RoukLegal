<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Process a new user registration.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mot_de_passe' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'mot_de_passe' => Hash::make($validated['mot_de_passe']),
            'role' => null, // Sera défini après la sélection
        ]);

        Auth::login($user);

        return redirect()->route('auth.selectRole');
    }

    /**
     * Show the login form.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Authenticate a user.
     */
   public function login(Request $request)
{
   
    $credentials = $request->validate([
        'email'       => 'required|email',
        'mot_de_passe' => 'required',
    ]);

    $user = User::where('email', $credentials['email'])->first();

    if ($user && Hash::check($credentials['mot_de_passe'], $user->mot_de_passe)) {
        Auth::login($user);

        // ✅ Redirection directe selon le rôle — sans passer par '/'
        return match($user->role) {
            'admin'           => redirect()->route('admin.dashboard'),
            'acteur_juridique' => redirect()->route('acteur.dashboard'),
            'client'          => redirect()->route('client.dashboard'),
            default           => redirect()->route('auth.selectRole'),
        };
    }

    return back()->withErrors(['email' => 'Identifiants incorrects'])->withInput();
     
}

    /**
     * Show role selection form.
     */
    public function showSelectRole()
    {
        if (!Auth::check()) {
            return redirect()->route('home');
        }

        $user = Auth::user();
        
        // Si l'utilisateur a déjà un rôle, rediriger vers son dashboard
        if ($user->role !== null) {
            return redirect()->route('home');
        }

        return view('auth.selectRole');
    }

    /**
     * Store selected role and redirect to appropriate dashboard.
     */
    public function selectRole(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|in:client,acteur_juridique',
        ]);

        $user = Auth::user();
        
        // Vérifier que l'utilisateur n'a pas déjà un rôle
        if ($user->role !== null) {
            return redirect()->route('home')->with('error', 'Vous ne pouvez pas changer de rôle.');
        }

        $user->role = $validated['role'];
        $user->save();

        if ($user->role === 'acteur_juridique') {
            return redirect()->route('acteur.dashboard');
        } else {
            return redirect()->route('client.dashboard');
        }
    }

    /**
     * Log the current user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
