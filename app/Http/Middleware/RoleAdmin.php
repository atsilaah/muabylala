<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;

class RoleAdmin {
    public function handle(Request $request, Closure $next) {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Akses ditolak!');
        }
        return $next($request);
    }
}
