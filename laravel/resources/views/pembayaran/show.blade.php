@php
    $roleForRoute = auth()->user()->hasRole('admin') ? 'admin' : 'owner';
    $indexRouteName = "{$roleForRoute}.pembayaran.index";
    $updateRouteName = "{$roleForRoute}.pembayaran.update";

    $statusColor = match ($pembayaran->status_pembayaran) {
        'Lunas' => 'bg-success-50 text-success-600',
        'Menunggu Konfirmasi' => 'bg-warning-50 text-warning-600',
        default => 'bg-grayCustom-100 text-grayCustom-600',
    };
@endphp
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-primary text-xl">
            Detail Tagihan
        </h2>
    </x-slot>

    <div class="space-y-6 mx-auto px-6 pt-2 pb-8 max-w-3xl">

        <a href="{{ route($indexRouteName) }}" class="inline-flex items-center gap-1.5 text-grayCustom-500 hover:text-primary text-sm transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Data Pembayaran
        </a>

        @if (session('success'))
            <div class="flex items-start gap-3 bg-white shadow-sm p-4 border-emerald-500 border-l-4 rounded-xl">
                <p class="text-gray-700 text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <div class="space-y-5 bg-white shadow-sm p-6 rounded-2xl">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-grayCustom-500 text-sm">Nomor Tagihan</p>
                    <p class="font-bold text-primary text-lg">{{ $pembayaran->nomor_tagihan }}</p>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                    {{ $pembayaran->status_pembayaran }}
                </span>
            </div>

            <div class="gap-4 grid grid-cols-2 text-sm">
                <div>
                    <p class="text-grayCustom-500">Bulan Tagihan</p>
                    <p class="font-medium text-grayCustom-800">{{ $pembayaran->bulan_tagihan }}</p>
                </div>
                <div>
                    <p class="text-grayCustom-500">Jumlah</p>
                    <p class="font-medium text-grayCustom-800">Rp {{ number_format($pembayaran->jumlah_tagihan, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-grayCustom-500">Tanggal Jatuh Tempo</p>
                    <p class="font-medium text-grayCustom-800">{{ \Illuminate\Support\Carbon::parse($pembayaran->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-grayCustom-500">Tanggal Upload Bukti</p>
                    <p class="font-medium text-grayCustom-800">
                        {{ $pembayaran->tanggal_upload_bukti ? \Illuminate\Support\Carbon::parse($pembayaran->tanggal_upload_bukti)->translatedFormat('d F Y, H:i') : '-' }}
                    </p>
                </div>
            </div>

            <div>
                <p class="mb-2 text-grayCustom-500 text-sm">Bukti Pembayaran</p>
                @if ($pembayaran->bukti_pembayaran_path)
                    <a href="{{ asset('storage/'.$pembayaran->bukti_pembayaran_path) }}" target="_blank"
                        class="inline-flex items-center gap-1.5 font-semibold text-primary text-sm hover:underline">
                        Lihat file bukti pembayaran
                    </a>
                @else
                    <p class="text-grayCustom-400 text-sm">Penghuni belum mengunggah bukti pembayaran.</p>
                @endif
            </div>

            @can('pembayaran.edit')
                <form method="POST" action="{{ route($updateRouteName, $pembayaran->id) }}" class="pt-4 border-grayCustom-100 border-t">
                    @csrf
                    @method('PUT')

                    <label class="block mb-1 font-medium text-grayCustom-500 text-xs">Ubah Status Pembayaran</label>
                    <div class="flex gap-3">
                        <select name="status_pembayaran" required
                            class="flex-1 shadow-sm border-grayCustom-200 focus:border-primary rounded-xl focus:ring-primary text-sm">
                            <option value="Belum Dibayar" {{ $pembayaran->status_pembayaran === 'Belum Dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                            <option value="Menunggu Konfirmasi" {{ $pembayaran->status_pembayaran === 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                            <option value="Lunas" {{ $pembayaran->status_pembayaran === 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        </select>
                        <button type="submit"
                            class="bg-primary hover:bg-primary/90 px-5 py-2 rounded-xl font-semibold text-white text-sm transition">
                            Simpan
                        </button>
                    </div>
                </form>
            @endcan
        </div>
    </div>
</x-app-layout>
