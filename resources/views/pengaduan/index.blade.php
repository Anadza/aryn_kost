<x-app-layout>
    <div class="space-y-6 p-6">
        <!-- Statistik Ringkas Admin -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 text-center">
                <p class="text-sm font-medium text-gray-500">Total Pengaduan</p>
                <p class="text-2xl font-bold text-[#1E3A5F] mt-1">{{ $total }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 text-center">
                <p class="text-sm font-medium text-gray-500">Sedang Diproses</p>
                <p class="text-2xl font-bold text-amber-600 mt-1">{{ $sedangDiproses }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 text-center">
                <p class="text-sm font-medium text-gray-500">Selesai</p>
                <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $selesai }}</p>
            </div>
        </div>

        <!-- Tabel Kelola Keluhan Masuk -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-bold text-[#1E3A5F]">Daftar Pengaduan Masuk (Admin)</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 font-semibold text-xs uppercase border-b border-gray-100">
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
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ \Carbon\Carbon::parse($pengaduan->tanggal)->translatedFormat('d M Y') }}</td>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $pengaduan->penyewa }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $pengaduan->kamar }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $pengaduan->kategori }}</td>
                                <td class="px-6 py-4 text-gray-700 max-w-xs break-words">{{ $pengaduan->deskripsi }}</td>
                                <td class="px-6 py-4">
                                    @if($pengaduan->status === 'pending')
                                        <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-600/10">Pending</span>
                                    @elseif($pengaduan->status === 'diproses')
                                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-700/10">Diproses</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/10">Selesai</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if ($pengaduan->status === 'pending')
                                        <form method="POST" action="{{ route('admin.pengaduan.update-status', $pengaduan) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="diproses">
                                            <button type="submit" class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold transition">Proses</button>
                                        </form>
                                    @elseif ($pengaduan->status === 'diproses')
                                        <form method="POST" action="{{ route('admin.pengaduan.update-status', $pengaduan) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit" class="bg-emerald-100 hover:bg-emerald-200 text-emerald-700 px-3 py-1 rounded-full text-xs font-semibold transition">Selesai</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400 font-medium">No Action</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12 text-gray-400">Belum ada pengaduan keluhan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
