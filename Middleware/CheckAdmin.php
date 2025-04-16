<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{

    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role_id === 1) {
            return $next($request);
        }

        return redirect('/')->with('error', 'У вас нет доступа к админ-панели!');
    }
}