<x-app-layout>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div x-data="adminPengaduanPage()" class="mx-auto max-w-7xl space-y-6 p-6">
        <!-- Ringkas Admin -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 text-center shadow-sm">
                <p class="text-sm font-medium text-gray-500">Total Pengaduan</p>
                <p class="mt-1 text-2xl font-bold text-[#1E3A5F]">{{ $total }}</p>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-white p-6 text-center shadow-sm">
                <p class="text-sm font-medium text-gray-500">Sedang Diproses</p>
                <p class="mt-1 text-2xl font-bold text-amber-600">{{ $sedangDiproses }}</p>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-white p-6 text-center shadow-sm">
                <p class="text-sm font-medium text-gray-500">Selesai</p>
                <p class="mt-1 text-2xl font-bold text-emerald-600">{{ $selesai }}</p>
            </div>
        </div>

        <!-- Tabel Kelola Keluhan Masuk -->
        <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
            <div class="border-b border-gray-100 p-6">
                <h2 class="text-lg font-bold text-[#1E3A5F]">Daftar Pengaduan Masuk</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50 text-xs font-semibold uppercase text-gray-500">
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
                            <tr class="transition hover:bg-gray-50/50">
                                <td class="whitespace-nowrap px-6 py-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($pengaduan->tanggal)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $pengaduan->penyewa }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $pengaduan->kamar }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $pengaduan->kategori }}</td>
                                <td class="max-w-xs truncate px-6 py-4 text-gray-700">{{ $pengaduan->deskripsi }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold"
                                        :class="statusBadgeClass('{{ $pengaduan->status }}')">
                                        {{ $pengaduan->status === 'pending' ? 'Pending' : ($pengaduan->status === 'diproses' ? 'Diproses' : 'Selesai') }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Lihat Detail --}}
                                        <button type="button" title="Lihat Detail"
                                            @click="openModal({{ Illuminate\Support\Js::from($pengaduan) }})"
                                            class="rounded-xl p-2 text-gray-400 transition hover:bg-gray-100 hover:text-[#1E3A5F]">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor" class="h-5 w-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </button>

                                        {{-- Edit Status --}}
                                        @role('admin')
                                            <button type="button" title="Edit Status"
                                                @click="openModal({{ Illuminate\Support\Js::from($pengaduan) }})"
                                                class="rounded-xl p-2 text-gray-400 transition hover:bg-gray-100 hover:text-[#1E3A5F]">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" class="h-5 w-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487a2.25 2.25 0 113.182 3.182L8.25 18.463 3 20.5l1.037-5.25L16.862 4.487z" />
                                                </svg>
                                            </button>
                                        @endrole
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-gray-400">Belum ada pengaduan keluhan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if ($pengaduans->hasPages())
                    <div class="flex items-center justify-end gap-2 border-t border-gray-100 px-6 py-4 text-xs">
                        @if (!$pengaduans->onFirstPage())
                            <a href="{{ $pengaduans->appends(request()->query())->previousPageUrl() }}"
                                class="rounded border border-gray-200 px-2 py-1 font-semibold text-gray-700 transition hover:bg-gray-100">←</a>
                        @endif

                        <span class="rounded border border-gray-200 bg-gray-50 px-2.5 py-1 font-medium text-gray-700">
                            {{ $pengaduans->currentPage() }}/{{ $pengaduans->lastPage() }}
                        </span>

                        @if ($pengaduans->hasMorePages())
                            <a href="{{ $pengaduans->appends(request()->query())->nextPageUrl() }}"
                                class="rounded border border-gray-200 px-2 py-1 font-semibold text-gray-700 transition hover:bg-gray-100">→</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        {{-- ===================== DETAIL & PILIHAN AKSI STATUS ===================== --}}
        <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
            @click.self="showModal = false">
            <div x-show="showModal" x-transition
                class="w-full max-w-lg overflow-hidden rounded-3xl bg-white p-6 shadow-2xl">

                <div class="mb-4 flex items-center justify-between border-b pb-3">
                    <h3 class="text-lg font-bold text-[#1E3A5F]">Detail Pengaduan</h3>
                    <button type="button" @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <template x-if="selected">
                    <div class="space-y-4 text-sm text-gray-700">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="block text-xs font-medium uppercase text-gray-400">Penyewa</span>
                                <p class="mt-0.5 font-semibold text-gray-900" x-text="selected.penyewa"></p>
                            </div>
                            <div>
                                <span class="block text-xs font-medium uppercase text-gray-400">Kamar</span>
                                <p class="mt-0.5 font-semibold text-gray-900" x-text="'Kamar ' + selected.kamar"></p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="block text-xs font-medium uppercase text-gray-400">Kategori</span>
                                <p class="mt-0.5 font-semibold text-gray-900" x-text="selected.kategori"></p>
                            </div>
                            <div>
                                <span class="block text-xs font-medium uppercase text-gray-400">Tanggal Masuk</span>
                                <p class="mt-0.5 font-semibold text-gray-900" x-text="formatDate(selected.tanggal)">
                                </p>
                            </div>
                        </div>

                        <div>
                            <span class="block text-xs font-medium uppercase text-gray-400">Deskripsi Masalah</span>
                            <div class="mt-1 max-h-32 overflow-y-auto break-words rounded-xl border bg-gray-50 p-3 text-gray-800"
                                x-text="selected.deskripsi"></div>
                        </div>

                        {{-- Menampilkan Foto Bukti --}}
                        <template x-if="selected.bukti">
                            <div>
                                <span class="mb-1 block text-xs font-medium uppercase text-gray-400">Foto Bukti
                                    Keluhan</span>
                                <img :src="'/storage/bukti-pengaduan/' + selected.bukti"
                                    class="h-40 w-full rounded-xl border object-cover">
                            </div>
                        </template>
                    </div>
                </template>

                {{-- Form Aksi Perubahan Status (Hanya Tampil Jika Admin) --}}
                <div class="mt-5 flex justify-end gap-2 border-t pt-4">
                    <button type="button" @click="showModal = false"
                        class="rounded-xl px-4 py-2.5 font-semibold text-gray-500 transition hover:bg-gray-100">Tutup</button>

                    @role('admin')
                        <template x-if="selected">
                            <form method="POST" :action="'/admin/pengaduan/' + selected.id + '/status'"
                                class="flex gap-2">
                                @csrf
                                @method('PATCH')

                                {{-- Tombol muncul hanya jika status pending --}}
                                <template x-if="selected.status === 'pending'">
                                    <button type="submit" name="status" value="diproses"
                                        class="rounded-xl bg-blue-600 px-4 py-2.5 font-semibold text-white transition hover:bg-blue-700">
                                        Proses Keluhan
                                    </button>
                                </template>

                                {{-- Tombol muncul jika status pending atau diproses --}}
                                <template x-if="selected.status !== 'selesai'">
                                    <button type="submit" name="status" value="selesai"
                                        class="rounded-xl bg-emerald-600 px-4 py-2.5 font-semibold text-white transition hover:bg-emerald-700">
                                        Selesaikan
                                    </button>
                                </template>
                            </form>
                        </template>
                    @endrole
                </div>

            </div>
        </div>
    </div>

    <script>
        function adminPengaduanPage() {
            return {
                showModal: false,
                selected: null,

                openModal(data) {
                    this.selected = data;
                    this.showModal = true;
                },
                statusBadgeClass(status) {
                    return {
                        pending: 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/10 ring-inset',
                        diproses: 'bg-blue-50 text-blue-700 ring-1 ring-blue-700/10 ring-inset',
                        selesai: 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/10 ring-inset'
                    } [status] ?? 'bg-gray-50 text-gray-700';
                },
                formatDate(value) {
                    if (!value) return '-';
                    const date = new Date(value);
                    return date.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });
                }
            }
        }
    </script>
</x-app-layout>
