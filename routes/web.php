<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', App\Livewire\Auth\Register::class)->name('register');
Route::get('/login', App\Livewire\Auth\Login::class)->name('login');

Route::post('/logout', function (Request $request) {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/users', App\Livewire\Users\Index::class)->name('users.index')
        ->middleware(App\Http\Middleware\AdminOnly::class);
    Route::get('/pets', App\Livewire\Pets\Index::class)->name('pets.index');
    Route::get('/pets/{pet}/vaccines', App\Livewire\Pets\Vaccines::class)->name('pets.vaccines');
    Route::get('/pets/{pet}/vaccines/pdf', [App\Http\Controllers\PetVaccineController::class, 'downloadPdf'])->name('pets.vaccines.pdf');
    Route::get('/chatbot', App\Livewire\Chatbot\Index::class)->name('chatbot');
});
