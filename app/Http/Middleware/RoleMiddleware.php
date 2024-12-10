<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string $roles - roles separated by comma
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            // Nie zalogowany
            return redirect('/'); // lub abort(403);
        }

        // Sprawdzamy, czy rola użytkownika jest w podanym zbiorze ról
        if (!in_array($user->role, $roles)) {
            // Użytkownik nie ma wymaganej roli
            abort(403, 'Brak dostępu');
        }

        return $next($request);
    }
}
