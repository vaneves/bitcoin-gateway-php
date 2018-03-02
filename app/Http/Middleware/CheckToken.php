<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Entities\User;
use App\Models\Services\UserService;

class CheckToken
{
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function handle($request, Closure $next)
    {
        $email = $request->input('email');
        $token = $request->input('token');
        $user = $this->service->getByToken($email, $token);
        if (!$user) {
            throw new \AppException('Invalid token');
        }
        app()->instance(User::class, $user);
        return $next($request);
    }
}
