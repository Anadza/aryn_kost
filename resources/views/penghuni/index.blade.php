<x-app-layout>
    @php
        $routePrefix = auth()->user()->hasRole('owner') ? 'owner' : 'admin';
    @endphp

    <x-slot name="header">
        <h2 class="font-bold text-primary text-xl">
            Data Penghuni
        </h2>
    </x-slot>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div x-data="penghuniPage()" class="space-y-6 mx-auto -mt-4 px-6 pb-8 max-w-7xl">

        {{-- ===================== NOTIFIKASI TOAST MELAYANG ===================== --}}
        <div class="top-5 right-5 z-50 fixed space-y-3 w-full max-w-sm pointer-events-none">
            {{-- Toast Sukses (Simpan / Edit) --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-cloak
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="flex items-start gap-3 bg-white shadow-xl p-4 border-emerald-500 border-l-4 rounded-xl pointer-events-auto">
                    <div class="text-emerald-500 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900 text-sm">Berhasil!</p>
                        <p class="mt-0.5 text-gray-500 text-xs">{{ session('success') }}</p>
                    </div>
                    <button type="button" @click="show = false" class="text-gray-400 hover:text-gray-600 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Toast Terhapus (Delete) --}}
            @if (session('success_delete'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-cloak
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="flex items-start gap-3 bg-white shadow-xl p-4 border-red-500 border-l-4 rounded-xl pointer-events-auto">
                    <div class="text-red-500 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900 text-sm">Data Dihapus</p>
                        <p class="mt-0.5 text-gray-500 text-xs">{{ session('success_delete') }}</p>
                    </div>
                    <button type="button" @click="show = false" class="text-gray-400 hover:text-gray-600 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif
        </div>

        {{-- Search & Filter --}}
        <form method="GET" action="{{ route($routePrefix . '.penghuni.index') }}"
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
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Penghuni..."
                        autocomplete="off" @input.debounce.400ms="this.form.submit()"
                        class="bg-white shadow-sm py-2.5 pr-4 pl-9 border border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full sm:max-w-xs text-grayCustom-700 text-sm placeholder-grayCustom-400">
                </div>
            </div>

            <div>
                <label class="block mb-1 text-grayCustom-500 text-xs">Status</label>
                <select name="status" onchange="this.form.submit()"
                    class="bg-white shadow-sm border border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full sm:w-44 text-grayCustom-700 text-sm">
                    <option value=""
                        {{ request('status') === null || request('status') === '' ? 'selected' : '' }}>Semua Status
                    </option>
                    <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            @can('penghuni.create')
                <div class="sm:ml-auto">
                    <button type="button" @click="openAdd()"
                        class="inline-flex justify-center items-center gap-2 bg-primary hover:bg-primary/90 px-4 py-2.5 rounded-xl w-full sm:w-auto font-semibold text-white text-sm transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Penghuni
                    </button>
                </div>
            @endcan
        </form>

        {{-- Table Container --}}
        <div class="bg-white shadow-lg p-4 sm:p-6 rounded-2xl overflow-hidden">
            @if ($penghunis->isEmpty())
                <p class="py-10 text-grayCustom-400 text-sm text-center">Tidak ada data penghuni yang cocok.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr
                                class="border-grayCustom-100 border-b text-primary/70 text-xs text-left uppercase tracking-wide">
                                <th class="py-3 pr-4 font-medium">No</th>
                                <th class="py-3 pr-4 font-medium">Nama Penghuni</th>
                                <th class="py-3 pr-4 font-medium text-center">Nomor Kamar</th>
                                <th class="py-3 pr-4 font-medium text-center">No HP</th>
                                <th class="py-3 pr-4 font-medium text-center">Check In</th>
                                <th class="py-3 pr-4 font-medium text-center">Status</th>
                                <th class="py-3 pr-0 font-medium text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penghunis as $index => $penghuni)
                                <tr
                                    class="hover:bg-grayCustom-50 border-grayCustom-5 border-b last:border-b-0 transition">
                                    <td class="py-4 pr-4 text-grayCustom-500">{{ $penghunis->firstItem() + $index }}
                                    </td>
                                    <td class="py-4 pr-4 font-medium text-grayCustom-700 whitespace-nowrap">
                                        {{ $penghuni->nama }}</td>
                                    <td class="py-4 pr-4 text-grayCustom-500 text-center whitespace-nowrap">
                                        {{ $penghuni->nomor_kamar }}</td>
                                    <td class="py-4 pr-4 text-grayCustom-500 text-center whitespace-nowrap">
                                        {{ $penghuni->no_hp }}</td>
                                    <td class="py-4 pr-4 text-grayCustom-500 text-center whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($penghuni->check_in)->format('d M Y') }}
                                    </td>
                                    <td class="py-4 pr-4 text-center whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full font-semibold text-xs"
                                            :class="statusBadgeClass('{{ $penghuni->status }}')">
                                            <span class="rounded-full w-1.5 h-1.5"
                                                :class="statusDotClass('{{ $penghuni->status }}')"></span>
                                            {{ $penghuni->status }}
                                        </span>
                                    </td>
                                    <td class="py-4 pr-0">
                                        <div class="flex justify-center items-center gap-2">
                                            <button type="button" title="Lihat detail"
                                                @click="openDetail({{ Illuminate\Support\Js::from($penghuni) }})"
                                                class="hover:bg-grayCustom-100 p-1.5 rounded-lg text-grayCustom-400 hover:text-primary transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </button>
                                            @can('penghuni.edit')
                                                <button type="button" title="Edit"
                                                    @click="openEdit({{ Illuminate\Support\Js::from($penghuni) }})"
                                                    class="hover:bg-grayCustom-100 p-1.5 rounded-lg text-grayCustom-400 hover:text-primary transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
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

                {{-- ===================== PAGINATION MINIMALIS MODERN (SAMA SEPERTI KAMAR) ===================== --}}
                @if ($penghunis->hasPages())
                    <div class="flex justify-end items-center gap-2 mt-4 pt-4 border-gray-200 border-t text-xs">
                        @if (!$penghunis->onFirstPage())
                            <a href="{{ $penghunis->appends(request()->query())->previousPageUrl() }}"
                                class="hover:bg-gray-100 px-2 py-1 border border-gray-300 rounded font-semibold text-gray-700 transition">
                                ←
                            </a>
                        @endif

                        <span class="bg-gray-50 px-2.5 py-1 border border-gray-200 rounded font-medium text-gray-700">
                            {{ $penghunis->currentPage() }}/{{ $penghunis->lastPage() }}
                        </span>

                        @if ($penghunis->hasMorePages())
                            <a href="{{ $penghunis->appends(request()->query())->nextPageUrl() }}"
                                class="hover:bg-gray-100 px-2 py-1 border border-gray-300 rounded font-semibold text-gray-700 transition">
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
                    <h3 class="font-bold text-primary text-lg">Detail Penghuni</h3>
                    <button type="button" @click="showDetail = false"
                        class="text-grayCustom-400 hover:text-grayCustom-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <template x-if="selected">
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-grayCustom-400">Nama Penghuni</dt>
                            <dd class="font-semibold text-grayCustom-800" x-text="selected.nama"></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-grayCustom-400">Nomor Kamar</dt>
                            <dd class="font-semibold text-grayCustom-800" x-text="selected.nomor_kamar"></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-grayCustom-400">No HP</dt>
                            <dd class="font-semibold text-grayCustom-800" x-text="selected.no_hp"></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-grayCustom-400">Check In</dt>
                            <dd class="font-semibold text-grayCustom-800" x-text="formatDate(selected.check_in)"></dd>
                        </div>
                        <div class="flex justify-between items-center">
                            <dt class="text-grayCustom-400">Status</dt>
                            <dd>
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full font-semibold text-xs"
                                    :class="statusBadgeClass(selected.status)">
                                    <span class="rounded-full w-1.5 h-1.5"
                                        :class="statusDotClass(selected.status)"></span>
                                    <span x-text="selected.status"></span>
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
        @can('penghuni.create')
            <div x-show="showAdd" x-cloak class="z-40 fixed inset-0 flex justify-center items-center bg-black/40 p-4"
                @click.self="showAdd = false">
                <div x-show="showAdd" x-transition class="bg-white shadow-xl p-6 rounded-2xl w-full max-w-md">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-primary text-lg">Tambah Data Penghuni</h3>
                        <button type="button" @click="showAdd = false"
                            class="text-grayCustom-400 hover:text-grayCustom-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route($routePrefix . '.penghuni.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block mb-1 font-medium text-grayCustom-500 text-xs">Nama</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required
                                placeholder="Masukkan nama penghuni"
                                class="shadow-sm border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full text-sm">
                        </div>
                        <div class="gap-4 grid grid-cols-2">
                            <div>
                                <label class="block mb-1 font-medium text-grayCustom-500 text-xs">Nomor Kamar</label>
                                <input type="text" name="nomor_kamar" value="{{ old('nomor_kamar') }}" required
                                    placeholder="Contoh : A01"
                                    class="shadow-sm border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full text-sm">
                            </div>
                            <div>
                                <label class="block mb-1 font-medium text-grayCustom-500 text-xs">No HP</label>
                                <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
                                    placeholder="08xxxxxxxxxx"
                                    class="shadow-sm border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full text-sm">
                            </div>
                        </div>
                        <div class="gap-4 grid grid-cols-2">
                            <div>
                                <label class="block mb-1 font-medium text-grayCustom-500 text-xs">Check In</label>
                                <input type="date" name="check_in" value="{{ old('check_in') }}" required
                                    class="shadow-sm border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full text-sm">
                            </div>
                            <div>
                                <label class="block mb-1 font-medium text-grayCustom-500 text-xs">Status</label>
                                <select name="status" required
                                    class="shadow-sm border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full text-sm">
                                    <option value="">Pilih Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <button type="button" @click="showAdd = false"
                                class="hover:bg-grayCustom-100 px-4 py-2 rounded-xl font-semibold text-grayCustom-500 text-sm transition">Batal</button>
                            <button type="submit"
                                class="bg-primary hover:bg-primary/90 px-4 py-2 rounded-xl font-semibold text-white text-sm transition">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        @endcan

        {{-- ===================== MODAL: EDIT & HAPUS ===================== --}}
        @can('penghuni.edit')
            <div x-show="showEdit" x-cloak class="z-40 fixed inset-0 flex justify-center items-center bg-black/40 p-4"
                @click.self="showEdit = false">
                <div x-show="showEdit" x-transition class="bg-white shadow-xl p-6 rounded-2xl w-full max-w-md">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-primary text-lg">Edit Data Penghuni</h3>
                        <button type="button" @click="showEdit = false"
                            class="text-grayCustom-400 hover:text-grayCustom-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <template x-if="selected">
                        <form method="POST" id="formEditPenghuni" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block mb-1 font-medium text-grayCustom-500 text-xs">Nama</label>
                                <input type="text" name="nama" x-model="selected.nama" required
                                    class="shadow-sm border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full text-sm">
                            </div>
                            <div class="gap-4 grid grid-cols-2">
                                <div>
                                    <label class="block mb-1 font-medium text-grayCustom-500 text-xs">Nomor Kamar</label>
                                    <input type="text" name="nomor_kamar" x-model="selected.nomor_kamar" required
                                        class="shadow-sm border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full text-sm">
                                </div>
                                <div>
                                    <label class="block mb-1 font-medium text-grayCustom-500 text-xs">No HP</label>
                                    <input type="text" name="no_hp" x-model="selected.no_hp" required
                                        class="shadow-sm border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full text-sm">
                                </div>
                            </div>
                            <div class="gap-4 grid grid-cols-2">
                                <div>
                                    <label class="block mb-1 font-medium text-grayCustom-500 text-xs">Check In</label>
                                    <input type="date" name="check_in" x-model="selected.check_in" required
                                        class="shadow-sm border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full text-sm">
                                </div>
                                <div>
                                    <label class="block mb-1 font-medium text-grayCustom-500 text-xs">Status</label>
                                    <select name="status" x-model="selected.status" required
                                        class="shadow-sm border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full text-sm">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                @can('penghuni.delete')
                                    <button type="button" @click="openDelete(selected)"
                                        class="hover:bg-red-50 px-3 py-2 rounded-xl font-semibold text-red-600 text-xs transition">
                                        Hapus Penghuni
                                    </button>
                                @else
                                    <div></div>
                                @endcan

                                <div class="flex gap-2">
                                    <button type="button" @click="showEdit = false"
                                        class="hover:bg-grayCustom-100 px-4 py-2 rounded-xl font-semibold text-grayCustom-500 text-sm transition">Batal</button>
                                    <button type="submit"
                                        class="bg-primary hover:bg-primary/90 px-4 py-2 rounded-xl font-semibold text-white text-sm transition">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </template>
                </div>
            </div>
        @endcan

        {{-- ===================== MODAL: KONFIRMASI HAPUS ===================== --}}
        @can('penghuni.delete')
            <div x-show="confirmDelete" x-cloak
                class="z-50 fixed inset-0 flex justify-center items-center bg-black/50 p-4"
                @click.self="confirmDelete = false">
                <div x-show="confirmDelete" x-transition
                    class="bg-white shadow-xl p-6 rounded-2xl w-full max-w-xs text-center">
                    <h3 class="mb-3 font-bold text-red-600 text-lg">Hapus Penghuni</h3>
                    <p class="text-grayCustom-700 text-sm">
                        Yakin ingin menghapus data penghuni
                        <span class="font-semibold text-grayCustom-900" x-text="selected ? selected.nama : '-'"></span>?
                    </p>

                    <form method="POST" id="formDeletePenghuni" class="flex justify-center gap-3 mt-6">
                        @csrf
                        @method('DELETE')
                        <button type="button" @click="confirmDelete = false"
                            class="hover:bg-grayCustom-100 px-4 py-2 rounded-xl font-semibold text-grayCustom-500 text-sm transition">Batal</button>
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 shadow-sm px-4 py-2 rounded-xl font-semibold text-white text-sm transition">Ya,
                            Hapus</button>
                    </form>
                </div>
            </div>
        @endcan
    </div>

    {{-- ========================= JAVASCRIPT STATE (ALPINE.JS) ========================= --}}
    <script>
        function penghuniPage() {
            return {
                showAdd: false,
                showEdit: false,
                showDetail: false,
                confirmDelete: false,
                selected: null,

                openAdd() {
                    this.showAdd = true;
                },
                openDetail(data) {
                    this.selected = data;
                    this.showDetail = true;
                },
                openEdit(data) {
                    this.selected = {
                        ...data
                    };
                    this.showEdit = true;

                    this.$nextTick(() => {
                        const editForm = document.getElementById('formEditPenghuni');
                        if (editForm) {
                            editForm.action = window.location.origin +
                                `/${@json($routePrefix)}/penghuni/${data.id}`;
                        }
                    });
                },
                openDelete(data) {
                    this.selected = data;
                    this.showEdit = false;
                    this.confirmDelete = true;

                    this.$nextTick(() => {
                        const deleteForm = document.getElementById('formDeletePenghuni');
                        if (deleteForm) {
                            deleteForm.action = window.location.origin +
                                `/${@json($routePrefix)}/penghuni/${data.id}`;
                        }
                    });
                },
                formatDate(value) {
                    if (!value) return '-';
                    const date = new Date(value);
                    return date.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });
                },
                statusBadgeClass(status) {
                    return status === 'Active' ?
                        'bg-success-100 text-success-700' :
                        'bg-grayCustom-100 text-grayCustom-600';
                },
                statusDotClass(status) {
                    return status === 'Active' ? 'bg-success-500' : 'bg-grayCustom-400';
                }
            };
        }
    </script>
</x-app-layout>
