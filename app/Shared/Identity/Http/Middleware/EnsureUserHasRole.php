<?php

namespace App\Shared\Identity\Http\Middleware;

use App\Shared\Identity\Enums\UserRole;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string $role): Response {
        if ($request->user()?->role !== UserRole::from($role)) {
            throw new AuthorizationException;
        }

        return $next($request);
    }
}
