<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-[#23466E] text-xl">
            Notifikasi
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">

            <div class="flex justify-center items-start p-3 sm:p-6 lg:p-10 min-h-screen">
                <div class="bg-[#EADCC6] shadow-2xl rounded-[28px] w-full max-w-6xl overflow-hidden">

                    {{-- ===== Header ===== --}}
                    <div class="flex justify-between items-center bg-[#1E3A5F] px-4 sm:px-8 py-5 sm:py-6">
                        <div class="flex items-center gap-3 sm:gap-4">
                            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('admin.dashboard') }}"
                               class="hover:opacity-80 text-white transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 sm:w-7 h-6 sm:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                            <h1 class="font-bold text-white text-lg sm:text-2xl tracking-wide">Notifikasi</h1>
                        </div>

                        @if ($belumDibaca > 0)
                            <form method="POST" action="{{ route('admin.notifikasi.read-all') }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="bg-white/10 hover:bg-white/20 px-3 sm:px-4 py-2 rounded-full font-medium text-white text-xs sm:text-sm transition">
                                    Tandai semua dibaca
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- ===== Content ===== --}}
                    <div class="space-y-6 sm:space-y-8 p-4 sm:p-8">

                        @if (session('success'))
                            <div class="bg-green-100 px-4 py-3 rounded-xl font-medium text-green-700 text-sm">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Stat cards --}}
                        <div class="gap-4 sm:gap-6 grid grid-cols-2 sm:grid-cols-4">
                            <div class="bg-gradient-to-b from-white to-gray-100 shadow-md px-4 py-5 sm:py-6 rounded-2xl text-center">
                                <p class="font-medium text-gray-500 text-xs sm:text-sm">Belum Dibaca</p>
                                <p class="mt-2 font-bold text-[#1E3A5F] text-2xl sm:text-3xl">{{ $belumDibaca }}</p>
                            </div>
                            <div class="bg-gradient-to-b from-white to-gray-100 shadow-md px-4 py-5 sm:py-6 rounded-2xl text-center">
                                <p class="font-medium text-gray-500 text-xs sm:text-sm">Pembayaran</p>
                                <p class="mt-2 font-bold text-[#1E3A5F] text-2xl sm:text-3xl">{{ $totalPembayaran }}</p>
                            </div>
                            <div class="bg-gradient-to-b from-white to-gray-100 shadow-md px-4 py-5 sm:py-6 rounded-2xl text-center">
                                <p class="font-medium text-gray-500 text-xs sm:text-sm">Keluhan</p>
                                <p class="mt-2 font-bold text-[#1E3A5F] text-2xl sm:text-3xl">{{ $totalKeluhan }}</p>
                            </div>
                            <div class="bg-gradient-to-b from-white to-gray-100 shadow-md px-4 py-5 sm:py-6 rounded-2xl text-center">
                                <p class="font-medium text-gray-500 text-xs sm:text-sm">Booking</p>
                                <p class="mt-2 font-bold text-[#1E3A5F] text-2xl sm:text-3xl">{{ $totalBooking }}</p>
                            </div>
                        </div>

                        {{-- Filter tabs --}}
                        <div class="flex flex-wrap gap-2">
                            @php
                                $tabs = [
                                    'semua' => 'Semua',
                                    'pembayaran' => 'Pembayaran',
                                    'keluhan' => 'Keluhan',
                                    'booking' => 'Booking',
                                ];
                            @endphp
                            @foreach ($tabs as $value => $label)
                                <a href="{{ route('admin.notifikasi.index', ['jenis' => $value]) }}"
                                   class="px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition {{ $jenisAktif === $value ? 'bg-[#1E3A5F] text-white' : 'bg-white text-gray-500 hover:bg-gray-100' }}">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>

                        {{-- List card --}}
                        <div class="bg-white shadow-md p-4 sm:p-6 rounded-2xl">
                            <h2 class="mb-4 font-semibold text-[#1E3A5F] text-base sm:text-lg">Daftar Notifikasi</h2>

                            @if ($notifikasis->isEmpty())
                                <p class="py-10 text-gray-400 text-sm text-center">Belum ada notifikasi.</p>
                            @else
                                <div class="space-y-3">
                                    @foreach ($notifikasis as $notifikasi)
                                        <div class="flex items-start gap-3 sm:gap-4 p-4 border rounded-xl transition {{ $notifikasi->isBelumDibaca() ? 'bg-blue-50/60 border-blue-100' : 'bg-white border-gray-100' }}">

                                            <div class="flex justify-center items-center rounded-full w-10 h-10 shrink-0 {{ $notifikasi->jenisIconBgClass() }}">
                                                @switch($notifikasi->jenisIcon())
                                                    @case('wallet')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12V7H5a2 2 0 010-4h14v4M3 5v14a2 2 0 002 2h16v-5M18 12a2 2 0 100 4 2 2 0 000-4z" />
                                                        </svg>
                                                        @break
                                                    @case('alert')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86l-8.18 14A2 2 0 004 21h16a2 2 0 001.89-3.14l-8.18-14a2 2 0 00-3.42 0z" />
                                                        </svg>
                                                        @break
                                                    @case('calendar')
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <rect x="3" y="4" width="18" height="18" rx="2" />
                                                            <path stroke-linecap="round" d="M16 2v4M8 2v4M3 10h18" />
                                                        </svg>
                                                        @break
                                                @endswitch
                                            </div>

                                            <div class="flex-1 min-w-0">
                                                <div class="flex flex-wrap justify-between items-center gap-2">
                                                    <div class="flex items-center gap-2">
                                                        <p class="font-semibold text-gray-800 text-sm sm:text-base">{{ $notifikasi->judul }}</p>
                                                        <span class="px-2 py-0.5 rounded-full font-semibold text-[10px] sm:text-xs {{ $notifikasi->jenisBadgeClass() }}">
                                                            {{ $notifikasi->jenisLabel() }}
                                                        </span>
                                                        @if ($notifikasi->isBelumDibaca())
                                                            <span class="bg-red-500 rounded-full w-2 h-2"></span>
                                                        @endif
                                                    </div>
                                                    <span class="text-gray-400 text-xs whitespace-nowrap">{{ $notifikasi->waktuRelatif() }}</span>
                                                </div>

                                                <p class="mt-1 text-gray-600 text-sm">{{ $notifikasi->pesan }}</p>

                                                <p class="mt-1.5 text-gray-400 text-xs">
                                                    Dari <span class="font-medium text-gray-500">{{ $notifikasi->pengirim }}</span>
                                                    @if ($notifikasi->kamar)
                                                        &middot; Kamar {{ $notifikasi->kamar }}
                                                    @endif
                                                    @if ($notifikasi->jenis === 'pembayaran' && !empty($notifikasi->data['jumlah']))
                                                        &middot; Rp{{ number_format($notifikasi->data['jumlah'], 0, ',', '.') }}
                                                    @endif
                                                    @if ($notifikasi->jenis === 'booking' && !empty($notifikasi->data['tanggal_masuk']))
                                                        &middot; Masuk {{ \Illuminate\Support\Carbon::parse($notifikasi->data['tanggal_masuk'])->format('d/n/Y') }}
                                                    @endif
                                                </p>
                                            </div>

                                            @if ($notifikasi->isBelumDibaca())
                                                <form method="POST" action="{{ route('admin.notifikasi.read', $notifikasi) }}" class="shrink-0">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="bg-indigo-100 hover:bg-indigo-200 px-3 py-1.5 rounded-full font-semibold text-indigo-600 text-xs whitespace-nowrap transition">
                                                        Tandai dibaca
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>