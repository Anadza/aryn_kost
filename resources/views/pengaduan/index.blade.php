<x-app-layout>
    <div class="space-y-6 p-6">
        <!-- Statistik Ringkas Admin -->
        <div class="gap-4 grid grid-cols-1 sm:grid-cols-3">
            <div class="bg-white shadow-sm p-6 border border-gray-100 rounded-2xl text-center">
                <p class="font-medium text-gray-500 text-sm">Total Pengaduan</p>
                <p class="mt-1 font-bold text-[#1E3A5F] text-2xl">{{ $total }}</p>
            </div>
            <div class="bg-white shadow-sm p-6 border border-gray-100 rounded-2xl text-center">
                <p class="font-medium text-gray-500 text-sm">Sedang Diproses</p>
                <p class="mt-1 font-bold text-amber-600 text-2xl">{{ $sedangDiproses }}</p>
            </div>
            <div class="bg-white shadow-sm p-6 border border-gray-100 rounded-2xl text-center">
                <p class="font-medium text-gray-500 text-sm">Selesai</p>
                <p class="mt-1 font-bold text-emerald-600 text-2xl">{{ $selesai }}</p>
            </div>
        </div>

        <!-- Tabel Kelola Keluhan Masuk -->
        <div class="bg-white shadow-sm rounded-2xl overflow-hidden">
            <div class="p-6 border-gray-100 border-b">
                <h2 class="font-bold text-[#1E3A5F] text-lg">Daftar Pengaduan Masuk</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-gray-100 border-b font-semibold text-gray-500 text-xs uppercase">
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Penyewa</th>
                            <th class="px-6 py-4">Kamar</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Deskripsi</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pengaduans as $pengaduan)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($pengaduan->tanggal)->translatedFormat('d M Y') }}</td>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $pengaduan->penyewa }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $pengaduan->kamar }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $pengaduan->kategori }}</td>
                                <td class="px-6 py-4 max-w-xs text-gray-700 break-words">{{ $pengaduan->deskripsi }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($pengaduan->status === 'pending')
                                        <span
                                            class="inline-flex items-center bg-amber-50 px-2.5 py-1 rounded-full ring-1 ring-amber-600/10 ring-inset font-semibold text-amber-700 text-xs">Pending</span>
                                    @elseif($pengaduan->status === 'diproses')
                                        <span
                                            class="inline-flex items-center bg-blue-50 px-2.5 py-1 rounded-full ring-1 ring-blue-700/10 ring-inset font-semibold text-blue-700 text-xs">Diproses</span>
                                    @else
                                        <span
                                            class="inline-flex items-center bg-emerald-50 px-2.5 py-1 rounded-full ring-1 ring-emerald-600/10 ring-inset font-semibold text-emerald-700 text-xs">Selesai</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if ($pengaduan->status === 'pending')
                                        <form method="POST"
                                            action="{{ route('admin.pengaduan.update-status', $pengaduan) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="diproses">
                                            <button type="submit"
                                                class="bg-blue-100 hover:bg-blue-200 px-3 py-1 rounded-full font-semibold text-blue-700 text-xs transition">Proses</button>
                                        </form>
                                    @elseif ($pengaduan->status === 'diproses')
                                        <form method="POST"
                                            action="{{ route('admin.pengaduan.update-status', $pengaduan) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit"
                                                class="bg-emerald-100 hover:bg-emerald-200 px-3 py-1 rounded-full font-semibold text-emerald-700 text-xs transition">Selesai</button>
                                        </form>
                                    @else
                                        <span class="font-medium text-gray-400 text-xs">No Action</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-gray-400 text-center">Belum ada pengaduan keluhan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- ===================== PAGINATION MINIMALIS MODERN ===================== --}}
                @if ($pengaduans->hasPages())
                    <div class="flex justify-end items-center gap-2 px-6 py-4 border-gray-100 border-t text-xs">
                        @if (!$pengaduans->onFirstPage())
                            <a href="{{ $pengaduans->appends(request()->query())->previousPageUrl() }}"
                                class="hover:bg-gray-100 px-2 py-1 border border-gray-200 rounded font-semibold text-gray-700 transition">←</a>
                        @endif

                        <span class="bg-gray-50 px-2.5 py-1 border border-gray-200 rounded font-medium text-gray-700">
                            {{ $pengaduans->currentPage() }}/{{ $pengaduans->lastPage() }}
                        </span>

                        @if ($pengaduans->hasMorePages())
                            <a href="{{ $pengaduans->appends(request()->query())->nextPageUrl() }}"
                                class="hover:bg-gray-100 px-2 py-1 border border-gray-200 rounded font-semibold text-gray-700 transition">→</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
