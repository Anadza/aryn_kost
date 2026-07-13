@php
    $roleForRoute = auth()->user()->hasRole('admin') ? 'admin' : 'owner';
    $indexRouteName = "{$roleForRoute}.pembayaran.index";
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-primary text-xl">Data Pembayaran</h2>
    </x-slot>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div x-data="pembayaranPage()" class="space-y-6 mx-auto px-6 pt-2 pb-8 max-w-7xl">

        {{-- Notifikasi --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-cloak
                class="top-5 right-5 z-50 fixed bg-white shadow-xl p-4 border-emerald-500 border-l-4 rounded-xl w-full max-w-sm pointer-events-none">
                <div class="flex items-start gap-3 pointer-events-auto">
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
                </div>
            </div>
        @endif

        {{-- Filter --}}
        <form method="GET" action="{{ route($indexRouteName) }}" x-ref="searchForm"
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
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..."
                        @input.debounce.400ms="$refs.searchForm.requestSubmit()"
                        class="bg-white shadow-sm py-2.5 pr-4 pl-9 border border-grayCustom-200 focus:border-primary rounded-xl w-full sm:max-w-xs text-sm">
                </div>
            </div>
            <div>
                <select name="status" onchange="this.form.requestSubmit()"
                    class="bg-white shadow-sm border border-grayCustom-200 rounded-xl w-full sm:w-52 text-sm">
                    <option value="">Semua Status</option>
                    <option value="Belum Dibayar" {{ request('status') == 'Belum Dibayar' ? 'selected' : '' }}>Belum
                        Dibayar</option>
                    <option value="Menunggu Konfirmasi"
                        {{ request('status') == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                    <option value="Lunas" {{ request('status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>
        </form>

        {{-- Tabel Container --}}
        <div class="bg-white shadow-lg p-4 sm:p-6 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-grayCustom-100 border-b text-primary/70 text-xs text-left uppercase">
                            <th class="px-2 py-3">No</th>
                            <th class="px-2 py-3">Nomor Tagihan</th>
                            <th class="px-2 py-3">Bulan</th>
                            <th class="px-2 py-3">Jumlah</th>
                            <th class="px-2 py-3">Status</th>
                            <th class="px-2 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembayarans as $index => $pembayaran)
                            <tr class="hover:bg-grayCustom-5 border-grayCustom-5 border-b transition">
                                <td class="px-2 py-4 text-grayCustom-500">{{ $pembayarans->firstItem() + $index }}</td>
                                <td class="px-2 py-4 font-medium">{{ $pembayaran->nomor_tagihan }}</td>
                                <td class="px-2 py-4">{{ $pembayaran->bulan_tagihan }}</td>
                                <td class="px-2 py-4">{{ $pembayaran->jumlahTagihanFormatted() }}</td>
                                <td class="px-2 py-4">
                                    <span
                                        class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
                                        {{ $pembayaran->status_pembayaran === 'Lunas'
                                            ? 'bg-success-100 text-success-700'
                                            : ($pembayaran->status_pembayaran === 'Menunggu Konfirmasi'
                                                ? 'bg-warning-100 text-warning-700'
                                                : 'bg-red-100 text-red-700') }}">
                                        {{ $pembayaran->status_pembayaran }}
                                    </span>
                                </td>
                                <td class="px-2 py-4 text-center">
                                    <div class="flex justify-center items-center gap-2">
                                        {{-- Tombol Lihat (Ikon Mata) --}}
                                        <button type="button" title="Lihat detail & Bukti"
                                            @click="openDetail({{ Illuminate\Support\Js::from($pembayaran) }}, false)"
                                            class="hover:bg-grayCustom-100 p-1.5 rounded-lg text-grayCustom-400 hover:text-primary transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>

                                        {{-- Tombol Edit (Ikon Pensil) - Hanya Admin --}}
                                        @role('admin')
                                            <button type="button" title="Edit status"
                                                @click="openDetail({{ Illuminate\Support\Js::from($pembayaran) }}, true)"
                                                class="hover:bg-grayCustom-100 p-1.5 rounded-lg text-grayCustom-400 hover:text-primary transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                                                </svg>
                                            </button>
                                        @endrole
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($pembayarans->hasPages())
                <div class="flex justify-end items-center gap-2 mt-4 pt-4 border-grayCustom-100 border-t text-xs">
                    @if (!$pembayarans->onFirstPage())
                        <a href="{{ $pembayarans->appends(request()->query())->previousPageUrl() }}"
                            class="hover:bg-gray-100 px-2 py-1 border border-grayCustom-200 rounded text-grayCustom-600 transition">←</a>
                    @endif
                    <span
                        class="font-medium text-grayCustom-600">{{ $pembayarans->currentPage() }}/{{ $pembayarans->lastPage() }}</span>
                    @if ($pembayarans->hasMorePages())
                        <a href="{{ $pembayarans->appends(request()->query())->nextPageUrl() }}"
                            class="hover:bg-gray-100 px-2 py-1 border border-grayCustom-200 rounded text-grayCustom-600 transition">→</a>
                    @endif
                </div>
            @endif
        </div>

        {{-- Detail & Bukti Pembayaran --}}
        <div x-show="showDetail" x-cloak class="z-50 fixed inset-0 flex justify-center items-center bg-black/40 p-4"
            @click.self="showDetail = false">
            <template x-if="selected">
                <div class="bg-white shadow-2xl p-6 rounded-3xl w-full max-w-md overflow-hidden">
                    <div class="flex justify-between items-center mb-4 pb-2 border-b">
                        <h3 class="font-bold text-primary text-lg"
                            x-text="isEditMode ? 'Edit Status Pembayaran' : 'Detail Pembayaran'"></h3>
                        <button type="button" @click="showDetail = false" class="text-gray-400 hover:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-3 mb-4 text-gray-700 text-sm">
                        <div class="flex justify-between"><span>No. Tagihan</span><span
                                class="font-bold text-gray-900" x-text="selected.nomor_tagihan"></span></div>
                        <div class="flex justify-between"><span>Nama Penghuni</span><span
                                class="font-semibold text-gray-800" x-text="selected.nama_penghuni || '-'"></span>
                        </div>
                        <div class="flex justify-between"><span>Bulan</span><span class="font-semibold"
                                x-text="selected.bulan_tagihan"></span></div>
                        <div class="flex justify-between"><span>Total Tagihan</span><span
                                class="font-bold text-primary"
                                x-text="'Rp ' + Number(selected.jumlah_tagihan).toLocaleString('id-ID')"></span></div>
                        <div class="flex justify-between items-center">
                            <span>Status Saat Ini</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-semibold text-xs"
                                :class="selected.status_pembayaran === 'Lunas' ? 'bg-success-100 text-success-700' :
                                    (selected.status_pembayaran === 'Menunggu Konfirmasi' ?
                                        'bg-warning-100 text-warning-700' : 'bg-red-100 text-red-700')"
                                x-text="selected.status_pembayaran">
                            </span>
                        </div>
                    </div>

                    {{-- Tampilan Gambar Bukti Pembayran --}}
                    <div class="mb-5">
                        <span class="block mb-1 font-medium text-grayCustom-500 text-xs">Gambar Bukti Transfer</span>
                        <template x-if="selected.bukti_pembayaran_path">
                            <div class="bg-gray-50 p-2 border rounded-xl overflow-hidden">
                                <img :src="'/storage/' + selected.bukti_pembayaran_path"
                                    class="mx-auto rounded-lg w-full h-48 object-contain" alt="Bukti Transfer">
                            </div>
                        </template>
                        <template x-if="!selected.bukti_pembayaran_path">
                            <div
                                class="flex flex-col justify-center items-center bg-gray-50 border-2 border-dashed rounded-xl w-full h-32 text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="mb-1 w-8 h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375 0 11-.75 0 .375 0 01.75 0z" />
                                </svg>
                                <span class="text-xs">Penghuni belum mengunggah bukti transfer</span>
                            </div>
                        </template>
                    </div>

                    <template x-if="isEditMode">
                        <form method="POST" :action="'{{ url('/' . $roleForRoute . '/pembayaran') }}/' + selected.id"
                            class="pt-4 border-t">
                            @csrf @method('PUT')
                            <label class="block mb-1 font-medium text-grayCustom-500 text-xs">Ubah Status
                                Pembayaran</label>
                            <select name="status_pembayaran" x-model="selected.status_pembayaran"
                                class="border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full text-sm">
                                <option value="Belum Dibayar">Belum Dibayar</option>
                                <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                                <option value="Lunas">Lunas</option>
                            </select>
                            <div class="flex justify-end gap-2 mt-5">
                                <button type="button" @click="showDetail = false"
                                    class="hover:bg-gray-50 px-4 py-2 rounded-xl font-semibold text-grayCustom-500 text-sm">Batal</button>
                                <button type="submit"
                                    class="bg-primary hover:bg-primary/90 shadow-sm px-4 py-2 rounded-xl font-semibold text-white text-sm transition">Simpan
                                    Perubahan</button>
                            </div>
                        </form>
                    </template>

                    <template x-if="!isEditMode">
                        <div class="flex justify-end mt-5 pt-4 border-t">
                            <button type="button" @click="showDetail = false"
                                class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-xl font-semibold text-grayCustom-700 text-sm transition">Tutup</button>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>

    <script>
        function pembayaranPage() {
            return {
                showDetail: false,
                selected: null,
                isEditMode: false,
                openDetail(pembayaran, editMode) {
                    this.selected = pembayaran;
                    this.isEditMode = editMode;
                    this.showDetail = true;
                }
            }
        }
    </script>
</x-app-layout>
