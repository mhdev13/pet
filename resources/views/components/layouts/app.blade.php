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
<body class="bg-gray-50">
<div class="flex h-screen overflow-hidden">

    {{-- Sidebar (desktop only) --}}
    <aside class="hidden lg:flex w-60 flex-col flex-shrink-0 bg-white border-r border-gray-200">

        {{-- Brand --}}
        <div class="h-16 flex items-center px-5 border-b border-gray-100 flex-shrink-0">
            <a href="/" class="flex items-center gap-2.5">
                <span class="text-xl">🐾</span>
                <span class="font-bold text-gray-900 text-base">{{ config('app.name', 'PetCare') }}</span>
            </a>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">

            @php
                $navItems = [
                    [
                        'route' => 'dashboard',
                        'match' => 'dashboard',
                        'label' => 'Dashboard',
                        'icon'  => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                    ],
                    [
                        'route'      => 'users.index',
                        'match'      => 'users.*',
                        'label'      => 'Users',
                        'admin_only' => true,
                        'icon'       => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
                    ],
                    [
                        'route' => 'pets.index',
                        'match' => 'pets.*',
                        'label' => 'Pets',
                        'icon'  => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                    ],
                    [
                        'route' => 'chatbot',
                        'match' => 'chatbot',
                        'label' => 'Chatbot',
                        'icon'  => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z',
                    ],
                ];
            @endphp

            @foreach($navItems as $item)
                @if(!empty($item['admin_only']) && !auth()->user()->isAdmin())
                    @continue
                @endif
                @php $active = request()->routeIs($item['match']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                          {{ $active
                              ? 'bg-gray-900 text-white'
                              : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                    </svg>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- User --}}
        @auth
        <div class="flex-shrink-0 px-3 py-3 border-t border-gray-100">
            <div class="flex items-center gap-3 px-3 py-2 rounded-lg mb-0.5">
                <div class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600 flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate leading-none">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate mt-0.5">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-500 hover:text-gray-900 hover:bg-gray-100 transition-colors">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        <header class="h-14 lg:h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 md:px-6 flex-shrink-0">
            <h1 class="text-base md:text-lg font-semibold text-gray-800">{{ $title ?? 'Dashboard' }}</h1>
            @auth
            <div class="flex items-center gap-2.5">
                <span class="text-xs text-gray-400 hidden sm:block">{{ now()->format('d M Y') }}</span>
                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-sm font-bold text-gray-600">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
            @endauth
        </header>

        {{-- Page content --}}
        <main class="{{ $fullHeight
            ? 'flex-1 overflow-hidden flex flex-col pb-16 lg:pb-0'
            : 'flex-1 overflow-y-auto p-4 md:p-6 pb-24 lg:pb-6' }}">
            @isset($slot)
                {{ $slot }}
            @else
                @yield('content')
            @endisset
        </main>
    </div>
</div>

{{-- Bottom Navigation (mobile only) --}}
<nav class="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-gray-200">
    <div class="flex items-stretch h-16">

        @php
            $bottomItems = [
                ['route' => 'dashboard', 'match' => 'dashboard', 'label' => 'Dashboard',
                 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['route' => 'users.index', 'match' => 'users.*', 'label' => 'Users', 'admin_only' => true,
                 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ['route' => 'pets.index', 'match' => 'pets.*', 'label' => 'Pets',
                 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
                ['route' => 'chatbot', 'match' => 'chatbot', 'label' => 'Chatbot',
                 'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
            ];
        @endphp

        @foreach($bottomItems as $item)
            @if(!empty($item['admin_only']) && !auth()->user()->isAdmin())
                @continue
            @endif
            @php $active = request()->routeIs($item['match']); @endphp
            <a href="{{ route($item['route']) }}"
               class="flex-1 flex flex-col items-center justify-center gap-1 relative transition-colors
                      {{ $active ? 'text-gray-900' : 'text-gray-400' }}">

                <span class="w-10 h-7 flex items-center justify-center rounded-lg transition-colors
                             {{ $active ? 'bg-gray-100' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="{{ $active ? '2.5' : '1.75' }}"
                              d="{{ $item['icon'] }}"/>
                    </svg>
                </span>

                <span class="text-[10px] font-medium leading-none">{{ $item['label'] }}</span>

                @if($active)
                    <span class="absolute top-0 left-1/2 -translate-x-1/2 w-6 h-0.5 bg-gray-900 rounded-b-full"></span>
                @endif
            </a>
        @endforeach

    </div>
</nav>

@livewireScriptConfig
</body>
</html>
