<x-app-layout>
    <div class="space-y-6">

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
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-primary">Kamar A001</span>
                            <x-badge color="green">Active</x-badge>
                        </div>
                        <div class="gap-x-2 gap-y-1 grid grid-cols-2 text-sm">
                            <span class="text-gray-500">Check-in</span>
                            <span class="font-medium text-gray-800">30 Juli 2025</span>
                            <span class="text-gray-500">Check-out</span>
                            <span class="font-medium text-gray-800">30 Juli 2026</span>
                            <span class="text-gray-500">Tipe Kamar</span>
                            <span class="font-medium text-gray-800">Standar</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm p-6 rounded-xl">
                <div class="flex justify-between items-start">
                    <h2 class="font-semibold text-primary text-lg">Tagihan Bulan Ini</h2>
                    <span class="text-gray-500 text-sm">29 Juni 2026</span>
                </div>
                <div class="flex items-center gap-3 mt-3">
                    <span class="font-bold text-primary text-2xl">Rp. 1.000.000</span>
                    <x-badge color="red">Belum Dibayar</x-badge>
                </div>
                <div class="flex justify-between mt-4 text-sm">
                    <span class="text-gray-500">Tanggal Jatuh Tempo</span>
                    <span class="font-medium text-gray-800">30 Juni 2026</span>
                </div>
                <button type="button"
                    class="bg-primary hover:bg-primary/90 mt-5 px-4 py-2.5 rounded-lg w-full font-semibold text-white text-sm transition">
                    Bayar Sekarang
                </button>
            </div>
        </div>

        <div class="bg-white shadow-sm p-6 rounded-xl">
            <h2 class="mb-4 font-semibold text-primary text-lg">Riwayat Pembayaran Terakhir</h2>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[560px] text-sm">
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-gray-800">Juni 2026</p>
                                <p class="text-gray-500">Tagihan Bulanan</p>
                            </td>
                            <td class="py-4 pr-4">
                                <p class="font-bold text-gray-800">Rp. 1.000.000</p>
                                <p class="text-gray-500">30 Juni 2026</p>
                            </td>
                            <td class="py-4 text-right">
                                <x-badge color="red">Belum Lunas</x-badge>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-gray-800">Mei 2026</p>
                                <p class="text-gray-500">Tagihan Bulanan</p>
                            </td>
                            <td class="py-4 pr-4">
                                <p class="font-bold text-gray-800">Rp. 1.000.000</p>
                                <p class="text-gray-500">27 Mei 2026</p>
                            </td>
                            <td class="py-4 text-right">
                                <x-badge color="green">Lunas</x-badge>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-gray-800">April 2026</p>
                                <p class="text-gray-500">Tagihan Bulanan</p>
                            </td>
                            <td class="py-4 pr-4">
                                <p class="font-bold text-gray-800">Rp. 1.000.000</p>
                                <p class="text-gray-500">27 April 2026</p>
                            </td>
                            <td class="py-4 text-right">
                                <x-badge color="green">Lunas</x-badge>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-gray-800">Maret 2026</p>
                                <p class="text-gray-500">Tagihan Bulanan</p>
                            </td>
                            <td class="py-4 pr-4">
                                <p class="font-bold text-gray-800">Rp. 1.000.000</p>
                                <p class="text-gray-500">27 Maret 2026</p>
                            </td>
                            <td class="py-4 text-right">
                                <x-badge color="green">Lunas</x-badge>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
