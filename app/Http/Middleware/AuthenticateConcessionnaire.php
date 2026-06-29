<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Userconcessionnaire;

class AuthenticateConcessionnaire
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->role === '01' && !$request->routeIs(['concessionnaire.create', 'concessionnaire.store'])) {
            // Vérifie si l'utilisateur n'a pas encore de concessionnaire
            $hasUserconcessionnaire = Userconcessionnaire::where('userconcessionnaire_id', $user->id)->exists();

            if (!$hasUserconcessionnaire) {
                session()->flash('type', 'alert-danger');
                session()->flash('message', "Veuillez enregistrer votre établissement.");
                return redirect()->route('concessionnaire.create');
            }
        }

        return $next($request);
    }
}