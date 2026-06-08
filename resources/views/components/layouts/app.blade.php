@props(['title' => 'Dashboard', 'fullHeight' => false])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100">
<div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

    {{-- Mobile overlay --}}
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-20 bg-black/50 lg:hidden"
         x-on:click="sidebarOpen = false"
         style="display:none">
    </div>

    {{-- Sidebar --}}
    <aside class="fixed inset-y-0 left-0 z-30 w-64 bg-gray-900 text-white flex flex-col flex-shrink-0
                  transform transition-transform duration-200 ease-in-out
                  lg:static lg:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        <div class="h-16 flex items-center justify-between px-6 bg-gray-800 flex-shrink-0">
            <a href="/" class="text-xl font-bold text-white">{{ config('app.name', 'Laravel') }}</a>
            {{-- Close button (mobile only) --}}
            <button x-on:click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <a href="{{ route('dashboard') }}"
               x-on:click="sidebarOpen = false"
               class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors
                      {{ request()->routeIs('dashboard') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('users.index') }}"
               x-on:click="sidebarOpen = false"
               class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors
                      {{ request()->routeIs('users.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                Users
            </a>

            <a href="{{ route('pets.index') }}"
               x-on:click="sidebarOpen = false"
               class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors
                      {{ request()->routeIs('pets.*') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                Pets
            </a>

            <a href="{{ route('chatbot') }}"
               x-on:click="sidebarOpen = false"
               class="flex items-center px-3 py-2 rounded-md text-sm font-medium transition-colors
                      {{ request()->routeIs('chatbot') ? 'bg-gray-700 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                Chatbot
            </a>
        </nav>

        @auth
        <div class="px-3 py-4 border-t border-gray-700 flex-shrink-0">
            <div class="flex items-center px-3 py-2">
                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center text-sm font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="ml-3 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit"
                        class="w-full flex items-center px-3 py-2 rounded-md text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
        @endauth
    </aside>

    {{-- Main area --}}
    <div class="flex-1 flex flex-col overflow-hidden min-w-0">

        {{-- Top header --}}
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-4 md:px-6 flex-shrink-0">
            <div class="flex items-center gap-3">
                {{-- Hamburger (mobile only) --}}
                <button x-on:click="sidebarOpen = true"
                        class="lg:hidden text-gray-500 hover:text-gray-700 p-1 rounded-md hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 class="text-base md:text-lg font-semibold text-gray-800">{{ $title ?? 'Dashboard' }}</h1>
            </div>
            <div class="text-xs md:text-sm text-gray-500">
                {{ now()->format('d M Y') }}
            </div>
        </header>

        {{-- Page content --}}
        <main class="{{ $fullHeight ? 'flex-1 overflow-hidden flex flex-col' : 'flex-1 overflow-y-auto p-4 md:p-6' }}">
            @isset($slot)
                {{ $slot }}
            @else
                @yield('content')
            @endisset
        </main>
    </div>
</div>

@livewireScriptConfig
</body>
</html>
