<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Services\RegisterService;
use App\DTOs\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ];

    /**
     * Handle user registration
     */
    public function handleRegister()
    {
        $this->validate();
        try {
            $registerRequest = RegisterRequest::fromArray([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
            ]);

            // Resolve RegisterService from container
            $registerService = app(RegisterService::class);
            $user = $registerService->register($registerRequest);

            // Auto login after registration
            Auth::login($user);

            session()->flash('success', 'Registration successful! Welcome ' . $user->name);

            return $this->redirect('/dashboard');
        } catch (\Exception $e) {
            $this->addError('email', $e->getMessage());
        }
    }

   public function render()
{
    return view('livewire.auth.register')
        ->layout('layouts.app'); // Coba hapus prefix 'components.'
}
}
