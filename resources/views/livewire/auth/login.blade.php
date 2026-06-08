<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Selamat datang kembali</h1>
        <p class="text-sm text-gray-500 mt-1">Masuk ke akun kamu untuk melanjutkan</p>
    </div>

    <form wire:submit.prevent="login" class="space-y-5">

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
            <input type="email"
                   wire:model="email"
                   id="email"
                   placeholder="nama@email.com"
                   autocomplete="email"
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400
                          focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-shadow">
            @error('email')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            </div>
            <input type="password"
                   wire:model="password"
                   id="password"
                   placeholder="••••••••"
                   autocomplete="current-password"
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400
                          focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-shadow">
            @error('password')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center">
            <input type="checkbox"
                   wire:model="remember"
                   id="remember"
                   class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
            <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya</label>
        </div>

        <button type="submit"
                class="w-full bg-gray-900 hover:bg-gray-700 text-white font-semibold py-2.5 px-4 rounded-lg
                       transition-colors text-sm flex items-center justify-center gap-2">
            <span wire:loading.remove wire:target="login">Masuk</span>
            <span wire:loading wire:target="login" class="flex items-center gap-2">
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                Memproses...
            </span>
        </button>

    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        Belum punya akun?
        <a href="{{ route('register') }}" class="font-semibold text-teal-600 hover:text-teal-700 transition-colors">
            Daftar sekarang
        </a>
    </p>
</div>
