<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'PetCare') }} — Aplikasi Manajemen Hewan Peliharaan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900 antialiased">

    {{-- Navbar --}}
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-2xl">🐾</span>
                <span class="font-bold text-gray-900 text-lg">{{ config('app.name', 'PetCare') }}</span>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="bg-gray-900 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors px-3 py-2">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="bg-gray-900 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        Daftar Gratis
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="max-w-5xl mx-auto px-4 sm:px-6 pt-20 pb-16 text-center">
        <div class="inline-flex items-center gap-2 bg-amber-50 border border-amber-200 text-amber-700 text-xs font-medium px-3 py-1.5 rounded-full mb-8">
            <span>🐶🐱🐦🐠</span>
            <span>Untuk semua jenis hewan peliharaan</span>
        </div>

        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6">
            Catat semua hal penting<br class="hidden sm:block">
            tentang hewan peliharaan kamu
        </h1>

        <p class="text-lg text-gray-500 max-w-xl mx-auto mb-10 leading-relaxed">
            Dari jadwal vaksin, obat kutu, obat cacing, hingga profil lengkap hewan —
            semua tersimpan rapi dan mudah diakses kapan saja.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="w-full sm:w-auto bg-gray-900 text-white font-semibold px-8 py-3.5 rounded-xl hover:bg-gray-700 transition-colors text-base">
                    Buka Dashboard &rarr;
                </a>
            @else
                <a href="{{ route('register') }}"
                   class="w-full sm:w-auto bg-gray-900 text-white font-semibold px-8 py-3.5 rounded-xl hover:bg-gray-700 transition-colors text-base">
                    Mulai Sekarang &mdash; Gratis
                </a>
                <a href="{{ route('login') }}"
                   class="w-full sm:w-auto border border-gray-200 text-gray-700 font-medium px-8 py-3.5 rounded-xl hover:bg-gray-50 transition-colors text-base">
                    Sudah punya akun? Masuk
                </a>
            @endauth
        </div>
    </section>

    {{-- App Preview mockup --}}
    <section class="max-w-5xl mx-auto px-4 sm:px-6 pb-20">
        <div class="bg-gray-900 rounded-2xl overflow-hidden shadow-2xl">
            <div class="bg-gray-800 px-4 py-3 flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                <div class="ml-4 flex-1 bg-gray-700 rounded px-3 py-1 text-xs text-gray-400">
                    localhost/pets
                </div>
            </div>
            <div class="bg-gray-50 flex">
                <div class="w-48 bg-gray-900 p-3 hidden sm:block flex-shrink-0">
                    <div class="text-white text-sm font-bold px-3 py-2 mb-3">🐾 PetCare</div>
                    @foreach(['Dashboard', 'Users', 'Pets', 'Chatbot'] as $i => $menu)
                        <div class="flex items-center gap-2 px-3 py-2 rounded-md mb-1 {{ $i === 2 ? 'bg-gray-700 text-white' : 'text-gray-400' }} text-xs">
                            <div class="w-1.5 h-1.5 rounded-full bg-current opacity-60"></div>
                            {{ $menu }}
                        </div>
                    @endforeach
                </div>
                <div class="flex-1 p-5 overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm font-semibold text-gray-700">Pet Management</div>
                        <div class="bg-blue-600 text-white text-xs px-3 py-1 rounded-lg">+ Tambah Pet</div>
                    </div>
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <div class="grid grid-cols-5 gap-2 px-4 py-2 bg-gray-50 border-b border-gray-200">
                            @foreach(['Pet', 'Jenis', 'Berat', 'Obat Kutu', 'Status'] as $h)
                                <div class="text-xs font-medium text-gray-500 uppercase">{{ $h }}</div>
                            @endforeach
                        </div>
                        @foreach([
                            ['🐶 Max', 'Anjing', '8.2 kg', '12 Mar 2025', true],
                            ['🐱 Luna', 'Kucing', '4.1 kg', '05 Jan 2025', true],
                            ['🐰 Cici', 'Kelinci', '1.8 kg', '-', false],
                        ] as $row)
                            <div class="grid grid-cols-5 gap-2 px-4 py-3 border-b border-gray-100 last:border-0">
                                <div class="text-xs font-medium text-gray-800">{{ $row[0] }}</div>
                                <div class="text-xs text-gray-500">{{ $row[1] }}</div>
                                <div class="text-xs text-gray-500">{{ $row[2] }}</div>
                                <div class="text-xs text-gray-500">{{ $row[3] }}</div>
                                <div>
                                    <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $row[4] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $row[4] ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section class="bg-gray-50 py-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-14">
                <h2 class="text-3xl font-bold text-gray-900 mb-3">Semua yang kamu butuhkan</h2>
                <p class="text-gray-500">Fitur-fitur yang dibuat berdasarkan kebutuhan nyata pemilik hewan peliharaan.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach([
                    ['💉', 'Buku Vaksin', 'Catat riwayat vaksinasi lengkap per hewan. Download sebagai PDF kapan saja untuk dibawa ke dokter hewan.'],
                    ['🐜', 'Obat Rutin', 'Pantau tanggal terakhir pemberian obat kutu dan obat cacing. Badge merah otomatis muncul kalau sudah lebih dari 90 hari.'],
                    ['📸', 'Profil Lengkap', 'Foto, jenis, ras, umur, berat badan, jenis kelamin, hingga link Instagram dan TikTok hewan kamu.'],
                    ['🤖', 'PetBot AI', 'Tanya seputar kesehatan, perawatan, dan data hewan kamu langsung ke chatbot berbasis AI — gratis.'],
                    ['📊', 'Dashboard', 'Ringkasan cepat: berapa total hewan aktif, jadwal vaksin yang mendekat, dan statistik per jenis hewan.'],
                    ['👥', 'Multi User', 'Kelola akses tim dengan fitur manajemen user. Aktifkan atau nonaktifkan akun kapan saja.'],
                ] as [$icon, $title, $desc])
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:border-gray-300 hover:shadow-sm transition-all">
                        <div class="text-3xl mb-4">{{ $icon }}</div>
                        <h3 class="font-semibold text-gray-900 mb-2">{{ $title }}</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Highlights --}}
    <section class="py-16 border-t border-gray-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-8 text-center">
                @foreach([
                    ['🐾', 'Semua Jenis', 'Anjing, kucing, burung, kelinci, hamster, ikan, reptil, dan lainnya'],
                    ['📄', 'Export PDF', 'Buku vaksin siap cetak langsung dari aplikasi'],
                    ['⚡', 'Real-time', 'Data selalu sinkron, tidak perlu refresh manual'],
                    ['🔒', 'Aman', 'Login wajib, data hewan tidak bisa diakses sembarangan'],
                ] as [$icon, $label, $desc])
                    <div>
                        <div class="text-4xl mb-2">{{ $icon }}</div>
                        <div class="font-semibold text-gray-900 text-sm mb-1">{{ $label }}</div>
                        <div class="text-xs text-gray-400 leading-relaxed">{{ $desc }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-gray-900 py-20">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 text-center">
            <div class="text-5xl mb-6">🐾</div>
            <h2 class="text-3xl font-bold text-white mb-4">
                Mulai catat hewan peliharaan kamu hari ini
            </h2>
            <p class="text-gray-400 mb-8 leading-relaxed">
                Daftar gratis, tidak perlu kartu kredit. Langsung bisa dipakai.
            </p>
            @auth
                <a href="{{ route('dashboard') }}"
                   class="inline-block bg-white text-gray-900 font-semibold px-8 py-3.5 rounded-xl hover:bg-gray-100 transition-colors">
                    Buka Dashboard &rarr;
                </a>
            @else
                <a href="{{ route('register') }}"
                   class="inline-block bg-white text-gray-900 font-semibold px-8 py-3.5 rounded-xl hover:bg-gray-100 transition-colors">
                    Daftar Sekarang &mdash; Gratis &rarr;
                </a>
            @endauth
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-gray-100 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            copyright &copy; {{ date('Y') }} {{ config('app.name', 'PetCare') }}. All rights reserved.
            <div class="flex items-center gap-4">
                <a href="#" class="text-gray-400 hover:text-gray-900 text-sm">Privacy Policy</a>
                <a href="#" class="text-gray-400 hover:text-gray-900 text-sm">Terms of Service</a>
            </div>
        </div>
    </footer>

</body>
</html>
