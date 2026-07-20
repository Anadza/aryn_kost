<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-primary text-xl">
            Notifikasi
        </h2>
    </x-slot>

    <div class="space-y-6 mx-auto px-6 pt-2 pb-8 max-w-7xl">

        @if (session('success'))
            <div class="bg-success-100 px-4 py-3 rounded-xl font-medium text-success-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Stat cards --}}
        <div class="gap-4 sm:gap-6 grid grid-cols-2 sm:grid-cols-4">
            <div class="bg-white shadow-sm px-4 py-5 border border-grayCustom-100 rounded-2xl text-center">
                <p class="font-medium text-grayCustom-500 text-xs sm:text-sm">Belum Dibaca</p>
                <p class="mt-2 font-bold text-primary text-2xl sm:text-3xl">{{ $belumDibaca }}</p>
            </div>
            <div class="bg-white shadow-sm px-4 py-5 border border-grayCustom-100 rounded-2xl text-center">
                <p class="font-medium text-grayCustom-500 text-xs sm:text-sm">Booking</p>
                <p class="mt-2 font-bold text-primary text-2xl sm:text-3xl">{{ $totalBooking }}</p>
            </div>
            <div class="bg-white shadow-sm px-4 py-5 border border-grayCustom-100 rounded-2xl text-center">
                <p class="font-medium text-grayCustom-500 text-xs sm:text-sm">Tagihan</p>
                <p class="mt-2 font-bold text-primary text-2xl sm:text-3xl">{{ $totalTagihan }}</p>
            </div>
            <div class="bg-white shadow-sm px-4 py-5 border border-grayCustom-100 rounded-2xl text-center">
                <p class="font-medium text-grayCustom-500 text-xs sm:text-sm">Pengaduan</p>
                <p class="mt-2 font-bold text-primary text-2xl sm:text-3xl">{{ $totalPengaduan }}</p>
            </div>
        </div>

        {{-- Filter tabs & aksi --}}
        <div class="flex sm:flex-row flex-col sm:items-center gap-3">
            <div class="flex flex-wrap flex-1 gap-2">
                @php
                    $tabs = [
                        'semua' => 'Semua',
                        'booking' => 'Booking',
                        'tagihan' => 'Tagihan',
                        'pengaduan' => 'Pengaduan',
                    ];
                @endphp
                @foreach ($tabs as $value => $label)
                    <a href="{{ route('penghuni.notifikasi.index', ['jenis' => $value]) }}"
                       class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition {{ $jenisAktif === $value ? 'bg-primary text-white' : 'bg-white border border-grayCustom-200 text-grayCustom-500 hover:bg-grayCustom-50' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            @if ($belumDibaca > 0)
                <form method="POST" action="{{ route('penghuni.notifikasi.read-all') }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="inline-flex justify-center items-center gap-2 bg-primary hover:bg-primary/90 px-4 py-2.5 rounded-xl w-full sm:w-auto font-semibold text-white text-sm transition">
                        Tandai semua dibaca
                    </button>
                </form>
            @endif
        </div>

        {{-- List --}}
        <div class="bg-white shadow-lg p-4 sm:p-6 rounded-2xl overflow-hidden">
            @if ($notifikasis->isEmpty())
                <p class="py-10 text-grayCustom-400 text-sm text-center">Belum ada notifikasi.</p>
            @else
                <div class="space-y-3">
                    @foreach ($notifikasis as $notifikasi)
                        <div class="flex items-start gap-3 sm:gap-4 p-4 border rounded-xl transition {{ $notifikasi->isBelumDibaca() ? 'bg-primary/5 border-primary/10' : 'bg-white border-grayCustom-100' }}">

                            <div class="flex justify-center items-center rounded-full w-10 h-10 shrink-0 {{ $notifikasi->jenisIconBgClass() }}">
                                @switch($notifikasi->jenisIcon())
                                    @case('calendar')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" />
                                            <path stroke-linecap="round" d="M16 2v4M8 2v4M3 10h18" />
                                        </svg>
                                        @break
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
                                    @case('trash')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9.5 4h5a1 1 0 011 1v2h-7V5a1 1 0 011-1z" />
                                        </svg>
                                        @break
                                @endswitch
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap justify-between items-center gap-2">
                                    <div class="flex items-center gap-2">
                                        <p class="font-semibold text-grayCustom-800 text-sm sm:text-base">{{ $notifikasi->judul }}</p>
                                        <span class="px-2 py-0.5 rounded-full font-semibold text-[10px] sm:text-xs {{ $notifikasi->jenisBadgeClass() }}">
                                            {{ $notifikasi->jenisLabel() }}
                                        </span>
                                        @if ($notifikasi->isBelumDibaca())
                                            <span class="bg-red-500 rounded-full w-2 h-2"></span>
                                        @endif
                                    </div>
                                    <span class="text-grayCustom-400 text-xs whitespace-nowrap">{{ $notifikasi->waktuRelatif() }}</span>
                                </div>

                                <p class="mt-1 text-grayCustom-600 text-sm">{{ $notifikasi->pesan }}</p>

                                @if ($notifikasi->kamar || !empty($notifikasi->data['jumlah']) || !empty($notifikasi->data['check_in']))
                                    <p class="mt-1.5 text-grayCustom-400 text-xs">
                                        @if ($notifikasi->kamar)
                                            Kamar {{ $notifikasi->kamar }}
                                        @endif
                                        @if ($notifikasi->jenis === 'tagihan' && !empty($notifikasi->data['jumlah']))
                                            &middot; Rp{{ number_format($notifikasi->data['jumlah'], 0, ',', '.') }}
                                        @endif
                                        @if ($notifikasi->jenis === 'booking' && !empty($notifikasi->data['check_in']))
                                            &middot; Check-in {{ \Illuminate\Support\Carbon::parse($notifikasi->data['check_in'])->format('d/n/Y') }}
                                        @endif
                                    </p>
                                @endif

                                @if ($notifikasi->jenis === 'hapus_kamar')
                                    @php
                                        $deleteRequest = $notifikasi->roomDeleteRequest();
                                    @endphp
                                    @if ($deleteRequest && $deleteRequest->status === 'pending')
                                        <div class="flex gap-2 mt-3">
                                            <form method="POST" action="{{ route('penghuni.room-delete-request.approve', $deleteRequest) }}">
                                                @csrf
                                                <button type="submit" onclick="setTimeout(() => this.disabled = true)"
                                                    class="bg-green-500 hover:bg-green-600 px-3 py-1.5 rounded-full font-semibold text-white text-xs transition">
                                                    Setuju
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('penghuni.room-delete-request.reject', $deleteRequest) }}">
                                                @csrf
                                                <button type="submit" onclick="setTimeout(() => this.disabled = true)"
                                                    class="bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded-full font-semibold text-white text-xs transition">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @elseif ($deleteRequest && $deleteRequest->status === 'approved')
                                        <span class="inline-flex items-center gap-1 bg-green-100 mt-3 px-3 py-1.5 rounded-full font-semibold text-green-700 text-xs">
                                            &#10003; Sudah Disetujui
                                        </span>
                                    @elseif ($deleteRequest && $deleteRequest->status === 'rejected')
                                        <span class="inline-flex items-center gap-1 bg-red-100 mt-3 px-3 py-1.5 rounded-full font-semibold text-red-700 text-xs">
                                            &#10007; Sudah Ditolak
                                        </span>
                                    @endif
                                @endif
                            </div>

                            @if ($notifikasi->isBelumDibaca())
                                <form method="POST" action="{{ route('penghuni.notifikasi.read', $notifikasi) }}" class="shrink-0">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="bg-primary/10 hover:bg-primary/20 px-3 py-1.5 rounded-full font-semibold text-primary text-xs whitespace-nowrap transition">
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

</x-app-layout>