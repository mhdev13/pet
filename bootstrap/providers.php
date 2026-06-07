<?php

use App\Providers\AppServiceProvider;
use Livewire\LivewireServiceProvider;
use App\Services\Providers\AuthServiceProvider;

return [
    AppServiceProvider::class,
    LivewireServiceProvider::class,
    AuthServiceProvider::class,
];
