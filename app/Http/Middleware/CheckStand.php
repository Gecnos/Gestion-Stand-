<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckStand
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Si pas de stand, redirige vers création
        if (!$user->stand) {
            return redirect()->route('stands.create');
        }

        // Sinon laisse continuer
        return $next($request);
    }
}
