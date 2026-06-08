<div class="flex flex-col h-full w-full overflow-hidden">

    {{-- Header --}}
    <div class="flex items-center justify-between px-4 md:px-6 py-3 md:py-4 bg-white border-b border-gray-200 flex-shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-gradient-to-br from-green-400 to-teal-500 flex items-center justify-center text-lg md:text-xl shadow flex-shrink-0">
                🐾
            </div>
            <div>
                <h2 class="font-semibold text-gray-800 text-sm md:text-base">PetBot</h2>
                <div class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-green-400"></span>
                    <span class="text-xs text-gray-500">Ahli hewan peliharaan · Groq AI</span>
                </div>
            </div>
        </div>
        <button wire:click="clearChat"
                class="flex items-center gap-1.5 text-xs md:text-sm text-gray-500 hover:text-red-500 transition-colors px-2 md:px-3 py-1.5 rounded-lg hover:bg-red-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            <span class="hidden sm:inline">Hapus Chat</span>
        </button>
    </div>

    {{-- Messages area --}}
    <div class="flex-1 overflow-y-auto px-3 md:px-6 py-4 space-y-4 bg-gray-50"
         id="chat-messages"
         x-data
         x-init="$watch('$wire.messages', () => { $nextTick(() => scrollToBottom()) }); $watch('$wire.isThinking', () => { $nextTick(() => scrollToBottom()) })">

        {{-- Welcome state --}}
        @if(count($messages) === 0 && !$isThinking)
            <div class="flex flex-col items-center justify-center min-h-full text-center py-8 px-4">
                <div class="text-5xl md:text-6xl mb-3">🐾</div>
                <h3 class="text-base md:text-lg font-semibold text-gray-700 mb-2">Halo! Saya PetBot 👋</h3>
                <p class="text-xs md:text-sm text-gray-500 max-w-sm mb-6">
                    Tanya saya seputar hewan peliharaan — perawatan, kesehatan, makanan, perilaku, vaksin, dan lainnya!
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 w-full max-w-md">
                    @foreach([
                        '📋 Tampilkan daftar semua hewan yang terdaftar',
                        '💉 Hewan mana yang jadwal vaksinnya sudah terlewat?',
                        '🐶 Apa saja tips perawatan untuk anjing?',
                        '🐱 Kenapa kucing saya sering muntah?',
                    ] as $suggestion)
                        <button wire:click="$set('input', '{{ $suggestion }}')"
                                class="text-left text-xs md:text-sm px-3 md:px-4 py-2.5 bg-white border border-gray-200 rounded-xl hover:border-teal-400 hover:bg-teal-50 transition-colors text-gray-600 hover:text-teal-700 shadow-sm">
                            {{ $suggestion }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Chat messages --}}
        @foreach($messages as $message)
            @if($message['role'] === 'user')
                <div class="flex justify-end">
                    <div class="max-w-[80%] sm:max-w-md lg:max-w-xl">
                        <div class="bg-teal-500 text-white px-3 md:px-4 py-2.5 md:py-3 rounded-2xl rounded-tr-sm shadow-sm">
                            <p class="text-sm leading-relaxed whitespace-pre-wrap">{{ $message['content'] }}</p>
                        </div>
                        <p class="text-xs text-gray-400 mt-1 text-right pr-1">{{ $message['time'] }}</p>
                    </div>
                </div>
            @else
                <div class="flex gap-2 md:gap-3">
                    <div class="w-7 h-7 md:w-8 md:h-8 rounded-full bg-gradient-to-br from-green-400 to-teal-500 flex items-center justify-center text-xs md:text-sm flex-shrink-0 shadow mt-0.5">
                        🐾
                    </div>
                    <div class="max-w-[80%] sm:max-w-md lg:max-w-xl">
                        <div class="bg-white px-3 md:px-4 py-2.5 md:py-3 rounded-2xl rounded-tl-sm shadow-sm border border-gray-100">
                            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $message['content'] }}</p>
                        </div>
                        <p class="text-xs text-gray-400 mt-1 pl-1">{{ $message['time'] }}</p>
                    </div>
                </div>
            @endif
        @endforeach

        {{-- Thinking indicator --}}
        @if($isThinking)
            <div class="flex gap-2 md:gap-3">
                <div class="w-7 h-7 md:w-8 md:h-8 rounded-full bg-gradient-to-br from-green-400 to-teal-500 flex items-center justify-center text-xs md:text-sm flex-shrink-0 shadow">
                    🐾
                </div>
                <div class="bg-white px-4 py-3 rounded-2xl rounded-tl-sm shadow-sm border border-gray-100">
                    <div class="flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-teal-400 animate-bounce" style="animation-delay:0ms"></span>
                        <span class="w-2 h-2 rounded-full bg-teal-400 animate-bounce" style="animation-delay:150ms"></span>
                        <span class="w-2 h-2 rounded-full bg-teal-400 animate-bounce" style="animation-delay:300ms"></span>
                    </div>
                </div>
            </div>
        @endif

        {{-- Error --}}
        @if($error)
            <div class="flex justify-center px-4">
                <div class="flex items-start gap-2 bg-red-50 border border-red-200 text-red-600 text-xs md:text-sm px-3 md:px-4 py-2.5 rounded-lg max-w-sm text-center">
                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    {{ $error }}
                </div>
            </div>
        @endif

        <div id="chat-bottom"></div>
    </div>

    {{-- Input area --}}
    <div class="px-3 md:px-6 py-3 md:py-4 bg-white border-t border-gray-200 flex-shrink-0"
         x-data="{
             localInput: '',
             get canSend() { return !$wire.isThinking && this.localInput.trim() !== '' },
             init() {
                 this.$watch('$wire.input', val => { if (val === '') this.localInput = '' })
             }
         }">
        <form wire:submit="sendMessage" class="flex gap-2 md:gap-3 items-end">
            <div class="flex-1 relative">
                <textarea
                    wire:model="input"
                    x-model="localInput"
                    placeholder="Tanya seputar hewan peliharaan kamu..."
                    rows="1"
                    class="w-full border border-gray-300 rounded-xl px-3 md:px-4 py-2.5 md:py-3 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400 focus:border-transparent resize-none leading-relaxed"
                    style="min-height: 44px; max-height: 120px;"
                    :disabled="$wire.isThinking"
                    x-on:keydown.enter.prevent.exact="if(!$event.shiftKey && canSend) $wire.sendMessage()"
                    x-on:input="$el.style.height = 'auto'; $el.style.height = Math.min($el.scrollHeight, 120) + 'px'"
                ></textarea>
            </div>
            <button type="submit"
                    :disabled="!canSend"
                    :class="canSend ? 'bg-teal-500 hover:bg-teal-600 text-white shadow-sm' : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
                    class="w-10 h-10 md:w-11 md:h-11 rounded-xl flex items-center justify-center transition-colors flex-shrink-0">
                <template x-if="$wire.isThinking">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                </template>
                <template x-if="!$wire.isThinking">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </template>
            </button>
        </form>
        <p class="text-xs text-gray-400 mt-1.5 text-center hidden sm:block">
            PetBot hanya menjawab pertanyaan seputar hewan · Enter kirim · Shift+Enter baris baru
        </p>
    </div>
</div>

<script>
function scrollToBottom() {
    const el = document.getElementById('chat-bottom');
    if (el) el.scrollIntoView({ behavior: 'smooth' });
}
document.addEventListener('livewire:initialized', () => {
    Livewire.hook('commit', ({ succeed }) => {
        succeed(() => { setTimeout(scrollToBottom, 50); });
    });
});
</script>
