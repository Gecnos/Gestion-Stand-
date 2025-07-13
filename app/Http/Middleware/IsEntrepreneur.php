<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class IsEntrepreneur
{
    public function handle($request, Closure $next)
    {
          if (Auth::check() && Auth::user()->role === 'approuve') {
            return $next($request);
        }
        abort(403, 'Accès interdit');
    }
}
