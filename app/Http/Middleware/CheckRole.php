<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * Accepts one or more role slugs (comma-separated) and checks
     * if the authenticated user's role matches any of them.
     *
     * Usage in routes: middleware('role:head_admin') or middleware('role:teacher,head_admin')
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user || !$user->role) {
            abort(403, 'Unauthorized action.');
        }

        $userRoleSlug = $user->role->slug;

        if (!in_array($userRoleSlug, $roles, true)) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
