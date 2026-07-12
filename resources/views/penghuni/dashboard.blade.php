{{-- @php session()->flash('isDashboard', true); @endphp --}}
<x-app-layout>
    <div class="space-y-6">

        <!-- ================= MENU PINTASAN AKSES (QUICK LINKS) ================= -->
        <div class="bg-white shadow-sm p-6 rounded-xl">
            <h2 class="mb-4 font-semibold text-primary text-lg">Menu Utama Penghuni</h2>
            <div class="gap-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">

                <!-- Tombol ke Halaman Indeks/Riwayat Pengaduan -->
                <a href="{{ route('penghuni.pengaduan.index') }}"
                    class="group flex items-center gap-4 bg-gray-50/50 hover:bg-gray-50 p-4 border border-gray-100 rounded-xl transition">
                    <div
                        class="flex justify-center items-center bg-orange-100 rounded-lg w-12 h-12 text-orange-600 group-hover:scale-105 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">Pengaduan & Keluhan</p>
                        <p class="text-gray-500 text-xs">Lihat riwayat status pengaduan Anda</p>
                    </div>
                </a>

                <!-- Tombol Langsung Buat Keluhan Baru -->
                <a href="{{ route('penghuni.pengaduan.create') }}"
                    class="group flex items-center gap-4 bg-gray-50/50 hover:bg-gray-50 p-4 border border-gray-100 rounded-xl transition">
                    <div
                        class="flex justify-center items-center bg-red-100 rounded-lg w-12 h-12 text-red-600 group-hover:scale-105 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">Buat Keluhan Baru</p>
                        <p class="text-gray-500 text-xs">Laporkan masalah fasilitas atau kamar</p>
                    </div>
                </a>

            </div>
        </div>
        <!-- ===================================================================== -->

        <div class="gap-4 grid grid-cols-1 md:grid-cols-2">
            <!-- Kamar Saya -->
            <div class="bg-white shadow-sm p-6 rounded-xl">
                <h2 class="mb-4 font-semibold text-primary text-lg">Kamar Saya</h2>
                <div class="flex sm:flex-row flex-col gap-4">
                    <div class="flex justify-center items-center bg-gray-100 rounded-lg w-full sm:w-40 h-32 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                            class="w-10 h-10 text-gray-300">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <circle cx="8.5" cy="8.5" r="1.5" />
                            <path d="m21 15-5-5L5 21" />
                        </svg>
                    </div>
                    <div class="flex-1 space-y-2">
                        @if ($penghuniData)
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-primary">Kamar {{ $penghuniData->nomor_kamar }}</span>
                                <span
                                    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold
                                    {{ $penghuniData->status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $penghuniData->status }}
                                </span>
                            </div>
                            <div class="gap-x-2 gap-y-1 grid grid-cols-2 text-sm">
                                <span class="text-gray-500">Check-in</span>
                                <span
                                    class="font-medium text-gray-800">{{ \Illuminate\Support\Carbon::parse($penghuniData->check_in)->translatedFormat('d F Y') }}</span>
                                <span class="text-gray-500">Tipe Kamar</span>
                                <span class="font-medium text-gray-800">{{ $kamarSaya->tipe ?? '-' }}</span>
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">Data kamar kamu belum terhubung. Hubungi admin kos untuk
                                memastikan data penghuni sudah sesuai.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tagihan Bulan Ini -->
            <div class="bg-white shadow-sm p-6 rounded-xl">
                <div class="flex justify-between items-start">
                    <h2 class="font-semibold text-primary text-lg">Tagihan Bulan Ini</h2>
                    @if ($tagihanAktif)
                        <span class="text-gray-500 text-sm">{{ $tagihanAktif->bulan_tagihan }}</span>
                    @endif
                </div>
                @if ($tagihanAktif)
                    @php
                        $statusColor = match ($tagihanAktif->status_pembayaran) {
                            'Lunas' => 'bg-green-100 text-green-700',
                            'Menunggu Konfirmasi' => 'bg-yellow-100 text-yellow-700',
                            default => 'bg-red-100 text-red-700',
                        };
                    @endphp
                    <div class="flex items-center gap-3 mt-3">
                        <span class="font-bold text-primary text-2xl">Rp.
                            {{ number_format($tagihanAktif->jumlah_tagihan, 0, ',', '.') }}</span>
                        <span
                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $statusColor }}">
                            {{ $tagihanAktif->status_pembayaran }}
                        </span>
                    </div>
                    <div class="flex justify-between mt-4 text-sm">
                        <span class="text-grayCustom-500">Tanggal Jatuh Tempo</span>
                        <span
                            class="font-medium text-grayCustom-800">{{ \Illuminate\Support\Carbon::parse($tagihanAktif->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}</span>
                    </div>

                    @if ($tagihanAktif->status_pembayaran === 'Belum Dibayar')
                        <a href="{{ route('penghuni.pembayaran.upload') }}"
                            class="block bg-primary hover:bg-primary/90 mt-5 px-4 py-2.5 rounded-lg w-full font-semibold text-white text-sm text-center transition">
                            Bayar Sekarang
                        </a>
                    @else
                        <a href="{{ route('penghuni.pembayaran.upload') }}"
                            class="block hover:bg-primary/5 mt-5 px-4 py-2.5 border border-primary rounded-lg w-full font-semibold text-primary text-sm text-center transition">
                            Lihat Detail
                        </a>
                    @endif
                @else
                    <p class="mt-4 text-gray-500 text-sm">Belum ada tagihan yang tercatat.</p>
                @endif
            </div>
        </div>

        <!-- Riwayat Pembayaran Terakhir -->
        <div class="bg-white shadow-sm p-6 rounded-xl">
            <h2 class="mb-4 font-semibold text-primary text-lg">Riwayat Pembayaran Terakhir</h2>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[560px] text-sm">
                    <tbody class="divide-y divide-grayCustom-100">
                        @forelse ($riwayatPembayaran as $tagihan)
                            @php
                                $statusColor = match ($tagihan->status_pembayaran) {
                                    'Lunas' => 'bg-green-100 text-green-700',
                                    'Menunggu Konfirmasi' => 'bg-yellow-100 text-yellow-700',
                                    default => 'bg-red-100 text-red-700',
                                };
                            @endphp
                            <tr>
                                <td class="py-4 pr-4">
                                    <p class="font-semibold text-grayCustom-800">{{ $tagihan->bulan_tagihan }}</p>
                                    <p class="text-grayCustom-500">Tagihan Bulanan</p>
                                </td>
                                <td class="py-4 pr-4">
                                    <p class="font-bold text-grayCustom-800">Rp.
                                        {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}</p>
                                    <p class="text-grayCustom-500">
                                        {{ \Illuminate\Support\Carbon::parse($tagihan->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}
                                    </p>
                                </td>
                                <td class="py-4 text-right">
                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $statusColor }}">
                                        {{ $tagihan->status_pembayaran }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-grayCustom-400 text-center">Belum ada riwayat
                                    pembayaran lain.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ===================== PAGINATION ===================== --}}
            @if ($riwayatPembayaran->hasPages())
                <div class="flex justify-end items-center gap-2 mt-4 pt-4 border-grayCustom-100 border-t text-xs">

                    {{-- Tombol Sebelumnya --}}
                    @if (!$riwayatPembayaran->onFirstPage())
                        <a href="{{ $riwayatPembayaran->appends(request()->query())->previousPageUrl() }}"
                            class="hover:bg-gray-100 px-2 py-1 border border-grayCustom-200 rounded text-grayCustom-600 transition">
                            ←
                        </a>
                    @endif

                    {{-- Info Halaman --}}
                    <span class="font-medium text-grayCustom-600">
                        {{ $riwayatPembayaran->currentPage() }}/{{ $riwayatPembayaran->lastPage() }}
                    </span>

                    {{-- Tombol Selanjutnya --}}
                    @if ($riwayatPembayaran->hasMorePages())
                        <a href="{{ $riwayatPembayaran->appends(request()->query())->nextPageUrl() }}"
                            class="hover:bg-gray-100 px-2 py-1 border border-grayCustom-200 rounded text-grayCustom-600 transition">
                            →
                        </a>
                    @endif

                </div>
            @endif
        </div>

    </div>
</x-app-layout>
