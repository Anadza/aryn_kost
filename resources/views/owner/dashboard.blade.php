{{-- @php session()->flash('isDashboard', true); @endphp --}}
<x-app-layout>
    <div class="space-y-6">

        <div class="gap-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white shadow-sm p-6 rounded-xl min-w-0 overflow-hidden">
                <p class="text-grayCustom-500 text-sm">Total Kamar</p>
                <p class="mt-2 font-bold text-primary text-2xl sm:text-3xl">{{ $totalKamar }}</p>
            </div>
            <div class="bg-white shadow-sm p-6 rounded-xl min-w-0 overflow-hidden">
                <p class="text-grayCustom-500 text-sm">Penyewa Aktif</p>
                <p class="mt-2 font-bold text-primary text-2xl sm:text-3xl">{{ $penyewaAktif }}</p>
            </div>
            <div class="bg-white shadow-sm p-6 rounded-xl min-w-0 overflow-hidden">
                <p class="text-grayCustom-500 text-sm">Pendapatan Bulan ini</p>
                <p class="mt-2 font-bold text-primary text-lg sm:text-2xl lg:text-2xl break-words">Rp{{ number_format($pendapatanBulanIni, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white shadow-sm p-6 rounded-xl min-w-0 overflow-hidden">
                <p class="text-grayCustom-500 text-sm">Pembayaran Tertunda</p>
                <p class="mt-2 font-bold text-primary text-2xl sm:text-3xl">{{ $pembayaranTertunda }}</p>
            </div>
        </div>

        <div class="gap-4 grid grid-cols-1 lg:grid-cols-3">
            <!-- Grafik Pemasukan -->
            <div class="lg:col-span-2 bg-white shadow-sm p-6 rounded-xl min-w-0 overflow-hidden">
                <h2 class="mb-4 font-semibold text-primary text-lg">Grafik Pemasukan Bulanan</h2>
                @if ($grafikPemasukan->isEmpty())
                    <div class="flex justify-center items-center bg-grayCustom-50 rounded-lg h-64 md:h-80">
                        <span class="text-grayCustom-400 text-sm">Belum ada pemasukan (tagihan lunas) yang tercatat.</span>
                    </div>
                @else
                    @php $maxPemasukan = max($grafikPemasukan->max(), 1); @endphp
                    <div class="flex justify-between items-end gap-3 bg-grayCustom-50 p-4 rounded-lg h-64 md:h-80">
                        @foreach ($grafikPemasukan as $bulan => $total)
                            <div class="flex flex-col flex-1 justify-end items-center gap-2 h-full">
                                <span class="font-semibold text-primary text-xs">Rp{{ number_format($total, 0, ',', '.') }}</span>
                                <div class="bg-primary/80 rounded-t-md w-full" style="height: {{ max(($total / $maxPemasukan) * 100, 4) }}%;"></div>
                                <span class="text-grayCustom-500 text-xs">{{ $bulan }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="bg-white shadow-sm p-6 rounded-xl min-w-0 overflow-hidden">
                <h2 class="mb-4 font-semibold text-primary text-lg">Data Pengaduan</h2>
                <div class="space-y-3 max-h-80 overflow-y-auto">
                    @forelse ($pengaduanTerbaru as $pengaduan)
                        <div class="p-3 border border-grayCustom-100 rounded-lg">
                            <x-badge :color="match ($pengaduan->status) {
                                'pending' => 'yellow',
                                'diproses' => 'blue',
                                'selesai' => 'green',
                                default => 'gray',
                            }">{{ $pengaduan->statusLabel() }}</x-badge>
                            <p class="mt-2 text-grayCustom-600 text-sm">
                                <span class="font-medium text-grayCustom-800">{{ $pengaduan->penyewa }}</span>
                                &middot; Kamar {{ $pengaduan->kamar }} &middot; {{ $pengaduan->kategori }}
                            </p>
                        </div>
                    @empty
                        <p class="text-grayCustom-400 text-sm">Belum ada data pengaduan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
