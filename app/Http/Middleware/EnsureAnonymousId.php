<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class EnsureAnonymousId
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('anonymous_id')) {
            session(['anonymous_id' => (string) Str::uuid()]);
        }

        return $next($request);
    }
}