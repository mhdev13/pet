<div>
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Buat akun baru</h1>
        <p class="text-sm text-gray-500 mt-1">Daftar gratis dan mulai kelola hewan peliharaan kamu</p>
    </div>

    <form wire:submit="handleRegister" class="space-y-5">

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
            <input type="text"
                   wire:model="name"
                   id="name"
                   placeholder="John Doe"
                   autocomplete="name"
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400
                          focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-shadow">
            @error('name')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

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
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
            <input type="password"
                   wire:model="password"
                   id="password"
                   placeholder="Minimal 8 karakter"
                   autocomplete="new-password"
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400
                          focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-shadow">
            @error('password')
                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
            <input type="password"
                   wire:model="password_confirmation"
                   id="password_confirmation"
                   placeholder="Ulangi password"
                   autocomplete="new-password"
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400
                          focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-shadow">
        </div>

        <button type="submit"
                class="w-full bg-gray-900 hover:bg-gray-700 text-white font-semibold py-2.5 px-4 rounded-lg
                       transition-colors text-sm flex items-center justify-center gap-2">
            <span wire:loading.remove wire:target="handleRegister">Daftar Sekarang</span>
            <span wire:loading wire:target="handleRegister" class="flex items-center gap-2">
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                Memproses...
            </span>
        </button>

    </form>

    <p class="mt-6 text-center text-sm text-gray-500">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-semibold text-teal-600 hover:text-teal-700 transition-colors">
            Masuk di sini
        </a>
    </p>
</div>
