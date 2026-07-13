<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-primary text-xl">
            Data Kamar
        </h2>
    </x-slot>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div x-data="kamarPage()" class="space-y-6 mx-auto px-6 pt-2 pb-8 max-w-7xl">

        {{-- ===================== NOTIFIKASI TOAST MELAYANG ===================== --}}
        @if (session('success'))
            <div class="top-5 right-5 z-50 fixed w-full max-w-sm pointer-events-none">
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-cloak
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="flex items-start gap-3 bg-white shadow-xl p-4 border-emerald-500 border-l-4 rounded-xl pointer-events-auto">
                    <div class="text-emerald-500 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900 text-sm">Berhasil!</p>
                        <p class="mt-0.5 text-gray-500 text-xs">{{ session('success') }}</p>
                    </div>
                    <button type="button" @click="show = false" class="text-gray-400 hover:text-gray-600 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/xl" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- Search & Filter --}}
        <form method="GET" action="{{ route('kamar.index') }}" x-ref="searchForm"
            class="flex sm:flex-row flex-col sm:items-end gap-3 sm:gap-4">
            <div class="flex-1">
                <div class="relative">
                    <span class="left-0 absolute inset-y-0 flex items-center pl-3 text-grayCustom-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m1.1-5.4a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" />
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari Kamar"
                        autocomplete="off" @input.debounce.400ms="$refs.searchForm.requestSubmit()"
                        class="bg-white shadow-sm py-2.5 pr-4 pl-9 border border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full sm:max-w-xs text-grayCustom-700 text-sm placeholder-grayCustom-400">
                </div>
            </div>

            <div>
                <label class="block mb-1 text-grayCustom-500 text-xs">Status</label>
                <select name="status" onchange="this.form.requestSubmit()"
                    class="bg-white shadow-sm border border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full sm:w-44 text-grayCustom-700 text-sm">
                    <option value="" {{ $statusFilter === '' ? 'selected' : '' }}>Select...</option>
                    <option value="kosong" {{ $statusFilter === 'kosong' ? 'selected' : '' }}>Kosong</option>
                    <option value="terisi" {{ $statusFilter === 'terisi' ? 'selected' : '' }}>Terisi</option>
                    <option value="booking" {{ $statusFilter === 'booking' ? 'selected' : '' }}>Booking</option>
                </select>
            </div>

            @can('kamar.create')
                <div class="sm:ml-auto">
                    <button type="button" @click="openAdd()"
                        class="inline-flex justify-center items-center gap-2 bg-primary hover:bg-primary/90 px-4 py-2.5 rounded-xl w-full sm:w-auto font-semibold text-white text-sm transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Kamar
                    </button>
                </div>
            @endcan
        </form>

        {{-- Table Container --}}
        <div class="bg-white shadow-lg p-4 sm:p-6 rounded-2xl overflow-hidden">
            @if ($kamars->isEmpty())
                <p class="py-10 text-grayCustom-400 text-sm text-center">Tidak ada data kamar yang cocok.</p>
            @else
                {{-- Desktop / tablet table --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-grayCustom-100 border-b text-primary/70 text-xs text-left uppercase tracking-wide">
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
                                <tr class="hover:bg-grayCustom-50 border-grayCustom-5 border-b last:border-b-0 transition">
                                    {{-- Penomoran dinamis agar berlanjut otomatis di page berikutnya --}}
                                    <td class="py-4 pr-4 text-grayCustom-500">{{ $kamars->firstItem() + $index }}</td>
                                    <td class="py-4 pr-4 font-medium text-grayCustom-700 whitespace-nowrap">
                                        {{ $kamar->no_kamar }}</td>
                                    <td class="py-4 pr-4 text-grayCustom-500 whitespace-nowrap">{{ $kamar->tipe }}</td>
                                    <td class="py-4 pr-4 text-grayCustom-500 whitespace-nowrap">
                                        {{ $kamar->hargaFormatted() }}</td>
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
                                                class="hover:bg-grayCustom-100 p-1.5 rounded-lg text-grayCustom-400 hover:text-primary transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </button>
                                            @can('kamar.edit')
                                                <button type="button" title="Edit kamar"
                                                    @click="openEdit({{ Illuminate\Support\Js::from($kamar) }})"
                                                    class="hover:bg-grayCustom-100 p-1.5 rounded-lg text-grayCustom-400 hover:text-primary transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                                                    </svg>
                                                </button>
                                            @endcan
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
                        <div class="bg-white shadow-sm p-4 border border-grayCustom-100 rounded-xl">
                            <div class="flex justify-between items-start gap-3">
                                <div>
                                    <p class="font-semibold text-grayCustom-800">{{ $kamar->no_kamar }}</p>
                                    <p class="mt-0.5 text-grayCustom-400 text-xs">{{ $kamar->tipe }} &middot;
                                        {{ $kamar->hargaFormatted() }}</p>
                                </div>
                                <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $kamar->statusBadgeClass() }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $kamar->statusDotClass() }}"></span>
                                    {{ $kamar->statusLabel() }}
                                </span>
                            </div>

                            <div class="flex justify-end items-center gap-2 mt-3">
                                <button type="button" title="Lihat detail"
                                    @click="openDetail({{ Illuminate\Support\Js::from($kamar) }})"
                                    class="hover:bg-grayCustom-100 p-1.5 rounded-lg text-grayCustom-400 hover:text-primary transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                                @can('kamar.edit')
                                    <button type="button" title="Edit kamar"
                                        @click="openEdit({{ Illuminate\Support\Js::from($kamar) }})"
                                        class="hover:bg-grayCustom-100 p-1.5 rounded-lg text-grayCustom-400 hover:text-primary transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                                        </svg>
                                    </button>
                                @endcan
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- ===================== RENDER PAGINATION MINIMALIS ===================== --}}
                @if ($kamars->hasPages())
                    <div class="flex justify-end items-center gap-2 mt-4 pt-4 border-grayCustom-100 border-t text-xs">
                        @if (!$kamars->onFirstPage())
                            <a href="{{ $kamars->appends(request()->query())->previousPageUrl() }}"
                               class="hover:bg-gray-100 px-2 py-1 border border-grayCustom-200 rounded text-grayCustom-600 transition">
                                ←
                            </a>
                        @endif

                        <span class="font-medium text-grayCustom-600">{{ $kamars->currentPage() }}/{{ $kamars->lastPage() }}</span>

                        @if ($kamars->hasMorePages())
                            <a href="{{ $kamars->appends(request()->query())->nextPageUrl() }}"
                               class="hover:bg-gray-100 px-2 py-1 border border-grayCustom-200 rounded text-grayCustom-600 transition">
                                →
                            </a>
                        @endif
                    </div>
                @endif
            @endif
        </div>

       {{-- ===================== MODAL: DETAIL ===================== --}}
        <div x-show="showDetail" x-cloak class="z-40 fixed inset-0 flex justify-center items-center bg-black/40 p-4"
            @click.self="showDetail = false">
            <div x-show="showDetail" x-transition class="bg-white shadow-xl p-6 rounded-2xl w-full max-w-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-primary text-lg">Detail Kamar</h3>
                    <button type="button" @click="showDetail = false"
                        class="text-grayCustom-400 hover:text-grayCustom-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <template x-if="selected">
                    <div>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <dt class="text-grayCustom-400">No. Kamar</dt>
                                <dd class="font-semibold text-grayCustom-800" x-text="selected.no_kamar"></dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-grayCustom-400">Tipe</dt>
                                <dd class="font-semibold text-grayCustom-800" x-text="selected.tipe"></dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-grayCustom-400">Harga / Bulan</dt>
                                <dd class="font-semibold text-grayCustom-800" x-text="formatRupiah(selected.harga)"></dd>
                            </div>
                            <div class="flex justify-between items-center">
                                <dt class="text-grayCustom-400">Status</dt>
                                <dd>
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full font-semibold text-xs"
                                        :class="statusBadgeClass(selected.status)">
                                        <span class="rounded-full w-1.5 h-1.5"
                                            :class="statusDotClass(selected.status)"></span>
                                        <span x-text="statusLabel(selected.status)"></span>
                                    </span>
                                </dd>
                            </div>
                        </dl>

                        {{-- ============ TAMBAHAN: Pengajuan Booking ============ --}}
                        <template x-if="selected.pendingBooking">
                            <div class="mt-5 pt-4 border-grayCustom-100 border-t">
                                <h4 class="mb-2 font-semibold text-grayCustom-700 text-sm">Pengajuan Booking</h4>

                                <dl class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-grayCustom-400">Nama Penghuni</dt>
                                        <dd class="font-medium text-grayCustom-800"
                                            x-text="selected.pendingBooking.user.name"></dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-grayCustom-400">Durasi Sewa</dt>
                                        <dd class="font-medium text-grayCustom-800"
                                            x-text="selected.pendingBooking.durasi + ' Bulan'"></dd>
                                    </div>
                                    <div class="flex justify-between gap-4">
                                        <dt class="shrink-0 text-grayCustom-400">Catatan</dt>
                                        <dd class="font-medium text-grayCustom-800 text-right"
                                            x-text="selected.pendingBooking.catatan || '-'"></dd>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <dt class="text-grayCustom-400">Status Booking</dt>
                                        <dd>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full font-semibold text-warning-700 text-xs bg-warning-100">
                                                Menunggu
                                            </span>
                                        </dd>
                                    </div>
                                </dl>

                                @can('kamar.edit')
                                    <div class="flex gap-2 mt-4">
                                        <form method="POST"
                                            :action="'/booking/' + selected.pendingBooking.id + '/approve'"
                                            onsubmit="return confirm('Setujui booking ini?')" class="flex-1">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="bg-success-600 hover:bg-success-700 py-2 rounded-xl w-full font-semibold text-white text-sm transition">
                                                Setujui
                                            </button>
                                        </form>

                                        <form method="POST"
                                            :action="'/booking/' + selected.pendingBooking.id + '/reject'"
                                            onsubmit="return confirm('Tolak booking ini?')" class="flex-1">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 py-2 rounded-xl w-full font-semibold text-white text-sm transition">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                @endcan
                            </div>
                        </template>
                        {{-- ============ AKHIR TAMBAHAN ============ --}}
                    </div>
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-grayCustom-400">No. Kamar</dt>
                            <dd class="font-semibold text-grayCustom-800" x-text="selected.no_kamar"></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-grayCustom-400">Tipe</dt>
                            <dd class="font-semibold text-grayCustom-800" x-text="selected.tipe"></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-grayCustom-400">Harga / Bulan</dt>
                            <dd class="font-semibold text-grayCustom-800" x-text="formatRupiah(selected.harga)"></dd>
                        </div>
                        <div class="flex justify-between items-center">
                            <dt class="text-grayCustom-400">Status</dt>
                            <dd>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full font-semibold text-xs"
                                    :class="statusBadgeClass(selected.status)">
                                    <span class="rounded-full w-1.5 h-1.5"
                                        :class="statusDotClass(selected.status)"></span>
                                    <span x-text="statusLabel(selected.status)"></span>
                                </span>
                            </dd>
                        </div>
                    </dl>
                </template>

                <div class="flex justify-end mt-6">
                    <button type="button" @click="showDetail = false"
                        class="hover:bg-grayCustom-100 px-4 py-2 rounded-xl font-semibold text-grayCustom-500 text-sm transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        {{-- ===================== MODAL: TAMBAH ===================== --}}
        @can('kamar.create')
            <div x-show="showAdd" x-cloak class="z-40 fixed inset-0 flex justify-center items-center bg-black/40 p-4"
                @click.self="showAdd = false">
                <div x-show="showAdd" x-transition class="bg-white shadow-xl p-6 rounded-2xl w-full max-w-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-primary text-lg">Tambah Kamar</h3>
                        <button type="button" @click="showAdd = false"
                            class="text-grayCustom-400 hover:text-grayCustom-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('kamar.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block mb-1 font-medium text-grayCustom-500 text-xs">No. Kamar</label>
                            <input type="text" name="no_kamar" required placeholder="Contoh: A011"
                                class="shadow-sm border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full text-sm">
                            @error('no_kamar')
                                <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1 font-medium text-grayCustom-500 text-xs">Tipe</label>
                            <input type="text" name="tipe" required placeholder="Standar / Deluxe"
                                list="tipe-options"
                                class="shadow-sm border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full text-sm">
                            <datalist id="tipe-options">
                                <option value="Standar"></option>
                                <option value="Deluxe"></option>
                            </datalist>
                            @error('tipe')
                                <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1 font-medium text-grayCustom-500 text-xs">Harga / Bulan (Rp)</label>
                            <input type="number" name="harga" min="0" step="1000" required
                                placeholder="1000000"
                                class="shadow-sm border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full text-sm">
                            @error('harga')
                                <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block mb-1 font-medium text-grayCustom-500 text-xs">Status</label>
                            <select name="status" required
                                class="shadow-sm border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full text-sm">
                                <option value="kosong">Kosong</option>
                                <option value="terisi">Terisi</option>
                                <option value="booking">Booking</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-red-500 text-xs">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="showAdd = false"
                                class="hover:bg-grayCustom-100 px-4 py-2 rounded-xl font-semibold text-grayCustom-500 text-sm transition">
                                Batal
                            </button>
                            <button type="submit"
                                class="bg-primary hover:bg-primary/90 px-4 py-2 rounded-xl font-semibold text-white text-sm transition">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endcan

        {{-- ===================== MODAL: EDIT ===================== --}}
        @can('kamar.edit')
            <div x-show="showEdit" x-cloak class="z-40 fixed inset-0 flex justify-center items-center bg-black/40 p-4"
                @click.self="showEdit = false">
                <div x-show="showEdit" x-transition class="bg-white shadow-xl p-6 rounded-2xl w-full max-w-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-primary text-lg">Edit Kamar</h3>
                        <button type="button" @click="showEdit = false"
                            class="text-grayCustom-400 hover:text-grayCustom-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <template x-if="selected">
                        <form method="POST" :action="'/kamar/' + selected.id" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="block mb-1 font-medium text-grayCustom-500 text-xs">No. Kamar</label>
                                <input type="text" name="no_kamar" x-model="selected.no_kamar" required
                                    class="shadow-sm border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full text-sm">
                            </div>

                            <div>
                                <label class="block mb-1 font-medium text-grayCustom-500 text-xs">Tipe</label>
                                <input type="text" name="tipe" x-model="selected.tipe" required
                                    list="tipe-options-edit"
                                    class="shadow-sm border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full text-sm">
                                <datalist id="tipe-options-edit">
                                    <option value="Standar"></option>
                                    <option value="Deluxe"></option>
                                </datalist>
                            </div>

                            <div>
                                <label class="block mb-1 font-medium text-grayCustom-500 text-xs">Harga / Bulan (Rp)</label>
                                <input type="number" name="harga" x-model="selected.harga" min="0"
                                    step="1000" required
                                    class="shadow-sm border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full text-sm">
                            </div>

                            <div>
                                <label class="block mb-1 font-medium text-grayCustom-500 text-xs">Status</label>
                                <select name="status" x-model="selected.status" required
                                    class="shadow-sm border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full text-sm">
                                    <option value="kosong">Kosong</option>
                                    <option value="terisi">Terisi</option>
                                    <option value="booking">Booking</option>
                                </select>
                            </div>

                            <div class="flex justify-between items-center pt-2">
                                @can('kamar.delete')
                                    <button type="button" @click="confirmDelete = true"
                                        class="hover:bg-red-50 px-3 py-2 rounded-xl font-semibold text-red-600 text-xs transition">
                                        Hapus Kamar
                                    </button>
                                @else
                                    <div></div>
                                @endcan

                                <div class="flex gap-2">
                                    <button type="button" @click="showEdit = false"
                                        class="hover:bg-grayCustom-100 px-4 py-2 rounded-xl font-semibold text-grayCustom-500 text-sm transition">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="bg-primary hover:bg-primary/90 px-4 py-2 rounded-xl font-semibold text-white text-sm transition">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </template>
                </div>
            </div>
        @endcan

        {{-- ===================== MODAL: KONFIRMASI HAPUS ===================== --}}
        @can('kamar.delete')
            <div x-show="confirmDelete" x-cloak
                class="z-50 fixed inset-0 flex justify-center items-center bg-black/50 p-4"
                @click.self="confirmDelete = false">
                <div x-show="confirmDelete" x-transition
                    class="bg-white shadow-xl p-6 rounded-2xl w-full max-w-xs text-center">
                    <h3 class="mb-3 font-bold text-red-600 text-lg">
                        Hapus Kamar
                    </h3>

                    <p class="text-grayCustom-700 text-sm">
                        Yakin ingin menghapus kamar
                        <span class="font-semibold text-grayCustom-900"
                            x-text="selected ? selected.no_kamar : '-'"></span>?
                    </p>

                    <form method="POST" :action="selected ? '/kamar/' + selected.id : '#'"
                        class="flex justify-center gap-3 mt-6">
                        @csrf
                        @method('DELETE')

                        <button type="button" @click="confirmDelete = false"
                            class="hover:bg-grayCustom-100 px-4 py-2 rounded-xl font-semibold text-grayCustom-500 text-sm transition">
                            Batal
                        </button>

                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 shadow-sm px-4 py-2 rounded-xl font-semibold text-white text-sm transition">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        @endcan
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
                    this.selected = {
                        ...kamar
                    };
                    this.showEdit = true;
                },
                formatRupiah(value) {
                    if (value === null || value === undefined) return '-';
                    return 'Rp' + Number(value).toLocaleString('id-ID');
                },
                statusLabel(status) {
                    return {
                        kosong: 'Kosong',
                        terisi: 'Terisi',
                        booking: 'Booking'
                    } [status] ?? status;
                },
                statusBadgeClass(status) {
                    return {
                        kosong: 'bg-grayCustom-100 text-grayCustom-600',
                        terisi: 'bg-success-100 text-success-700',
                        booking: 'bg-warning-100 text-warning-700',
                    } [status] ?? 'bg-grayCustom-100 text-grayCustom-600';
                },
                statusDotClass(status) {
                    return {
                        kosong: 'bg-grayCustom-400',
                        terisi: 'bg-success-500',
                        booking: 'bg-warning-500',
                    } [status] ?? 'bg-grayCustom-400';
                },
            };
        }
    </script>

</x-app-layout>
