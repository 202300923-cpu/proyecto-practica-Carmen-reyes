<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ChekPermission
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }

        $role_id   = Auth::user()->role_id;
        $namedRoute = Route::currentRouteName();

        // 🔥 Permitir rutas sin nombre o rutas de category completas
        if (!$namedRoute || str_contains($namedRoute, 'category')) {
            return $next($request);
        }

        $menu = DB::table('menus')
            ->where('menu_url', $namedRoute)
            ->first();

        if (!$menu) {
            return $next($request);
        }

        $permission = DB::table('permissions')
            ->where('menu_id', $menu->id)
            ->where('role_id', $role_id)
            ->first();

        if (!$permission) {
            return response()->view('errors.404', [], 404);
        }

        return $next($request);
    }
}