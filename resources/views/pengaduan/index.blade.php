<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Data Pengaduan - {{ config('app.name', 'Aryn Kost') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#EADCC6]">

    <div class="min-h-screen flex items-start justify-center p-3 sm:p-6 lg:p-10">
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
                    <h1 class="text-white font-bold text-lg sm:text-2xl tracking-wide">Data Pengaduan</h1>
                </div>

                <button type="button" class="relative text-white hover:opacity-80 transition" title="Notifikasi">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute -top-0.5 -right-0.5 h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-[#1E3A5F]"></span>
                </button>
            </div>

            {{-- ===== Content ===== --}}
            <div class="p-4 sm:p-8 space-y-6 sm:space-y-8">

                @if (session('success'))
                    <div class="bg-green-100 text-green-700 text-sm font-medium px-4 py-3 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Stat cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                    <div class="bg-gradient-to-b from-white to-gray-100 rounded-2xl shadow-md px-6 py-6 sm:py-8 text-center">
                        <p class="text-gray-500 font-medium text-sm sm:text-base">Total Pengaduan</p>
                        <p class="text-[#1E3A5F] font-bold text-3xl sm:text-4xl mt-2">{{ $total }}</p>
                    </div>
                    <div class="bg-gradient-to-b from-white to-gray-100 rounded-2xl shadow-md px-6 py-6 sm:py-8 text-center">
                        <p class="text-gray-500 font-medium text-sm sm:text-base">Sedang Diproses</p>
                        <p class="text-[#1E3A5F] font-bold text-3xl sm:text-4xl mt-2">{{ $sedangDiproses }}</p>
                    </div>
                    <div class="bg-gradient-to-b from-white to-gray-100 rounded-2xl shadow-md px-6 py-6 sm:py-8 text-center">
                        <p class="text-gray-500 font-medium text-sm sm:text-base">Selesai</p>
                        <p class="text-[#1E3A5F] font-bold text-3xl sm:text-4xl mt-2">{{ $selesai }}</p>
                    </div>
                </div>

                {{-- Table card --}}
                <div class="bg-white rounded-2xl shadow-md p-4 sm:p-6">
                    <h2 class="text-[#1E3A5F] font-semibold text-base sm:text-lg mb-4">Daftar Pengaduan</h2>

                    @if ($pengaduans->isEmpty())
                        <p class="text-gray-400 text-sm text-center py-10">Belum ada data pengaduan.</p>
                    @else
                        {{-- Desktop / tablet table --}}
                        <div class="hidden md:block overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-left text-gray-400 uppercase text-xs tracking-wide border-b border-gray-100">
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
                                        <tr class="border-b border-gray-50 last:border-b-0 hover:bg-gray-50/70 transition">
                                            <td class="py-4 pr-4 text-gray-700 whitespace-nowrap">{{ $pengaduan->tanggal->format('d/n/Y') }}</td>
                                            <td class="py-4 pr-4 text-gray-700 font-medium whitespace-nowrap">{{ $pengaduan->penyewa }}</td>
                                            <td class="py-4 pr-4 text-gray-500 whitespace-nowrap">{{ $pengaduan->kamar }}</td>
                                            <td class="py-4 pr-4 text-gray-500 whitespace-nowrap">{{ $pengaduan->kategori }}</td>
                                            <td class="py-4 pr-4 text-gray-500 max-w-[220px] truncate">{{ $pengaduan->deskripsi }}</td>
                                            <td class="py-4 pr-4 whitespace-nowrap">
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $pengaduan->statusBadgeClass() }}">
                                                    <span class="h-1.5 w-1.5 rounded-full {{ $pengaduan->statusDotClass() }}"></span>
                                                    {{ $pengaduan->statusLabel() }}
                                                </span>
                                            </td>
                                            <td class="py-4 pr-0">
                                                <div class="flex items-center justify-end gap-2">
                                                    <button type="button" title="Lihat detail" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                                                        </svg>
                                                    </button>

                                                    @if ($pengaduan->status === 'pending')
                                                        <form method="POST" action="{{ route('pengaduan.update-status', $pengaduan) }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="diproses">
                                                            <button type="submit" class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-600 hover:bg-indigo-200 transition whitespace-nowrap">
                                                                Proses
                                                            </button>
                                                        </form>
                                                    @elseif ($pengaduan->status === 'diproses')
                                                        <form method="POST" action="{{ route('pengaduan.update-status', $pengaduan) }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="selesai">
                                                            <button type="submit" class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-600 hover:bg-green-200 transition whitespace-nowrap">
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
                                <div class="border border-gray-100 rounded-xl p-4 shadow-sm">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $pengaduan->penyewa }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $pengaduan->tanggal->format('d/n/Y') }} &middot; Kamar {{ $pengaduan->kamar }}</p>
                                        </div>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold shrink-0 {{ $pengaduan->statusBadgeClass() }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $pengaduan->statusDotClass() }}"></span>
                                            {{ $pengaduan->statusLabel() }}
                                        </span>
                                    </div>

                                    <div class="mt-3 text-sm text-gray-600">
                                        <p><span class="text-gray-400">Kategori:</span> {{ $pengaduan->kategori }}</p>
                                        <p class="mt-1"><span class="text-gray-400">Deskripsi:</span> {{ $pengaduan->deskripsi }}</p>
                                    </div>

                                    <div class="mt-3 flex items-center justify-end gap-2">
                                        <button type="button" title="Lihat detail" class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                                            </svg>
                                        </button>

                                        @if ($pengaduan->status === 'pending')
                                            <form method="POST" action="{{ route('pengaduan.update-status', $pengaduan) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="diproses">
                                                <button type="submit" class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-600 hover:bg-indigo-200 transition">
                                                    Proses
                                                </button>
                                            </form>
                                        @elseif ($pengaduan->status === 'diproses')
                                            <form method="POST" action="{{ route('pengaduan.update-status', $pengaduan) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="selesai">
                                                <button type="submit" class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-600 hover:bg-green-200 transition">
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

</body>
</html>
