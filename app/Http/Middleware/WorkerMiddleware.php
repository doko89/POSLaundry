<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role !== 'worker') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
            return redirect()->route('login');
        }

        // Cek apakah worker terkait dengan kios
        if (!auth()->user()->kiosk_id) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Worker tidak terkait dengan kios manapun'], 403);
            }
            return redirect()->route('login')->with('error', 'Worker tidak terkait dengan kios manapun');
        }

        return $next($request);
    }
} 