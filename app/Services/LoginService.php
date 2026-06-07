<?php

namespace App\Services;

use App\DTOs\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class LoginService
{
    /**
     * Authenticate user and login
     *
     * @param LoginRequest $request
     * @return bool
     * @throws Exception
     */
    public function login(LoginRequest $request): bool
    {
        try {
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            if (Auth::attempt($credentials, $request->remember)) {
                return true;
            }

            throw new Exception('Invalid email or password.');
        } catch (Exception $e) {
            throw new Exception('Login failed: ' . $e->getMessage());
        }
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
     * Get currently authenticated user
     *
     * @return User|null
     */
    public function getAuthenticatedUser(): ?User
    {
        return Auth::user();
    }

    /**
     * Check if user is authenticated
     *
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return Auth::check();
    }

    /**
     * Validate login data
     *
     * @param array $data
     * @return array
     */
    public function validateLoginData(array $data): array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember' => 'sometimes|boolean',
        ];
    }
}
