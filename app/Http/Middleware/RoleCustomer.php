<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;

class RoleCustomer {
    public function handle(Request $request, Closure $next) {
        if (!auth()->check() || !auth()->user()->isCustomer()) {
            return redirect()->route('login')->with('error', 'Akses ditolak!');
        }
        return $next($request);
    }
}
