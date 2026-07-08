<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-[#23466E] text-xl">
            Data Kamar
        </h2>
    </x-slot>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="py-6"
         x-data="kamarPage()">

        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

    <div class="flex justify-center items-start p-3 sm:p-6 lg:p-10 min-h-screen">
        <div class="bg-[#EADCC6] shadow-2xl rounded-[28px] w-full max-w-6xl overflow-hidden">

            {{-- ===== Header ===== --}}
            <div class="flex justify-between items-center bg-[#1E3A5F] px-4 sm:px-8 py-5 sm:py-6">
                <div class="flex items-center gap-3 sm:gap-4">
                    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('dashboard') }}"
                       class="hover:opacity-80 text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 sm:w-7 h-6 sm:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h1 class="font-bold text-white text-lg sm:text-2xl tracking-wide">Data Pengaduan</h1>
                </div>

                <button type="button" class="relative hover:opacity-80 text-white transition" title="Notifikasi">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 sm:w-7 h-6 sm:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="-top-0.5 -right-0.5 absolute bg-red-500 rounded-full ring-[#1E3A5F] ring-2 w-2.5 h-2.5"></span>
                </button>
            </div>

            {{-- ===== Content ===== --}}
            <div class="space-y-6 sm:space-y-8 p-4 sm:p-8">

                @if (session('success'))
                    <div class="bg-green-100 px-4 py-3 rounded-xl font-medium text-green-700 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Stat cards --}}
                <div class="gap-4 sm:gap-6 grid grid-cols-1 sm:grid-cols-3">
                    <div class="bg-gradient-to-b from-white to-gray-100 shadow-md px-6 py-6 sm:py-8 rounded-2xl text-center">
                        <p class="font-medium text-gray-500 text-sm sm:text-base">Total Pengaduan</p>
                        <p class="mt-2 font-bold text-[#1E3A5F] text-3xl sm:text-4xl">{{ $total }}</p>
                    </div>
                    <div class="bg-gradient-to-b from-white to-gray-100 shadow-md px-6 py-6 sm:py-8 rounded-2xl text-center">
                        <p class="font-medium text-gray-500 text-sm sm:text-base">Sedang Diproses</p>
                        <p class="mt-2 font-bold text-[#1E3A5F] text-3xl sm:text-4xl">{{ $sedangDiproses }}</p>
                    </div>
                    <div class="bg-gradient-to-b from-white to-gray-100 shadow-md px-6 py-6 sm:py-8 rounded-2xl text-center">
                        <p class="font-medium text-gray-500 text-sm sm:text-base">Selesai</p>
                        <p class="mt-2 font-bold text-[#1E3A5F] text-3xl sm:text-4xl">{{ $selesai }}</p>
                    </div>
                </div>

                {{-- Table card --}}
                <div class="bg-white shadow-md p-4 sm:p-6 rounded-2xl">
                    <h2 class="mb-4 font-semibold text-[#1E3A5F] text-base sm:text-lg">Daftar Pengaduan</h2>

                    @if ($pengaduans->isEmpty())
                        <p class="py-10 text-gray-400 text-sm text-center">Belum ada data pengaduan.</p>
                    @else
                        {{-- Desktop / tablet table --}}
                        <div class="hidden md:block overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-gray-100 border-b text-gray-400 text-xs text-left uppercase tracking-wide">
                                        <th class="py-3 pr-4 font-medium">Tanggal</th>
                                        <th class="py-3 pr-4 font-medium">Penyewa</th>
                                        <th class="py-3 pr-4 font-medium">Kamar</th>
                                        <th class="py-3 pr-4 font-medium">Kategori</th>
                                        <th class="py-3 pr-4 font-medium">Deskripsi</th>
                                        <th class="py-3 pr-4 font-medium">Status</th>
                                        <th class="py-3 pr-0 font-medium text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengaduans as $pengaduan)
                                        <tr class="hover:bg-gray-50/70 border-gray-50 border-b last:border-b-0 transition">
                                            <td class="py-4 pr-4 text-gray-700 whitespace-nowrap">{{ $pengaduan->tanggal->format('d/n/Y') }}</td>
                                            <td class="py-4 pr-4 font-medium text-gray-700 whitespace-nowrap">{{ $pengaduan->penyewa }}</td>
                                            <td class="py-4 pr-4 text-gray-500 whitespace-nowrap">{{ $pengaduan->kamar }}</td>
                                            <td class="py-4 pr-4 text-gray-500 whitespace-nowrap">{{ $pengaduan->kategori }}</td>
                                            <td class="py-4 pr-4 max-w-[220px] text-gray-500 truncate">{{ $pengaduan->deskripsi }}</td>
                                            <td class="py-4 pr-4 whitespace-nowrap">
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $pengaduan->statusBadgeClass() }}">
                                                    <span class="h-1.5 w-1.5 rounded-full {{ $pengaduan->statusDotClass() }}"></span>
                                                    {{ $pengaduan->statusLabel() }}
                                                </span>
                                            </td>
                                            <td class="py-4 pr-0">
                                                <div class="flex justify-end items-center gap-2">
                                                    <button type="button" title="Lihat detail" class="hover:bg-gray-100 p-1.5 rounded-lg text-gray-400 hover:text-gray-600 transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                                                        </svg>
                                                    </button>

                                                    @if ($pengaduan->status === 'pending')
                                                        <form method="POST" action="{{ route('pengaduan.update-status', $pengaduan) }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="diproses">
                                                            <button type="submit" class="bg-indigo-100 hover:bg-indigo-200 px-3 py-1 rounded-full font-semibold text-indigo-600 text-xs whitespace-nowrap transition">
                                                                Proses
                                                            </button>
                                                        </form>
                                                    @elseif ($pengaduan->status === 'diproses')
                                                        <form method="POST" action="{{ route('pengaduan.update-status', $pengaduan) }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="selesai">
                                                            <button type="submit" class="bg-green-100 hover:bg-green-200 px-3 py-1 rounded-full font-semibold text-green-600 text-xs whitespace-nowrap transition">
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

                        {{-- Mobile stacked cards --}}
                        <div class="md:hidden space-y-3">
                            @foreach ($pengaduans as $pengaduan)
                                <div class="shadow-sm p-4 border border-gray-100 rounded-xl">
                                    <div class="flex justify-between items-start gap-3">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $pengaduan->penyewa }}</p>
                                            <p class="mt-0.5 text-gray-400 text-xs">{{ $pengaduan->tanggal->format('d/n/Y') }} &middot; Kamar {{ $pengaduan->kamar }}</p>
                                        </div>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold shrink-0 {{ $pengaduan->statusBadgeClass() }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $pengaduan->statusDotClass() }}"></span>
                                            {{ $pengaduan->statusLabel() }}
                                        </span>
                                    </div>

                                    <div class="mt-3 text-gray-600 text-sm">
                                        <p><span class="text-gray-400">Kategori:</span> {{ $pengaduan->kategori }}</p>
                                        <p class="mt-1"><span class="text-gray-400">Deskripsi:</span> {{ $pengaduan->deskripsi }}</p>
                                    </div>

                                    <div class="flex justify-end items-center gap-2 mt-3">
                                        <button type="button" title="Lihat detail" class="hover:bg-gray-100 p-1.5 rounded-lg text-gray-400 hover:text-gray-600 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                                            </svg>
                                        </button>

                                        @if ($pengaduan->status === 'pending')
                                            <form method="POST" action="{{ route('pengaduan.update-status', $pengaduan) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="diproses">
                                                <button type="submit" class="bg-indigo-100 hover:bg-indigo-200 px-3 py-1 rounded-full font-semibold text-indigo-600 text-xs transition">
                                                    Proses
                                                </button>
                                            </form>
                                        @elseif ($pengaduan->status === 'diproses')
                                            <form method="POST" action="{{ route('pengaduan.update-status', $pengaduan) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="selesai">
                                                <button type="submit" class="bg-green-100 hover:bg-green-200 px-3 py-1 rounded-full font-semibold text-green-600 text-xs transition">
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
        </div>
    </div>

</x-app-layout>
