<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-screen flex overflow-hidden bg-white">

    {{-- Left: Slider panel (hidden on mobile) --}}
    <div class="hidden lg:flex lg:w-1/2 xl:w-3/5 bg-gray-900 flex-col relative overflow-hidden"
         x-data="{
             current: 0,
             slides: [
                 {
                     emoji: '🐾',
                     title: 'Kelola hewan peliharaan\ndengan mudah',
                     desc: 'Satu tempat untuk semua catatan, kesehatan, dan jadwal vaksin hewan kesayangan kamu.',
                     color: 'from-teal-900 to-gray-900',
                     accent: 'bg-teal-500',
                 },
                 {
                     emoji: '💉',
                     title: 'Jangan sampai vaksin\nterlewat',
                     desc: 'Pantau jadwal vaksinasi, obat kutu, dan obat cacing — semua tercatat rapi dengan status otomatis.',
                     color: 'from-indigo-900 to-gray-900',
                     accent: 'bg-indigo-500',
                 },
                 {
                     emoji: '🤖',
                     title: 'PetBot siap menjawab\npertanyaan kamu',
                     desc: 'Tanya seputar perawatan dan kesehatan hewan langsung ke chatbot AI kami, kapan saja dan gratis.',
                     color: 'from-violet-900 to-gray-900',
                     accent: 'bg-violet-500',
                 },
             ],
             init() {
                 setInterval(() => { this.current = (this.current + 1) % this.slides.length }, 4500)
             }
         }">

        {{-- Background gradient (transitions with slide) --}}
        <template x-for="(slide, i) in slides" :key="i">
            <div class="absolute inset-0 bg-gradient-to-br transition-opacity duration-700"
                 :class="[slide.color, current === i ? 'opacity-100' : 'opacity-0']">
            </div>
        </template>

        {{-- Decorative circles --}}
        <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full bg-white/5"></div>
        <div class="absolute -bottom-32 -left-20 w-80 h-80 rounded-full bg-white/5"></div>

        {{-- Brand --}}
        <div class="relative z-10 px-10 pt-10">
            <a href="/" class="inline-flex items-center gap-2 text-white">
                <span class="text-2xl">🐾</span>
                <span class="text-lg font-bold">{{ config('app.name', 'PetCare') }}</span>
            </a>
        </div>

        {{-- Slide content --}}
        <div class="relative z-10 flex-1 flex flex-col items-center justify-center px-12 text-center">
            <template x-for="(slide, i) in slides" :key="i">
                <div class="absolute inset-0 flex flex-col items-center justify-center px-12 transition-all duration-700"
                     :class="current === i ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4 pointer-events-none'">

                    <div class="text-8xl mb-8 drop-shadow-lg" x-text="slide.emoji"></div>

                    <h2 class="text-3xl xl:text-4xl font-bold text-white leading-tight mb-5 whitespace-pre-line"
                        x-text="slide.title"></h2>

                    <p class="text-gray-300 text-base xl:text-lg leading-relaxed max-w-md"
                       x-text="slide.desc"></p>
                </div>
            </template>
        </div>

        {{-- Dots --}}
        <div class="relative z-10 flex items-center justify-center gap-2 pb-10">
            <template x-for="(slide, i) in slides" :key="i">
                <button @click="current = i"
                        class="rounded-full transition-all duration-300"
                        :class="current === i ? 'w-6 h-2 ' + slide.accent : 'w-2 h-2 bg-white/30 hover:bg-white/50'">
                </button>
            </template>
        </div>
    </div>

    {{-- Right: Form panel --}}
    <div class="w-full lg:w-1/2 xl:w-2/5 flex flex-col overflow-y-auto">

        {{-- Mobile brand (visible only on mobile) --}}
        <div class="lg:hidden flex items-center justify-center gap-2 pt-8 pb-2">
            <a href="/" class="inline-flex items-center gap-2 text-gray-800">
                <span class="text-2xl">🐾</span>
                <span class="text-lg font-bold">{{ config('app.name', 'PetCare') }}</span>
            </a>
        </div>

        <div class="flex-1 flex items-center justify-center p-6 sm:p-10">
            <div class="w-full max-w-sm">
                {{ $slot }}
            </div>
        </div>

        <p class="text-center text-xs text-gray-400 pb-6">
            &copy; {{ date('Y') }} {{ config('app.name', 'PetCare') }}
        </p>
    </div>

</body>
@livewireScriptConfig
</html>
