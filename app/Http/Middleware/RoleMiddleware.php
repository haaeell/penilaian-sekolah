<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $rolesArray = explode(',', $roles);
        if (!in_array(Auth::user()->role, $rolesArray)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
