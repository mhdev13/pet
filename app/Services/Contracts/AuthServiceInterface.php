<?php

namespace App\Services\Contracts;

use App\DTOs\RegisterRequest;
use App\DTOs\LoginRequest;
use App\Models\User;

interface AuthServiceInterface
{
    public function register(RegisterRequest $request): User;
    public function login(LoginRequest $request): bool;
    public function logout(): void;
    public function getAuthenticatedUser(): ?User;
}
