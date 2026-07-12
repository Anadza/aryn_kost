<x-app-layout>
    <div class="space-y-6 p-6">

        {{-- Pop-up Notif Terkirim Berhasil --}}
        @if (session('success'))
            <div x-data="{ open: true }" x-show="open" class="flex justify-between items-center bg-emerald-50 shadow-sm p-4 border border-emerald-200 rounded-xl">
                <div class="flex items-center gap-3">
                    <span class="bg-emerald-100 p-2 rounded-lg text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </span>
                    <div>
                        <h3 class="font-semibold text-emerald-800 text-sm">Berhasil Terkirim!</h3>
                        <p class="text-emerald-600 text-xs">{{ session('success') }}</p>
                    </div>
                </div>
                <button @click="open = false" class="text-emerald-400 hover:text-emerald-600"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
            </div>
        @endif

        <div class="flex justify-between items-center bg-white shadow-sm p-6 rounded-2xl">
            <div>
                <h1 class="font-bold text-[#1E3A5F] text-xl">Pengaduan & Keluhan Saya</h1>
                <p class="mt-1 text-gray-500 text-xs">Pantau progress penanganan masalah fasilitas kamar kamu.</p>
            </div>
            <a href="{{ route('penghuni.pengaduan.create') }}" class="flex items-center gap-2 bg-[#1E3A5F] hover:bg-[#1E3A5F]/90 px-4 py-2.5 rounded-xl font-semibold text-white text-sm transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Buat Keluhan Baru
            </a>
        </div>

        <div class="bg-white shadow-sm rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-gray-100 border-b font-semibold text-gray-500 text-xs uppercase">
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Deskripsi Keluhan</th>
                            <th class="px-6 py-4 text-center">Status Progress</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pengaduans as $pengaduan)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap">{{ \Carbon\Carbon::parse($pengaduan->tanggal)->translatedFormat('d M Y') }}</td>
                                <td class="px-6 py-4"><span class="bg-gray-100 px-2.5 py-1 rounded font-medium text-gray-700 text-xs">{{ $pengaduan->kategori }}</span></td>
                                <td class="px-6 py-4 max-w-md text-gray-700 break-words">{{ $pengaduan->deskripsi }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if($pengaduan->status === 'pending')
                                        <span class="bg-amber-50 px-3 py-1 rounded-full font-semibold text-amber-700 text-xs">Menunggu Admin</span>
                                    @elseif($pengaduan->status === 'diproses')
                                        <span class="bg-blue-50 px-3 py-1 rounded-full font-semibold text-blue-700 text-xs">Sedang Diperbaiki</span>
                                    @else
                                        <span class="bg-emerald-50 px-3 py-1 rounded-full font-semibold text-emerald-700 text-xs">Selesai Ditangani</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-gray-400 text-center">Kamu belum pernah mengajukan keluhan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>

    <div class="flex items-center gap-2">
        {{-- Tombol Sebelumnya --}}
        @if (!$pengaduans->onFirstPage())
            <a href="{{ $pengaduans->previousPageUrl() }}"
               class="hover:bg-gray-100 px-3 py-1.5 border border-gray-200 rounded-lg text-gray-600 transition">
                ← Sebelumnya
            </a>
        @endif

        {{-- Tombol Selanjutnya --}}
        @if ($pengaduans->hasMorePages())
            <a href="{{ $pengaduans->nextPageUrl() }}"
               class="hover:bg-gray-100 px-3 py-1.5 border border-gray-200 rounded-lg text-gray-600 transition">
                Selanjutnya →
            </a>
        @endif
    </div>
</div>
            </div>
        </div>
    </div>
</x-app-layout>
