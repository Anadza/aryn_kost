<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Data Kamar - {{ config('app.name', 'Aryn Kost') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="font-sans antialiased bg-[#EADCC6]">

    <div class="min-h-screen flex items-start justify-center p-3 sm:p-6 lg:p-10"
         x-data="kamarPage()">

        <div class="w-full max-w-6xl bg-[#EADCC6] rounded-[28px] shadow-2xl overflow-hidden">

            {{-- ===== Header ===== --}}
            <div class="bg-[#1E3A5F] px-4 sm:px-8 py-5 sm:py-6 flex items-center justify-between">
                <div class="flex items-center gap-3 sm:gap-4">
                    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('dashboard') }}"
                       class="text-white hover:opacity-80 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h1 class="text-white font-bold text-lg sm:text-2xl tracking-wide">Data Kamar</h1>
                </div>

                <button type="button" class="relative text-white hover:opacity-80 transition" title="Notifikasi">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute -top-0.5 -right-0.5 h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-[#1E3A5F]"></span>
                </button>
            </div>

            {{-- ===== Content ===== --}}
            <div class="p-4 sm:p-8 space-y-5 sm:space-y-6">

                @if (session('success'))
                    <div class="bg-green-100 text-green-700 text-sm font-medium px-4 py-3 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Search & Filter --}}
                <form method="GET" action="{{ route('kamar.index') }}" x-ref="searchForm"
                      class="flex flex-col sm:flex-row sm:items-end gap-3 sm:gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m1.1-5.4a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" />
                                </svg>
                            </span>
                            <input
                                type="text"
                                name="search"
                                value="{{ $search }}"
                                placeholder="Cari Kamar"
                                autocomplete="off"
                                @input.debounce.400ms="$refs.searchForm.requestSubmit()"
                                class="w-full sm:max-w-xs pl-9 pr-4 py-2.5 rounded-xl border-0 shadow-sm text-sm text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-[#1E3A5F]"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Status</label>
                        <select
                            name="status"
                            onchange="this.form.requestSubmit()"
                            class="w-full sm:w-44 rounded-xl border-0 shadow-sm text-sm text-gray-700 focus:ring-2 focus:ring-[#1E3A5F]"
                        >
                            <option value="" {{ $statusFilter === '' ? 'selected' : '' }}>Select...</option>
                            <option value="kosong" {{ $statusFilter === 'kosong' ? 'selected' : '' }}>Kosong</option>
                            <option value="terisi" {{ $statusFilter === 'terisi' ? 'selected' : '' }}>Terisi</option>
                            <option value="booking" {{ $statusFilter === 'booking' ? 'selected' : '' }}>Booking</option>
                        </select>
                    </div>

                    <div class="sm:ml-auto">
                        <button
                            type="button"
                            @click="openAdd()"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#1E3A5F] hover:bg-[#16304f] text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Kamar
                        </button>
                    </div>
                </form>

                {{-- Table card --}}
                <div class="bg-white rounded-2xl shadow-md p-4 sm:p-6">
                    @if ($kamars->isEmpty())
                        <p class="text-gray-400 text-sm text-center py-10">Tidak ada data kamar yang cocok.</p>
                    @else
                        {{-- Desktop / tablet table --}}
                        <div class="hidden md:block overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-left text-gray-400 text-xs tracking-wide border-b border-gray-100">
                                        <th class="py-3 pr-4 font-medium">No</th>
                                        <th class="py-3 pr-4 font-medium">No. Kamar</th>
                                        <th class="py-3 pr-4 font-medium">Tipe</th>
                                        <th class="py-3 pr-4 font-medium">Harga / Bulan</th>
                                        <th class="py-3 pr-4 font-medium">Status</th>
                                        <th class="py-3 pr-0 font-medium">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kamars as $index => $kamar)
                                        <tr class="border-b border-gray-50 last:border-b-0 hover:bg-gray-50/70 transition">
                                            <td class="py-4 pr-4 text-gray-500">{{ $index + 1 }}</td>
                                            <td class="py-4 pr-4 text-gray-700 font-medium whitespace-nowrap">{{ $kamar->no_kamar }}</td>
                                            <td class="py-4 pr-4 text-gray-500 whitespace-nowrap">{{ $kamar->tipe }}</td>
                                            <td class="py-4 pr-4 text-gray-500 whitespace-nowrap">{{ $kamar->hargaFormatted() }}</td>
                                            <td class="py-4 pr-4 whitespace-nowrap">
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $kamar->statusBadgeClass() }}">
                                                    <span class="h-1.5 w-1.5 rounded-full {{ $kamar->statusDotClass() }}"></span>
                                                    {{ $kamar->statusLabel() }}
                                                </span>
                                            </td>
                                            <td class="py-4 pr-0">
                                                <div class="flex items-center gap-2">
                                                    <button type="button" title="Lihat detail"
                                                            @click="openDetail({{ Illuminate\Support\Js::from($kamar) }})"
                                                            class="p-1.5 rounded-lg text-gray-400 hover:text-[#1E3A5F] hover:bg-gray-100 transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                    </button>
                                                    <button type="button" title="Edit kamar"
                                                            @click="openEdit({{ Illuminate\Support\Js::from($kamar) }})"
                                                            class="p-1.5 rounded-lg text-gray-400 hover:text-[#1E3A5F] hover:bg-gray-100 transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Mobile stacked cards --}}
                        <div class="md:hidden space-y-3">
                            @foreach ($kamars as $index => $kamar)
                                <div class="border border-gray-100 rounded-xl p-4 shadow-sm">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $kamar->no_kamar }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $kamar->tipe }} &middot; {{ $kamar->hargaFormatted() }}</p>
                                        </div>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold shrink-0 {{ $kamar->statusBadgeClass() }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $kamar->statusDotClass() }}"></span>
                                            {{ $kamar->statusLabel() }}
                                        </span>
                                    </div>

                                    <div class="mt-3 flex items-center justify-end gap-2">
                                        <button type="button" title="Lihat detail"
                                                @click="openDetail({{ Illuminate\Support\Js::from($kamar) }})"
                                                class="p-1.5 rounded-lg text-gray-400 hover:text-[#1E3A5F] hover:bg-gray-100 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>
                                        <button type="button" title="Edit kamar"
                                                @click="openEdit({{ Illuminate\Support\Js::from($kamar) }})"
                                                class="p-1.5 rounded-lg text-gray-400 hover:text-[#1E3A5F] hover:bg-gray-100 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ===================== MODAL: DETAIL ===================== --}}
        <div x-show="showDetail" x-cloak
             class="fixed inset-0 z-40 flex items-center justify-center p-4 bg-black/40"
             @click.self="showDetail = false">
            <div x-show="showDetail" x-transition
                 class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-[#1E3A5F]">Detail Kamar</h3>
                    <button type="button" @click="showDetail = false" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <template x-if="selected">
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-400">No. Kamar</dt>
                            <dd class="font-semibold text-gray-800" x-text="selected.no_kamar"></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-400">Tipe</dt>
                            <dd class="font-semibold text-gray-800" x-text="selected.tipe"></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-400">Harga / Bulan</dt>
                            <dd class="font-semibold text-gray-800" x-text="formatRupiah(selected.harga)"></dd>
                        </div>
                        <div class="flex justify-between items-center">
                            <dt class="text-gray-400">Status</dt>
                            <dd>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold"
                                      :class="statusBadgeClass(selected.status)">
                                    <span class="h-1.5 w-1.5 rounded-full" :class="statusDotClass(selected.status)"></span>
                                    <span x-text="statusLabel(selected.status)"></span>
                                </span>
                            </dd>
                        </div>
                    </dl>
                </template>

                <div class="mt-6 flex justify-end">
                    <button type="button" @click="showDetail = false"
                            class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-100 transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        {{-- ===================== MODAL: TAMBAH ===================== --}}
        <div x-show="showAdd" x-cloak
             class="fixed inset-0 z-40 flex items-center justify-center p-4 bg-black/40"
             @click.self="showAdd = false">
            <div x-show="showAdd" x-transition
                 class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-[#1E3A5F]">Tambah Kamar</h3>
                    <button type="button" @click="showAdd = false" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('kamar.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">No. Kamar</label>
                        <input type="text" name="no_kamar" required placeholder="Contoh: A011"
                               class="w-full rounded-xl border-gray-200 shadow-sm text-sm focus:ring-2 focus:ring-[#1E3A5F] focus:border-[#1E3A5F]">
                        @error('no_kamar')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tipe</label>
                        <input type="text" name="tipe" required placeholder="Standar / Deluxe" list="tipe-options"
                               class="w-full rounded-xl border-gray-200 shadow-sm text-sm focus:ring-2 focus:ring-[#1E3A5F] focus:border-[#1E3A5F]">
                        <datalist id="tipe-options">
                            <option value="Standar"></option>
                            <option value="Deluxe"></option>
                        </datalist>
                        @error('tipe')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Harga / Bulan (Rp)</label>
                        <input type="number" name="harga" min="0" step="1000" required placeholder="1000000"
                               class="w-full rounded-xl border-gray-200 shadow-sm text-sm focus:ring-2 focus:ring-[#1E3A5F] focus:border-[#1E3A5F]">
                        @error('harga')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                        <select name="status" required
                                class="w-full rounded-xl border-gray-200 shadow-sm text-sm focus:ring-2 focus:ring-[#1E3A5F] focus:border-[#1E3A5F]">
                            <option value="kosong">Kosong</option>
                            <option value="terisi">Terisi</option>
                            <option value="booking">Booking</option>
                        </select>
                        @error('status')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="showAdd = false"
                                class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-100 transition">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-4 py-2 rounded-xl text-sm font-semibold bg-[#1E3A5F] text-white hover:bg-[#16304f] transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ===================== MODAL: EDIT ===================== --}}
        <div x-show="showEdit" x-cloak
             class="fixed inset-0 z-40 flex items-center justify-center p-4 bg-black/40"
             @click.self="showEdit = false">
            <div x-show="showEdit" x-transition
                 class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-[#1E3A5F]">Edit Kamar</h3>
                    <button type="button" @click="showEdit = false" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <template x-if="selected">
                    <form method="POST" :action="'/kamar/' + selected.id" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">No. Kamar</label>
                            <input type="text" name="no_kamar" x-model="selected.no_kamar" required
                                   class="w-full rounded-xl border-gray-200 shadow-sm text-sm focus:ring-2 focus:ring-[#1E3A5F] focus:border-[#1E3A5F]">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Tipe</label>
                            <input type="text" name="tipe" x-model="selected.tipe" required list="tipe-options-edit"
                                   class="w-full rounded-xl border-gray-200 shadow-sm text-sm focus:ring-2 focus:ring-[#1E3A5F] focus:border-[#1E3A5F]">
                            <datalist id="tipe-options-edit">
                                <option value="Standar"></option>
                                <option value="Deluxe"></option>
                            </datalist>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Harga / Bulan (Rp)</label>
                            <input type="number" name="harga" x-model="selected.harga" min="0" step="1000" required
                                   class="w-full rounded-xl border-gray-200 shadow-sm text-sm focus:ring-2 focus:ring-[#1E3A5F] focus:border-[#1E3A5F]">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                            <select name="status" x-model="selected.status" required
                                    class="w-full rounded-xl border-gray-200 shadow-sm text-sm focus:ring-2 focus:ring-[#1E3A5F] focus:border-[#1E3A5F]">
                                <option value="kosong">Kosong</option>
                                <option value="terisi">Terisi</option>
                                <option value="booking">Booking</option>
                            </select>
                        </div>

                        <div class="flex justify-between items-center pt-2">
                            <button type="button" @click="confirmDelete = true"
                                    class="px-3 py-2 rounded-xl text-xs font-semibold text-red-500 hover:bg-red-50 transition">
                                Hapus Kamar
                            </button>

                            <div class="flex gap-2">
                                <button type="button" @click="showEdit = false"
                                        class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-100 transition">
                                    Batal
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 rounded-xl text-sm font-semibold bg-[#1E3A5F] text-white hover:bg-[#16304f] transition">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </template>
            </div>
        </div>

        {{-- ===================== MODAL: KONFIRMASI HAPUS ===================== --}}
        <div x-show="confirmDelete" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50"
             @click.self="confirmDelete = false">
            <div x-show="confirmDelete" x-transition
                 class="bg-white rounded-2xl shadow-xl w-full max-w-xs p-6 text-center">
                <p class="text-gray-700 text-sm">
                    Yakin ingin menghapus kamar
                    <span class="font-semibold" x-text="selected ? selected.no_kamar : ''"></span>?
                </p>

                <template x-if="selected">
                    <form method="POST" :action="'/kamar/' + selected.id" class="mt-5 flex justify-center gap-2">
                        @csrf
                        @method('DELETE')
                        <button type="button" @click="confirmDelete = false"
                                class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-500 hover:bg-gray-100 transition">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-4 py-2 rounded-xl text-sm font-semibold bg-red-500 text-white hover:bg-red-600 transition">
                            Ya, Hapus
                        </button>
                    </form>
                </template>
            </div>
        </div>

    </div>

    <script>
        function kamarPage() {
            return {
                showAdd: false,
                showEdit: false,
                showDetail: false,
                confirmDelete: false,
                selected: null,

                openAdd() {
                    this.showAdd = true;
                },
                openDetail(kamar) {
                    this.selected = kamar;
                    this.showDetail = true;
                },
                openEdit(kamar) {
                    this.selected = { ...kamar };
                    this.showEdit = true;
                },
                formatRupiah(value) {
                    if (value === null || value === undefined) return '-';
                    return 'Rp' + Number(value).toLocaleString('id-ID');
                },
                statusLabel(status) {
                    return { kosong: 'Kosong', terisi: 'Terisi', booking: 'Booking' }[status] ?? status;
                },
                statusBadgeClass(status) {
                    return {
                        kosong: 'bg-gray-100 text-gray-600',
                        terisi: 'bg-green-100 text-green-700',
                        booking: 'bg-yellow-100 text-yellow-700',
                    }[status] ?? 'bg-gray-100 text-gray-600';
                },
                statusDotClass(status) {
                    return {
                        kosong: 'bg-gray-400',
                        terisi: 'bg-green-500',
                        booking: 'bg-yellow-500',
                    }[status] ?? 'bg-gray-400';
                },
            };
        }
    </script>

</body>
</html>
