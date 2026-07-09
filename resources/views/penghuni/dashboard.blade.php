{{-- @php session()->flash('isDashboard', true); @endphp --}}
<x-app-layout>
    <div class="space-y-6">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <!-- Kamar Saya -->
            <div class="rounded-xl bg-white p-6 shadow-sm">
                <h2 class="mb-4 text-lg font-semibold text-primary">Kamar Saya</h2>
                <div class="flex flex-col gap-4 sm:flex-row">
                    <div class="flex h-32 w-full shrink-0 items-center justify-center rounded-lg bg-gray-100 sm:w-40">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                            class="h-10 w-10 text-gray-300">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <circle cx="8.5" cy="8.5" r="1.5" />
                            <path d="m21 15-5-5L5 21" />
                        </svg>
                    </div>
                    <div class="flex-1 space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-primary">Kamar A001</span>
                            <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-700">
                                Active
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-x-2 gap-y-1 text-sm">
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

            <!-- Tagihan Bulan Ini -->
            <div class="rounded-xl bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between">
                    <h2 class="text-lg font-semibold text-primary">Tagihan Bulan Ini</h2>
                    <span class="text-sm text-gray-500">29 Juni 2026</span>
                </div>
                <div class="mt-3 flex items-center gap-3">
                    <span class="text-2xl font-bold text-primary">Rp. 1.000.000</span>
                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-700">
                        Belum Dibayar
                    </span>
                </div>
                <div class="mt-4 flex justify-between text-sm">
                    <span class="text-grayCustom-500">Tanggal Jatuh Tempo</span>
                    <span class="font-medium text-grayCustom-800">30 Juni 2026</span>
                </div>
                <button type="button"
                    class="mt-5 w-full rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-primary/90">
                    Bayar Sekarang
                </button>
            </div>
        </div>

        <!-- Riwayat Pembayaran Terakhir -->
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-lg font-semibold text-primary">Riwayat Pembayaran Terakhir</h2>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[560px] text-sm">
                    <tbody class="divide-y divide-grayCustom-100">
                        <tr>
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-grayCustom-800">Juni 2026</p>
                                <p class="text-grayCustom-500">Tagihan Bulanan</p>
                            </td>
                            <td class="py-4 pr-4">
                                <p class="font-bold text-grayCustom-800">Rp. 1.000.000</p>
                                <p class="text-grayCustom-500">30 Juni 2026</p>
                            </td>
                            <td class="py-4 text-right">
                                <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-700">
                                    Belum Lunas
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-grayCustom-800">Mei 2026</p>
                                <p class="text-grayCustom-500">Tagihan Bulanan</p>
                            </td>
                            <td class="py-4 pr-4">
                                <p class="font-bold text-grayCustom-800">Rp. 1.000.000</p>
                                <p class="text-grayCustom-500">27 Mei 2026</p>
                            </td>
                            <td class="py-4 text-right">
                                <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-700">
                                    Lunas
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-grayCustom-800">April 2026</p>
                                <p class="text-grayCustom-500">Tagihan Bulanan</p>
                            </td>
                            <td class="py-4 pr-4">
                                <p class="font-bold text-grayCustom-800">Rp. 1.000.000</p>
                                <p class="text-grayCustom-500">27 April 2026</p>
                            </td>
                            <td class="py-4 text-right">
                                <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-700">
                                    Lunas
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-4 pr-4">
                                <p class="font-semibold text-grayCustom-800">Maret 2026</p>
                                <p class="text-grayCustom-500">Tagihan Bulanan</p>
                            </td>
                            <td class="py-4 pr-4">
                                <p class="font-bold text-grayCustom-800">Rp. 1.000.000</p>
                                <p class="text-grayCustom-500">27 Maret 2026</p>
                            </td>
                            <td class="py-4 text-right">
                                <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-700">
                                    Lunas
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
