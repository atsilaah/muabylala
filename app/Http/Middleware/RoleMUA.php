<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMua {
    public function handle(Request $request, Closure $next) {
        if (!auth()->check() || !auth()->user()->isMua()) {
            return redirect()->route('login')->with('error', 'Akses ditolak!');
        }
        return $next($request);
    }
}
