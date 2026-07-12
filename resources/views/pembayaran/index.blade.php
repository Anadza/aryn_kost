@php
    $roleForRoute = auth()->user()->hasRole('admin') ? 'admin' : 'owner';
    $indexRouteName = "{$roleForRoute}.pembayaran.index";
    $updateRouteName = "{$roleForRoute}.pembayaran.update";
@endphp
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-primary text-xl">
            Data Pembayaran
        </h2>
    </x-slot>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div x-data="pembayaranPage()" class="space-y-6 mx-auto px-6 pt-2 pb-8 max-w-7xl">

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
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- Pencarian, Filter, dan Status --}}
        <form method="GET" action="{{ route($indexRouteName) }}" x-ref="searchForm"
            class="flex sm:flex-row flex-col sm:items-end gap-3 sm:gap-4">
            <div class="flex-1">
                <label class="block mb-1 text-grayCustom-500 text-xs">Cari Tagihan</label>
                <div class="relative">
                    <span class="left-0 absolute inset-y-0 flex items-center pl-3 text-grayCustom-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m1.1-5.4a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" />
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Cari Nomor / Bulan Tagihan" autocomplete="off"
                        @input.debounce.400ms="$refs.searchForm.requestSubmit()"
                        class="bg-white shadow-sm py-2.5 pr-4 pl-9 border border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full sm:max-w-xs text-grayCustom-700 text-sm placeholder-grayCustom-400">
                </div>
            </div>
            <div>
                <label class="block mb-1 text-grayCustom-500 text-xs">Tanggal Upload Bukti</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}"
                    onchange="this.form.requestSubmit()"
                    class="bg-white shadow-sm px-3 py-2 border border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full sm:w-48 text-grayCustom-700 text-sm">
            </div>
            <div>
                <label class="block mb-1 text-grayCustom-500 text-xs">Status</label>
                <select name="status" onchange="this.form.requestSubmit()"
                    class="bg-white shadow-sm border border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full sm:w-52 text-grayCustom-700 text-sm">
                    <option value="" {{ $statusFilter === null || $statusFilter === '' ? 'selected' : '' }}>Semua Status</option>
                    <option value="Belum Dibayar" {{ $statusFilter === 'Belum Dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                    <option value="Menunggu Konfirmasi" {{ $statusFilter === 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                    <option value="Lunas" {{ $statusFilter === 'Lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>
        </form>

    {{-- Tabel --}}
    <div class="bg-white shadow-sm mt-6 p-4 sm:p-6 rounded-2xl overflow-hidden">
        @if ($pembayarans->isEmpty())
            <p class="py-10 text-grayCustom-400 text-sm text-center">Tidak ada data pembayaran yang cocok.</p>
        @else
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-sm border-separate border-spacing-y-2">
                    <thead>
                        <tr class="bg-grayCustom-50 font-semibold text-grayCustom-400 text-xs text-left">
                            <th class="px-4 py-3 rounded-l-full">No</th>
                            <th class="px-4 py-3">Nomor Tagihan</th>
                            <th class="px-4 py-3">Bulan Tagihan</th>
                            <th class="px-4 py-3">Jumlah</th>
                            <th class="px-4 py-3">Jatuh Tempo</th>
                            <th class="px-4 py-3">Upload Bukti</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 rounded-r-full text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembayarans as $index => $pembayaran)
                            <tr class="hover:bg-grayCustom-50/50 transition duration-150">
                                <td class="px-4 py-4 font-bold text-grayCustom-800">{{ $pembayarans->firstItem() + $index }}</td>

                                <td class="px-4 py-4 font-medium text-grayCustom-700 whitespace-nowrap">
                                    {{ $pembayaran->nomor_tagihan }}
                                </td>

                                <td class="px-4 py-4 font-medium text-grayCustom-500 whitespace-nowrap">
                                    {{ $pembayaran->bulan_tagihan }}
                                </td>

                                <td class="px-4 py-4 font-medium text-grayCustom-500 whitespace-nowrap">
                                    Rp {{ number_format($pembayaran->jumlah_tagihan, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-4 text-grayCustom-400 whitespace-nowrap">
                                    {{ \Illuminate\Support\Carbon::parse($pembayaran->tanggal_jatuh_tempo)->format('d M Y') }}
                                </td>

                                <td class="px-4 py-4 text-grayCustom-400 whitespace-nowrap">
                                    {{ $pembayaran->tanggal_upload_bukti ? \Illuminate\Support\Carbon::parse($pembayaran->tanggal_upload_bukti)->format('d M Y, H:i') : '-' }}
                                </td>

                                <td class="px-4 py-4 whitespace-nowrap">
                                    @if ($pembayaran->status_pembayaran === 'Lunas')
                                        <span class="inline-flex items-center gap-1.5 bg-success-50 px-3 py-1 rounded-full font-semibold text-success-600 text-xs">
                                            <span class="bg-success-500 rounded-full w-1.5 h-1.5"></span>
                                            Lunas
                                        </span>
                                    @elseif ($pembayaran->status_pembayaran === 'Menunggu Konfirmasi')
                                        <span class="inline-flex items-center gap-1.5 bg-warning-50 px-3 py-1 rounded-full font-semibold text-warning-600 text-xs">
                                            <span class="bg-warning-500 rounded-full w-1.5 h-1.5"></span>
                                            Menunggu Konfirmasi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 bg-grayCustom-100 px-3 py-1 rounded-full font-semibold text-grayCustom-600 text-xs">
                                            <span class="bg-grayCustom-400 rounded-full w-1.5 h-1.5"></span>
                                            Belum Dibayar
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-4 text-center whitespace-nowrap">
                                    <div class="flex justify-center items-center gap-3">
                                        {{-- Tombol Detail --}}
                                        <button type="button" title="Lihat detail"
                                            @click="openDetail({{ Illuminate\Support\Js::from($pembayaran) }})"
                                            class="text-grayCustom-400 hover:text-primary transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>

                                        @can('pembayaran.edit')
                                            <button type="button" title="Konfirmasi status"
                                                @click="openDetail({{ Illuminate\Support\Js::from($pembayaran) }})"
                                                class="text-primary hover:text-primary/80 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
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

            {{-- Mobile cards --}}
            <div class="md:hidden space-y-3">
                @foreach ($pembayarans as $pembayaran)
                    <div class="p-4 border border-grayCustom-100 rounded-xl" @click="openDetail({{ Illuminate\Support\Js::from($pembayaran) }})">
                        <div class="flex justify-between items-center">
                            <p class="font-semibold text-grayCustom-800">{{ $pembayaran->nomor_tagihan }}</p>
                            @if ($pembayaran->status_pembayaran === 'Lunas')
                                <span class="font-semibold text-success-600 text-xs">Lunas</span>
                            @elseif ($pembayaran->status_pembayaran === 'Menunggu Konfirmasi')
                                <span class="font-semibold text-warning-600 text-xs">Menunggu Konfirmasi</span>
                            @else
                                <span class="font-semibold text-grayCustom-500 text-xs">Belum Dibayar</span>
                            @endif
                        </div>
                        <p class="mt-1 text-grayCustom-500 text-sm">{{ $pembayaran->bulan_tagihan }} &middot; Rp {{ number_format($pembayaran->jumlah_tagihan, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $pembayarans->withQueryString()->links() }}
    </div>

    {{-- ===================== MODAL: DETAIL & KONFIRMASI PEMBAYARAN ===================== --}}
    <div x-show="showDetail" x-cloak
            class="z-50 fixed inset-0 flex justify-center items-center bg-black/50 p-4"
            @click.self="showDetail = false">
            <template x-if="selected">
                <div x-show="showDetail" x-transition
                    class="bg-white shadow-xl p-6 rounded-2xl w-full max-w-md">
                    <h3 class="mb-4 font-bold text-primary text-lg">Detail Tagihan</h3>

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-grayCustom-500">Nomor Tagihan</span>
                            <span class="font-medium text-grayCustom-800" x-text="selected.nomor_tagihan"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-grayCustom-500">Bulan Tagihan</span>
                            <span class="font-medium text-grayCustom-800" x-text="selected.bulan_tagihan"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-grayCustom-500">Jumlah</span>
                            <span class="font-medium text-grayCustom-800" x-text="formatRupiah(selected.jumlah_tagihan)"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-grayCustom-500">Jatuh Tempo</span>
                            <span class="font-medium text-grayCustom-800" x-text="formatDate(selected.tanggal_jatuh_tempo)"></span>
                        </div>
                    </div>

                    <div class="mt-4" x-show="selected.bukti_pembayaran_path">
                        <p class="mb-1 text-grayCustom-500 text-xs">Bukti Pembayaran</p>
                        <a :href="'/storage/' + selected.bukti_pembayaran_path" target="_blank"
                            class="inline-flex items-center gap-1 font-semibold text-primary text-sm hover:underline">
                            Lihat file bukti pembayaran
                        </a>
                    </div>
                    <p class="mt-4 text-grayCustom-400 text-xs" x-show="!selected.bukti_pembayaran_path">
                        Penghuni belum mengunggah bukti pembayaran.
                    </p>

                    @can('pembayaran.edit')
                        <form method="POST" :action="selected ? '{{ url('/'.$roleForRoute.'/pembayaran') }}/' + selected.id : '#'" class="mt-6">
                            @csrf
                            @method('PUT')

                            <label class="block mb-1 font-medium text-grayCustom-500 text-xs">Status Pembayaran</label>
                            <select name="status_pembayaran" x-model="selected.status_pembayaran" required
                                class="shadow-sm border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full text-sm">
                                <option value="Belum Dibayar">Belum Dibayar</option>
                                <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                                <option value="Lunas">Lunas</option>
                            </select>

                            <div class="flex justify-end gap-2 mt-5">
                                <button type="button" @click="showDetail = false"
                                    class="hover:bg-grayCustom-100 px-4 py-2 rounded-xl font-semibold text-grayCustom-500 text-sm transition">
                                    Tutup
                                </button>
                                <button type="submit"
                                    class="bg-primary hover:bg-primary/90 px-4 py-2 rounded-xl font-semibold text-white text-sm transition">
                                    Simpan Status
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="flex justify-end mt-6">
                            <button type="button" @click="showDetail = false"
                                class="hover:bg-grayCustom-100 px-4 py-2 rounded-xl font-semibold text-grayCustom-500 text-sm transition">
                                Tutup
                            </button>
                        </div>
                    @endcan
                </div>
            </template>
        </div>
    </div>

    <script>
        function pembayaranPage() {
            return {
                showDetail: false,
                selected: null,

                openDetail(pembayaran) {
                    this.selected = { ...pembayaran };
                    this.showDetail = true;
                },
                formatRupiah(value) {
                    if (value === null || value === undefined) return '-';
                    return 'Rp' + Number(value).toLocaleString('id-ID');
                },
                formatDate(value) {
                    if (!value) return '-';
                    return new Date(value).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
                },
            };
        }
    </script>

</x-app-layout>
