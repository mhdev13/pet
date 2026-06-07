<?php

namespace App\Services;

use App\DTOs\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Exception;

class RegisterService
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
        try {
            return DB::transaction(function () use ($request) {
                return User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
            });
        } catch (Exception $e) {
            throw new Exception('Failed to register user: ' . $e->getMessage());
        }
    }

    /**
     * Validate register data
     *
     * @param array $data
     * @return array
     */
    public function validateRegisterData(array $data): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
