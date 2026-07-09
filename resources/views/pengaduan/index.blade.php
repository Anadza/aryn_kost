<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-primary text-xl">
            Data Pengaduan
        </h2>
    </x-slot>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="space-y-6 mx-auto -mt-6 px-6 pb-8 max-w-7xl">

        {{-- ===================== NOTIFIKASI TOAST MELAYANG ===================== --}}
        <div class="top-5 right-5 z-50 fixed space-y-3 w-full max-w-sm pointer-events-none">
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
            @endif
        </div>

        {{-- Stat Cards --}}
        <div class="gap-4 sm:gap-6 grid grid-cols-1 sm:grid-cols-3">
            <div class="bg-white shadow-md px-6 py-6 border border-grayCustom-100 rounded-2xl text-center">
                <p class="font-medium text-grayCustom-500 text-sm">Total Pengaduan</p>
                <p class="mt-2 font-bold text-primary text-3xl">{{ $total }}</p>
            </div>
            <div class="bg-white shadow-md px-6 py-6 border border-grayCustom-100 rounded-2xl text-center">
                <p class="font-medium text-grayCustom-500 text-sm">Sedang Diproses</p>
                <p class="mt-2 font-bold text-primary text-3xl">{{ $sedangDiproses }}</p>
            </div>
            <div class="bg-white shadow-md px-6 py-6 border border-grayCustom-100 rounded-2xl text-center">
                <p class="font-medium text-grayCustom-500 text-sm">Selesai</p>
                <p class="mt-2 font-bold text-primary text-3xl">{{ $selesai }}</p>
            </div>
        </div>

        {{-- Table Container Card --}}
        <div class="bg-white shadow-lg p-4 sm:p-6 rounded-2xl overflow-hidden">
            <h2 class="mb-4 font-bold text-primary text-lg">Daftar Pengaduan</h2>

            @if ($pengaduans->isEmpty())
                <p class="py-10 text-grayCustom-400 text-sm text-center">Belum ada data pengaduan.</p>
            @else
                {{-- Desktop / Tablet Table --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-grayCustom-100 border-b text-primary/70 text-xs text-left uppercase tracking-wide">
                                <th class="py-3 pr-4 font-medium">Tanggal</th>
                                <th class="py-3 pr-4 font-medium">Penyewa</th>
                                <th class="py-3 pr-4 font-medium text-center">Kamar</th>
                                <th class="py-3 pr-4 font-medium text-center">Kategori</th>
                                <th class="py-3 pr-4 font-medium">Deskripsi</th>
                                <th class="py-3 pr-4 font-medium text-center">Status</th>
                                <th class="py-3 pr-0 font-medium text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengaduans as $pengaduan)
                                <tr class="hover:bg-grayCustom-50 border-grayCustom-5 border-b last:border-b-0 transition">
                                    <td class="py-4 pr-4 text-grayCustom-500 whitespace-nowrap">{{ $pengaduan->tanggal->format('d M Y') }}</td>
                                    <td class="py-4 pr-4 font-medium text-grayCustom-700 whitespace-nowrap">{{ $pengaduan->penyewa }}</td>
                                    <td class="py-4 pr-4 text-grayCustom-500 text-center whitespace-nowrap">{{ $pengaduan->kamar }}</td>
                                    <td class="py-4 pr-4 text-grayCustom-500 text-center whitespace-nowrap">{{ $pengaduan->kategori }}</td>
                                    <td class="py-4 pr-4 max-w-[220px] text-grayCustom-500 truncate">{{ $pengaduan->deskripsi }}</td>
                                    <td class="py-4 pr-4 text-center whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $pengaduan->statusBadgeClass() }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $pengaduan->statusDotClass() }}"></span>
                                            {{ $pengaduan->statusLabel() }}
                                        </span>
                                    </td>
                                    <td class="py-4 pr-0">
                                        <div class="flex justify-center items-center gap-2">
                                            <button type="button" title="Lihat detail" class="hover:bg-grayCustom-100 p-1.5 rounded-lg text-grayCustom-400 hover:text-primary transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                                                </svg>
                                            </button>

                                            @if ($pengaduan->status === 'pending')
                                                <form method="POST" action="{{ route('pengaduan.update-status', $pengaduan) }}">
                                                    @csrf
                                                    @with('PATCH')
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="diproses">
                                                    <button type="submit" class="bg-indigo-100 hover:bg-indigo-200 px-3 py-1 rounded-full font-semibold text-indigo-700 text-xs whitespace-nowrap transition">
                                                        Proses
                                                    </button>
                                                </form>
                                            @elseif ($pengaduan->status === 'diproses')
                                                <form method="POST" action="{{ route('pengaduan.update-status', $pengaduan) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="selesai">
                                                    <button type="submit" class="bg-success-100 hover:bg-success-200 px-3 py-1 rounded-full font-semibold text-success-700 text-xs whitespace-nowrap transition">
                                                        Selesai
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Stacked Cards --}}
                <div class="md:hidden space-y-3">
                    @foreach ($pengaduans as $pengaduan)
                        <div class="bg-white shadow-sm p-4 border border-grayCustom-100 rounded-xl">
                            <div class="flex justify-between items-start gap-3">
                                <div>
                                    <p class="font-semibold text-grayCustom-700">{{ $pengaduan->penyewa }}</p>
                                    <p class="mt-0.5 text-grayCustom-400 text-xs">{{ $pengaduan->tanggal->format('d M Y') }} &middot; Kamar {{ $pengaduan->kamar }}</p>
                                </div>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold shrink-0 {{ $pengaduan->statusBadgeClass() }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $pengaduan->statusDotClass() }}"></span>
                                    {{ $pengaduan->statusLabel() }}
                                </span>
                            </div>

                            <div class="space-y-1 mt-3 text-grayCustom-500 text-sm">
                                <p><span class="text-grayCustom-400">Kategori:</span> {{ $pengaduan->kategori }}</p>
                                <p><span class="text-grayCustom-400">Deskripsi:</span> {{ $pengaduan->deskripsi }}</p>
                            </div>

                            <div class="flex justify-end items-center gap-2 mt-3 pt-2 border-grayCustom-50 border-t">
                                <button type="button" title="Lihat detail" class="hover:bg-grayCustom-100 p-1.5 rounded-lg text-grayCustom-400 hover:text-primary transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                                    </svg>
                                </button>

                                @if ($pengaduan->status === 'pending')
                                    <form method="POST" action="{{ route('pengaduan.update-status', $pengaduan) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="diproses">
                                        <button type="submit" class="bg-indigo-100 hover:bg-indigo-200 px-3 py-1 rounded-full font-semibold text-indigo-700 text-xs transition">
                                            Proses
                                        </button>
                                    </form>
                                @elseif ($pengaduan->status === 'diproses')
                                    <form method="POST" action="{{ route('pengaduan.update-status', $pengaduan) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="selesai">
                                        <button type="submit" class="bg-success-100 hover:bg-success-200 px-3 py-1 rounded-full font-semibold text-success-700 text-xs transition">
                                            Selesai
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</x-app-layout>
