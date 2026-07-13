<x-app-layout>
    {{-- CSS untuk menyembunyikan elemen Alpine sebelum dimuat --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="relative mx-auto max-w-7xl space-y-6 p-6">

        {{-- ===================== NOTIFIKASI TOAST MELAYANG (SAMA SEPERTI KAMAR) ===================== --}}
        @if (session('success'))
            <div class="pointer-events-none fixed right-5 top-5 z-50 w-full max-w-sm">
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-cloak
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2 sm:translate-y-0 sm:translate-x-2"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="pointer-events-auto flex items-start gap-3 rounded-xl border-l-4 border-emerald-500 bg-white p-4 shadow-xl">
                    <div class="shrink-0 text-emerald-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-900">Berhasil Terkirim!</p>
                        <p class="mt-0.5 text-xs text-gray-500">{{ session('success') }}</p>
                    </div>
                    <button type="button" @click="show = false" class="shrink-0 text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        {{-- Header Panel --}}
        <div class="flex items-center justify-between rounded-2xl bg-white p-6 shadow-sm">
            <div>
                <h1 class="text-xl font-bold text-[#1E3A5F]">Pengaduan & Keluhan Saya</h1>
                <p class="mt-1 text-xs text-gray-500">Pantau progress penanganan masalah fasilitas kamar kamu.</p>
            </div>
            <a href="{{ route('penghuni.pengaduan.create') }}"
                class="flex items-center gap-2 rounded-xl bg-[#1E3A5F] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#1E3A5F]/90">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Buat Keluhan Baru
            </a>
        </div>

        {{-- Container Tabel --}}
        <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50 text-xs font-semibold uppercase text-gray-500">
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Deskripsi Keluhan</th>
                            <th class="px-6 py-4 text-center">Status Progress</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pengaduans as $pengaduan)
                            <tr class="transition hover:bg-gray-50/50">
                                <td class="whitespace-nowrap px-6 py-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($pengaduan->tanggal)->translatedFormat('d M Y') }}</td>
                                <td class="px-6 py-4"><span
                                        class="rounded bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700">{{ $pengaduan->kategori }}</span>
                                </td>
                                <td class="max-w-md break-words px-6 py-4 text-gray-700">{{ $pengaduan->deskripsi }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    @if ($pengaduan->status === 'pending')
                                        <span
                                            class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">Menunggu
                                            Admin</span>
                                    @elseif($pengaduan->status === 'diproses')
                                        <span
                                            class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">Sedang
                                            Diperbaiki</span>
                                    @else
                                        <span
                                            class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Selesai
                                            Ditangani</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-gray-400">Kamu belum pernah mengajukan
                                    keluhan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($pengaduans->hasPages())
                <div class="mt-4 flex items-center justify-end gap-2 border-t border-gray-100 pt-4 text-xs">
                    @if (!$pengaduans->onFirstPage())
                        <a href="{{ $pengaduans->previousPageUrl() }}"
                            class="rounded-lg border border-gray-200 px-3 py-1.5 text-gray-600 transition hover:bg-gray-100">
                            ← Sebelumnya
                        </a>
                    @endif

                    <span class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-1.5 font-medium text-gray-700">
                        {{ $pengaduans->currentPage() }}/{{ $pengaduans->lastPage() }}
                    </span>

                    @if ($pengaduans->hasMorePages())
                        <a href="{{ $pengaduans->nextPageUrl() }}"
                            class="rounded-lg border border-gray-200 px-3 py-1.5 text-gray-600 transition hover:bg-gray-100">
                            Selanjutnya →
                        </a>
                    @endif
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
