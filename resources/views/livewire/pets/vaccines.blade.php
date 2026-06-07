<div>
    {{-- Flash --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
             class="mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Back + Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('pets.index') }}"
           class="flex items-center justify-center w-8 h-8 rounded-lg bg-white shadow hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div class="flex-1">
            <h2 class="text-xl font-semibold text-gray-800">Buku Vaksin</h2>
            <p class="text-sm text-gray-500 mt-0.5">{{ $pet->name }} · {{ $pet->type }}{{ $pet->breed ? ' · ' . $pet->breed : '' }}</p>
        </div>
        <div class="flex items-center gap-2">
            {{-- Download PDF --}}
            <a href="{{ route('pets.vaccines.pdf', $pet->id) }}" target="_blank"
               class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download PDF
            </a>
            {{-- Tambah Vaksin --}}
            <button wire:click="openCreate"
                    class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Vaksin
            </button>
        </div>
    </div>

    {{-- Pet info card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6 flex items-center gap-5">
        @if($pet->image)
            <img src="{{ asset('storage/' . $pet->image) }}" class="w-16 h-16 rounded-full object-cover border-2 border-gray-200"/>
        @else
            <div class="w-16 h-16 rounded-full bg-pink-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
        @endif
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 flex-1">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Nama</p>
                <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $pet->name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Jenis</p>
                <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $pet->type }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Ras</p>
                <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $pet->breed ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Total Vaksin</p>
                <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $vaccines->count() }} entri</p>
            </div>
        </div>
    </div>

    {{-- Vaccine list --}}
    @if($vaccines->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <p class="text-gray-500 font-medium">Belum ada riwayat vaksin.</p>
            <p class="text-sm text-gray-400 mt-1">Klik "Tambah Vaksin" untuk mulai mencatat.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach($vaccines as $i => $vaccine)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <div class="flex items-start justify-between gap-4">
                        {{-- Badge no urut --}}
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm flex-shrink-0">
                                {{ $vaccines->count() - $i }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h3 class="text-base font-semibold text-gray-800">{{ $vaccine->vaccine_name }}</h3>
                                    @if($vaccine->next_vaccine_date && $vaccine->next_vaccine_date->isPast())
                                        <span class="inline-flex items-center gap-1 text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            Jadwal terlewat
                                        </span>
                                    @elseif($vaccine->next_vaccine_date && $vaccine->next_vaccine_date->diffInDays(now()) <= 30)
                                        <span class="inline-flex items-center gap-1 text-xs bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                            Segera
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-2 grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    <div>
                                        <p class="text-xs text-gray-400">Tanggal Vaksin</p>
                                        <p class="text-sm font-medium text-gray-700 mt-0.5">{{ $vaccine->vaccine_date->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400">Vaksin Berikutnya</p>
                                        <p class="text-sm font-medium mt-0.5 {{ $vaccine->next_vaccine_date?->isPast() ? 'text-red-600' : 'text-gray-700' }}">
                                            {{ $vaccine->next_vaccine_date?->format('d M Y') ?? '-' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400">Dokter / Petugas</p>
                                        <p class="text-sm font-medium text-gray-700 mt-0.5">{{ $vaccine->administered_by ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400">Klinik</p>
                                        <p class="text-sm font-medium text-gray-700 mt-0.5">{{ $vaccine->clinic ?? '-' }}</p>
                                    </div>
                                </div>
                                @if($vaccine->notes)
                                    <p class="mt-2 text-sm text-gray-500 italic">{{ $vaccine->notes }}</p>
                                @endif
                            </div>
                        </div>
                        {{-- Actions --}}
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <button wire:click="openEdit({{ $vaccine->id }})"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</button>
                            <span class="text-gray-300">|</span>
                            <button wire:click="confirmDelete({{ $vaccine->id }})"
                                    class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Modal Create / Edit --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50" wire:click="$set('showModal', false)"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-lg max-h-[92vh] flex flex-col">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 flex-shrink-0">
                    <h3 class="text-lg font-semibold text-gray-800">
                        {{ $modalMode === 'create' ? 'Tambah Vaksin' : 'Edit Vaksin' }}
                    </h3>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form wire:submit="save" class="overflow-y-auto flex-1 px-6 py-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Vaksin</label>
                        <input type="text" wire:model="vaccine_name"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('vaccine_name') border-red-400 @enderror"
                               placeholder="Contoh: Rabies, Distemper, ..."/>
                        @error('vaccine_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Vaksin</label>
                            <input type="date" wire:model="vaccine_date"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('vaccine_date') border-red-400 @enderror"/>
                            @error('vaccine_date')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Vaksin Berikutnya <span class="text-gray-400 font-normal">(opsional)</span>
                            </label>
                            <input type="date" wire:model="next_vaccine_date"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('next_vaccine_date') border-red-400 @enderror"/>
                            @error('next_vaccine_date')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dokter / Petugas <span class="text-gray-400 font-normal">(opsional)</span></label>
                            <input type="text" wire:model="administered_by"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="drh. Nama Dokter"/>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Klinik <span class="text-gray-400 font-normal">(opsional)</span></label>
                            <input type="text" wire:model="clinic"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Nama klinik hewan"/>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <textarea wire:model="notes" rows="3"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Catatan tambahan..."></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" wire:click="$set('showModal', false)"
                                class="px-4 py-2 text-sm text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                            {{ $modalMode === 'create' ? 'Simpan' : 'Update' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Modal Hapus --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/50" wire:click="$set('showDeleteModal', false)"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-sm mx-4 p-6">
                <div class="flex items-center justify-center w-12 h-12 bg-red-100 rounded-full mx-auto mb-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-center text-lg font-semibold text-gray-800 mb-2">Hapus Vaksin?</h3>
                <p class="text-center text-sm text-gray-500 mb-6">Data vaksin akan dihapus secara permanen.</p>
                <div class="flex gap-3">
                    <button wire:click="$set('showDeleteModal', false)"
                            class="flex-1 px-4 py-2 text-sm text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Batal
                    </button>
                    <button wire:click="delete"
                            class="flex-1 px-4 py-2 text-sm text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
