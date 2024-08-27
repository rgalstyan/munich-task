<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

final readonly class AllUsersMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $request->merge(['user_id' => auth()->id()]);

        return $next($request);
    }
}
