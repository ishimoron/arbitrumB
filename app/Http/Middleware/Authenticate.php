<?php

namespace App\Http\Middleware;

use App\Services\AuthService;
use Illuminate\Http\Response;

class Authenticate
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function handle($request, \Closure $next)
    {
        if (!$this->authService->isLoggedIn()) {
            return response()->json([], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
