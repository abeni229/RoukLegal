<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventRoleChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Si l'utilisateur essaie d'accéder à la page de sélection de rôle
        // mais qu'il a déjà un rôle, le rediriger vers son dashboard
        if ($request->route() && $request->route()->getName() === 'auth.selectRole') {
            if ($user && $user->role !== null) {
                return redirect()->route('home');
            }
        }

        // Si l'utilisateur essaie de changer son rôle via POST
        if ($request->isMethod('post') && $request->route() && $request->route()->getName() === 'auth.selectRole') {
            if ($user && $user->role !== null) {
                return redirect()->route('home')->with('error', 'Vous ne pouvez pas changer de rôle une fois qu\'il a été défini.');
            }
        }

        return $next($request);
    }
}
