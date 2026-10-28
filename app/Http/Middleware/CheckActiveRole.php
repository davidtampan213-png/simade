<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckActiveRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role = null): Response
    {
        if (!$request->session()->has('active_role')) {
            return redirect()->route('pilih-role')->with('error', 'Silakan pilih role terlebih dahulu.');
        }

        if ($role && $request->session()->get('active_role') !== $role) {
            return redirect()->route('pilih-role')->with('error', 'Akses ditolak untuk role Anda.');
        }

        return $next($request);
    }
}
