<x-app-layout>
    <div class="space-y-6 p-6">

        {{-- Pop-up Notif Terkirim Berhasil --}}
        @if (session('success'))
            <div x-data="{ open: true }" x-show="open" class="bg-emerald-50 border border-emerald-200 p-4 rounded-xl flex justify-between items-center shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="text-emerald-600 bg-emerald-100 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </span>
                    <div>
                        <h3 class="font-semibold text-emerald-800 text-sm">Berhasil Terkirim!</h3>
                        <p class="text-xs text-emerald-600">{{ session('success') }}</p>
                    </div>
                </div>
                <button @click="open = false" class="text-emerald-400 hover:text-emerald-600"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
            </div>
        @endif

        <div class="flex justify-between items-center bg-white p-6 rounded-2xl shadow-sm">
            <div>
                <h1 class="text-xl font-bold text-[#1E3A5F]">Pengaduan & Keluhan Saya</h1>
                <p class="text-xs text-gray-500 mt-1">Pantau progress penanganan masalah fasilitas kamar kamu.</p>
            </div>
            <a href="{{ route('penghuni.pengaduan.create') }}" class="bg-[#1E3A5F] hover:bg-[#1E3A5F]/90 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Buat Keluhan Baru
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 font-semibold text-xs uppercase border-b border-gray-100">
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Deskripsi Keluhan</th>
                            <th class="px-6 py-4 text-center">Status Progress</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pengaduans as $pengaduan)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ \Carbon\Carbon::parse($pengaduan->tanggal)->translatedFormat('d M Y') }}</td>
                                <td class="px-6 py-4"><span class="bg-gray-100 text-gray-700 px-2.5 py-1 rounded text-xs font-medium">{{ $pengaduan->kategori }}</span></td>
                                <td class="px-6 py-4 text-gray-700 max-w-md break-words">{{ $pengaduan->deskripsi }}</td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if($pengaduan->status === 'pending')
                                        <span class="bg-amber-50 text-amber-700 px-3 py-1 rounded-full text-xs font-semibold">Menunggu Admin</span>
                                    @elseif($pengaduan->status === 'diproses')
                                        <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">Sedang Diperbaiki</span>
                                    @else
                                        <span class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs font-semibold">Selesai Ditangani</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-12 text-gray-400">Kamu belum pernah mengajukan keluhan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
