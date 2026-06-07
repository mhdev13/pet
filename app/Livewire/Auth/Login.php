<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Services\LoginService;
use App\DTOs\LoginRequest;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|string|email',
        'password' => 'required|string',
        'remember' => 'sometimes|boolean',
    ];

    /**
     * Handle user login
     */
    public function login()
    {
        $this->validate();

        try {
            $loginRequest = LoginRequest::fromArray([
                'email' => $this->email,
                'password' => $this->password,
                'remember' => $this->remember,
            ]);

            // Resolve LoginService from container
            $loginService = app(LoginService::class);
            if ($loginService->login($loginRequest)) {
                session()->flash('success', 'Login successful! Welcome back');
                return $this->redirect('/dashboard');
            }
        } catch (\Exception $e) {
            $this->addError('email', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.app'); // Coba hapus prefix 'components.'
    }   
}