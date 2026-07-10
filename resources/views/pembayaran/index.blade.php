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

        {{-- Pencarian, Filter, dan Status --}}
        <form method="GET" action="{{ route('pembayaran.index') }}" x-ref="searchForm"
            class="flex sm:flex-row flex-col sm:items-end gap-3 sm:gap-4">
            <div class="flex-1">
                <label class="block mb-1 text-grayCustom-500 text-xs">Cari Penyewa</label>
                <div class="relative">
                    <span class="left-0 absolute inset-y-0 flex items-center pl-3 text-grayCustom-400">
                        <svg xmlns="http://w3.org" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m1.1-5.4a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" />
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari Nama Penghuni" autocomplete="off"
                        @input.debounce.400ms="$refs.searchForm.requestSubmit()"
                        class="bg-white shadow-sm py-2.5 pr-4 pl-9 border border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full sm:max-w-xs text-grayCustom-700 text-sm placeholder-grayCustom-400">
                </div>
            </div>
            <div>
                <label class="block mb-1 text-grayCustom-500 text-xs">Tanggal Pembayaran</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                    onchange="this.form.requestSubmit()"
                    class="bg-white shadow-sm border border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full sm:w-48 text-grayCustom-700 text-sm py-2 px-3">
            </div>
            <div>
                <label class="block mb-1 text-grayCustom-500 text-xs">Status</label>
                <select name="status" onchange="this.form.requestSubmit()"
                    class="bg-white shadow-sm border border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary w-full sm:w-44 text-grayCustom-700 text-sm">
                    <option value="" {{ request('status') === '' ? 'selected' : '' }}>Semua Status</option>
                    <option value="belum lunas" {{ request('status') === 'belum lunas' ? 'selected' : '' }}>Belum Lunas
                    </option>
                    <option value="lunas" {{ request('status') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="bg-white shadow-sm p-4 sm:p-6 rounded-2xl overflow-hidden">
        @if ($pembayarans->isEmpty())
            <p class="py-10 text-grayCustom-400 text-sm text-center">Tidak ada data pembayaran yang cocok.</p>
        @else
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-sm border-separate border-spacing-y-2">
                    <thead>
                        <tr class="bg-grayCustom-50 text-grayCustom-400 text-xs font-semibold text-left">
                            <th class="py-3 px-4 rounded-l-full">No</th>
                            <th class="py-3 px-4">Penghuni</th>
                            <th class="py-3 px-4">No. Kamar</th>
                            <th class="py-3 px-4">Nomor Telepon</th>
                            <th class="py-3 px-4">Jumlah</th>
                            <th class="py-3 px-4">Tanggal Bayar</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 rounded-r-full text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembayarans as $index => $pembayaran)
                            <tr class="hover:bg-grayCustom-50/50 transition duration-150">
                                {{-- No --}}
                                <td class="py-4 px-4 font-bold text-grayCustom-800">{{ $index + 1 }}</td>

                                {{-- Penghuni --}}
                                <td class="py-4 px-4 text-grayCustom-400 font-medium whitespace-nowrap">
                                    {{ $pembayaran->penghuni->nama ?? 'Regular text column' }}
                                </td>

                                {{-- No. Kamar --}}
                                <td class="py-4 px-4 text-grayCustom-500 font-medium whitespace-nowrap">
                                    {{ $pembayaran->kamar->no_kamar ?? 'A001' }}
                                </td>

                                {{-- No Telp --}}
                                <td class="py-4 px-4 text-grayCustom-400 whitespace-nowrap">
                                    {{ $pembayaran->penghuni->no_hp ?? '081234567890' }}
                                </td>

                                {{-- Jumlah --}}
                                <td class="py-4 px-4 text-grayCustom-400 font-medium whitespace-nowrap">
                                    Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                                </td>

                                {{-- Tanggal Bayar --}}
                                <td class="py-4 px-4 text-grayCustom-400 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d M Y') }}
                                </td>

                                {{-- Status --}}
                                <td class="py-4 px-4 whitespace-nowrap">
                                    @if ($pembayaran->status === 'lunas')
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-success-50 text-success-600 px-3 py-1 rounded-full text-xs font-semibold">
                                            <span class="h-1.5 w-1.5 rounded-full bg-success-500"></span>
                                            Lunas
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 bg-grayCustom-100 text-grayCustom-600 px-3 py-1 rounded-full text-xs font-semibold">
                                            <span class="h-1.5 w-1.5 rounded-full bg-grayCustom-400"></span>
                                            Belum Lunas
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td class="py-4 px-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        {{-- Tombol Detail --}}
                                        <button type="button" title="Lihat detail"
                                            @click="openDetail({{ Illuminate\Support\Js::from($pembayaran->load(['penghuni', 'kamar'])) }}, '{{ route('pembayaran.update', $pembayaran->id) }}')"
                                            class="text-grayCustom-400 hover:text-primary transition">
                                            <svg xmlns="http://w3.org" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>

                                        {{-- Tombol Edit --}}
                                        <button type="button" title="Edit status"
                                            @click="openDetail({{ Illuminate\Support\Js::from($pembayaran->load(['penghuni', 'kamar'])) }}, '{{ route('pembayaran.update', $pembayaran->id) }}')"
                                            class="text-primary hover:text-primary/80 transition">
                                            <svg xmlns="http://w3.org" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    {{-- Pagination --}}
    <div class="mt-6">
        {{ $pembayarans->withQueryString()->links() }}
    </div>
</x-app-layout>
