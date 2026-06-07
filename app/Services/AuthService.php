<?php

namespace App\Services;

use App\DTOs\RegisterRequest;
use App\DTOs\LoginRequest;
use App\Models\User;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Exception;

class AuthService implements AuthServiceInterface
{
    /**
     * Register a new user
     *
     * @param RegisterRequest $request
     * @return User
     * @throws Exception
     */
    public function register(RegisterRequest $request): User
    {
        $registerService = app(RegisterService::class);
        return $registerService->register($request);
    }

    /**
     * Authenticate and login user
     *
     * @param LoginRequest $request
     * @return bool
     * @throws Exception
     */
    public function login(LoginRequest $request): bool
    {
        $loginService = app(LoginService::class);
        return $loginService->login($request);
    }

    /**
     * Logout user
     *
     * @return void
     */
    public function logout(): void
    {
        Auth::logout();
    }

    /**
     * Get authenticated user
     *
     * @return User|null
     */
    public function getAuthenticatedUser(): ?User
    {
        return Auth::user();
    }
}
