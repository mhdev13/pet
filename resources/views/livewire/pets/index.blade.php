<div>
    {{-- Flash messages --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
             class="mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             class="mb-4 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Pet Management</h2>
        <button wire:click="openCreate"
                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pet
        </button>
    </div>

    {{-- Filter + Search --}}
    <div class="bg-white rounded-lg shadow mb-4">
        <div class="flex border-b border-gray-200 px-4">
            @foreach(['all' => 'Semua', 'active' => 'Active', 'inactive' => 'Inactive'] as $val => $label)
                <button wire:click="$set('filterStatus', '{{ $val }}')"
                        class="px-4 py-3 text-sm font-medium border-b-2 transition-colors
                               {{ $filterStatus === $val ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                    {{ $label }}
                    <span class="ml-1 text-xs px-2 py-0.5 rounded-full
                                 {{ $val === 'active' ? 'bg-green-100 text-green-700' : ($val === 'inactive' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-600') }}">
                        {{ $val === 'all' ? $totalActive + $totalInactive : ($val === 'active' ? $totalActive : $totalInactive) }}
                    </span>
                </button>
            @endforeach
        </div>
        <div class="flex gap-3 p-4">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search"
                       placeholder="Cari nama, ras, atau jenis..."
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
            </div>
            <select wire:model.live="filterType"
                    class="border border-gray-300 rounded-md text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Jenis</option>
                @foreach($types as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-8">#</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pet</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button wire:click="sortBy('type')" class="flex items-center gap-1 hover:text-gray-700">
                            Jenis
                            @if($sortField === 'type')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                </svg>
                            @endif
                        </button>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ras</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button wire:click="sortBy('age')" class="flex items-center gap-1 hover:text-gray-700">
                            Umur
                            @if($sortField === 'age')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                </svg>
                            @endif
                        </button>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button wire:click="sortBy('weight')" class="flex items-center gap-1 hover:text-gray-700">
                            Berat
                            @if($sortField === 'weight')
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"/>
                                </svg>
                            @endif
                        </button>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelamin</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Obat Kutu</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Obat Cacing</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sosmed</th>
                    @if(auth()->user()->isAdmin())
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pet Owner</th>
                    @endif
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($pets as $pet)
                    <tr class="hover:bg-gray-50 transition-colors {{ !$pet->is_active ? 'opacity-60' : '' }}">
                        <td class="px-4 py-3 text-sm text-gray-400">{{ $pets->firstItem() + $loop->index }}</td>

                        {{-- Photo + Name --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if($pet->image)
                                    <img src="{{ asset('storage/' . $pet->image) }}"
                                         alt="{{ $pet->name }}"
                                         class="w-10 h-10 rounded-full object-cover flex-shrink-0 border border-gray-200"/>
                                @else
                                    <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    </div>
                                @endif
                                <span class="text-sm font-medium text-gray-900">{{ $pet->name }}</span>
                            </div>
                        </td>

                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $pet->type }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $pet->breed ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $pet->age !== null ? $pet->age . ' thn' : '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $pet->weight !== null ? $pet->weight . ' kg' : '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ $pet->gender === 'male' ? 'Jantan' : 'Betina' }}
                        </td>

                        {{-- Obat Kutu --}}
                        <td class="px-4 py-3 text-sm">
                            @if($pet->flea_medicine_date)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium
                                    {{ $pet->flea_medicine_date->diffInDays(now()) > 90 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                    🐜 {{ $pet->flea_medicine_date->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-gray-300 text-xs">-</span>
                            @endif
                        </td>

                        {{-- Obat Cacing --}}
                        <td class="px-4 py-3 text-sm">
                            @if($pet->deworming_date)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium
                                    {{ $pet->deworming_date->diffInDays(now()) > 90 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                    🪱 {{ $pet->deworming_date->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-gray-300 text-xs">-</span>
                            @endif
                        </td>

                        {{-- Social media icons --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                @if($pet->instagram)
                                    <a href="{{ $pet->instagram }}" target="_blank"
                                       class="text-gray-400 hover:text-pink-500 transition-colors" title="Instagram">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                        </svg>
                                    </a>
                                @endif
                                @if($pet->facebook)
                                    <a href="{{ $pet->facebook }}" target="_blank"
                                       class="text-gray-400 hover:text-blue-600 transition-colors" title="Facebook">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </a>
                                @endif
                                @if($pet->tiktok)
                                    <a href="{{ $pet->tiktok }}" target="_blank"
                                       class="text-gray-400 hover:text-gray-900 transition-colors" title="TikTok">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                        </svg>
                                    </a>
                                @endif
                                @if(!$pet->instagram && !$pet->facebook && !$pet->tiktok)
                                    <span class="text-xs text-gray-300">-</span>
                                @endif
                            </div>
                        </td>

                        @if(auth()->user()->isAdmin())
                        <td class="px-4 py-3">
                            @if($pet->user)
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600 flex-shrink-0">
                                        {{ strtoupper(substr($pet->user->name, 0, 1)) }}
                                    </div>
                                    <span class="text-sm text-gray-700">{{ $pet->user->name }}</span>
                                </div>
                            @else
                                <span class="text-xs text-gray-300">-</span>
                            @endif
                        </td>
                        @endif

                        <td class="px-4 py-3">
                            <button wire:click="toggleStatus({{ $pet->id }})"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium transition-colors cursor-pointer
                                           {{ $pet->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $pet->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ $pet->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </td>

                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('pets.vaccines', $pet->id) }}"
                                   class="inline-flex items-center gap-1 text-sm text-purple-600 hover:text-purple-800 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Vaksin
                                </a>
                                <span class="text-gray-300">|</span>
                                <button wire:click="openEdit({{ $pet->id }})"
                                        class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </button>
                                <span class="text-gray-300">|</span>
                                <button wire:click="confirmDelete({{ $pet->id }})"
                                        class="inline-flex items-center gap-1 text-sm text-red-600 hover:text-red-800 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 13 : 12 }}" class="px-6 py-12 text-center text-gray-400">
                            <svg class="mx-auto w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <p class="text-sm">Belum ada pet. Klik "Tambah Pet" untuk mulai.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        @if($pets->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $pets->links() }}
            </div>
        @endif
    </div>

    @if($pets->total() > 0)
        <p class="mt-3 text-sm text-gray-500">
            Menampilkan {{ $pets->firstItem() }}–{{ $pets->lastItem() }} dari {{ $pets->total() }} pet
        </p>
    @endif

    {{-- Modal Create / Edit --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/50" wire:click="$set('showModal', false)"></div>
            <div class="relative bg-white rounded-xl shadow-xl w-full max-w-lg max-h-[92vh] flex flex-col">

                {{-- Modal header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 flex-shrink-0">
                    <h3 class="text-lg font-semibold text-gray-800">
                        {{ $modalMode === 'create' ? 'Tambah Pet' : 'Edit Pet' }}
                    </h3>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Modal body (scrollable) --}}
                <form wire:submit="save" class="overflow-y-auto flex-1 px-6 py-4 space-y-5">

                    {{-- Upload foto --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Pet</label>

                        {{-- Preview --}}
                        @if($photo)
                            <div class="relative inline-block mb-3">
                                <img src="{{ $photo->temporaryUrl() }}" class="w-24 h-24 rounded-xl object-cover border border-gray-200"/>
                                <button type="button" wire:click="removeImage"
                                        class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center text-white hover:bg-red-600">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        @elseif($existingImage)
                            <div class="relative inline-block mb-3">
                                <img src="{{ asset('storage/' . $existingImage) }}" class="w-24 h-24 rounded-xl object-cover border border-gray-200"/>
                                <button type="button" wire:click="removeImage"
                                        class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center text-white hover:bg-red-600">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        @endif

                        {{-- Drop zone --}}
                        @if(!$photo && !$existingImage)
                            <label class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-colors">
                                <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm text-gray-500">Klik untuk upload foto</span>
                                <span class="text-xs text-gray-400 mt-1">JPG, PNG, max 2MB</span>
                                <input type="file" wire:model="photo" accept="image/*" class="hidden"/>
                            </label>
                        @else
                            <label class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Ganti foto
                                <input type="file" wire:model="photo" accept="image/*" class="hidden"/>
                            </label>
                        @endif

                        @error('photo')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror

                        <div wire:loading wire:target="photo" class="mt-2 text-xs text-blue-500 flex items-center gap-1">
                            <svg class="animate-spin w-3 h-3" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                            Mengupload...
                        </div>
                    </div>

                    {{-- Nama --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pet</label>
                        <input type="text" wire:model="name"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-400 @enderror"
                               placeholder="Nama pet"/>
                        @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- Pet Owner (admin only) --}}
                    @if(auth()->user()->isAdmin())
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pet Owner</label>
                        <select wire:model="user_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-400 @enderror">
                            <option value="">Tanpa owner</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    @endif

                    {{-- Jenis + Ras --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
                            <select wire:model="type"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('type') border-red-400 @enderror">
                                <option value="">Pilih jenis</option>
                                @foreach($types as $t)
                                    <option value="{{ $t }}">{{ $t }}</option>
                                @endforeach
                            </select>
                            @error('type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ras <span class="text-gray-400 font-normal">(opsional)</span></label>
                            <input type="text" wire:model="breed"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Contoh: Golden Retriever"/>
                        </div>
                    </div>

                    {{-- Umur + Berat + Kelamin --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Umur <span class="text-gray-400 font-normal">(tahun, opsional)</span></label>
                            <input type="number" wire:model="age" min="0" max="100"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('age') border-red-400 @enderror"
                                   placeholder="0"/>
                            @error('age')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Berat Badan <span class="text-gray-400 font-normal">(kg, opsional)</span></label>
                            <div class="relative">
                                <input type="number" wire:model="weight" min="0" max="999" step="0.01"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('weight') border-red-400 @enderror"
                                       placeholder="0.00"/>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">kg</span>
                            </div>
                            @error('weight')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    {{-- Kelamin --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kelamin</label>
                        <div class="flex gap-4 mt-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="gender" value="male" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"/>
                                <span class="text-sm text-gray-700">Jantan</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="gender" value="female" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"/>
                                <span class="text-sm text-gray-700">Betina</span>
                            </label>
                        </div>
                    </div>

                    {{-- Kesehatan Rutin --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kesehatan Rutin <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">🐜 Tgl. Obat Kutu Terakhir</label>
                                <input type="date" wire:model="flea_medicine_date"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('flea_medicine_date') border-red-400 @enderror"/>
                                @error('flea_medicine_date')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">🪱 Tgl. Obat Cacing Terakhir</label>
                                <input type="date" wire:model="deworming_date"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('deworming_date') border-red-400 @enderror"/>
                                @error('deworming_date')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="is_active" value="1" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"/>
                                <span class="flex items-center gap-1.5 text-sm text-gray-700">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>Active
                                </span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="is_active" value="0" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"/>
                                <span class="flex items-center gap-1.5 text-sm text-gray-700">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>Inactive
                                </span>
                            </label>
                        </div>
                    </div>

                    {{-- Social Media --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Social Media <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <div class="space-y-2">
                            {{-- Instagram --}}
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 via-pink-500 to-orange-400 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </div>
                                <input type="text" wire:model="instagram"
                                       class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-pink-400"
                                       placeholder="https://instagram.com/nama_pet"/>
                            </div>
                            {{-- Facebook --}}
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </div>
                                <input type="text" wire:model="facebook"
                                       class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                       placeholder="https://facebook.com/nama_pet"/>
                            </div>
                            {{-- TikTok --}}
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                    </svg>
                                </div>
                                <input type="text" wire:model="tiktok"
                                       class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400"
                                       placeholder="https://tiktok.com/@nama_pet"/>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex justify-end gap-3 pt-2 pb-1">
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

    {{-- Modal Konfirmasi Hapus --}}
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
                <h3 class="text-center text-lg font-semibold text-gray-800 mb-2">Hapus Pet?</h3>
                <p class="text-center text-sm text-gray-500 mb-6">Data pet beserta foto akan dihapus secara permanen.</p>
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
