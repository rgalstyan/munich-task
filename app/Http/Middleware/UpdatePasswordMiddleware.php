<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final readonly class UpdatePasswordMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws ValidationException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $user = auth()->user();
        if(!Hash::check($request->get('password'), $user->password)) {
            throw ValidationException::withMessages([
                'field' => ["Password is incorrect."]
            ]);
        }

        return $next($request);
    }
}
