<?php
namespace App\Http\Middleware;

use App\Http\Middleware\EnsureRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(
        Request $request,
        Closure $next,
        string $role
    ): Response {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== $role) {
            abort(403, 'Kamu tidak memiliki izin mengakses halaman ini.');
        }

        return $next($request);
    }
}
