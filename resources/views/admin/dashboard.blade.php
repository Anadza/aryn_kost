{{-- @php session()->flash('isDashboard', true); @endphp --}}
<x-app-layout>
    <div class="space-y-6">

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
            <div class="min-w-0 overflow-hidden rounded-xl bg-white p-6 shadow-sm">
                <p class="text-sm text-grayCustom-500">Total Kamar</p>
                <p class="mt-2 text-2xl font-bold text-primary sm:text-3xl">30</p>
            </div>
            <div class="min-w-0 overflow-hidden rounded-xl bg-white p-6 shadow-sm">
                <p class="text-sm text-grayCustom-500">Penyewa Aktif</p>
                <p class="mt-2 text-2xl font-bold text-primary sm:text-3xl">28</p>
            </div>
            <div class="min-w-0 overflow-hidden rounded-xl bg-white p-6 shadow-sm">
                <p class="text-sm text-grayCustom-500">Pendapatan Bulan ini</p>
                <p class="mt-2 break-words text-lg font-bold text-primary sm:text-2xl lg:text-2xl">Rp25.000.000</p>
            </div>
            <div class="min-w-0 overflow-hidden rounded-xl bg-white p-6 shadow-sm">
                <p class="text-sm text-grayCustom-500">Pembayaran Tertunda</p>
                <p class="mt-2 text-2xl font-bold text-primary sm:text-3xl">3</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
            <!-- Grafik Pemasukan -->
            <div class="min-w-0 overflow-hidden rounded-xl bg-white p-6 shadow-sm lg:col-span-2">
                <h2 class="mb-4 text-lg font-semibold text-primary">Grafik Pemasukan Bulanan</h2>
                <div class="flex h-64 items-center justify-center rounded-lg bg-grayCustom-50 md:h-80">
                    {{-- TODO: pasang komponen chart (mis. Chart.js) di sini --}}
                    <span class="text-sm text-grayCustom-400">Placeholder grafik pemasukan</span>
                </div>
            </div>

            <div class="min-w-0 overflow-hidden rounded-xl bg-white p-6 shadow-sm">
                <h2 class="mb-4 text-lg font-semibold text-primary">Data Pengaduan</h2>
                <div class="max-h-80 space-y-3 overflow-y-auto">
                    <div class="rounded-lg border border-grayCustom-100 p-3">
                        <x-badge color="blue">Diproses</x-badge>
                        <p class="mt-2 text-sm text-grayCustom-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Etiam suscipit lacus vitae.</p>
                    </div>
                    <div class="rounded-lg border border-grayCustom-100 p-3">
                        <x-badge color="success">Selesai</x-badge>
                        <p class="mt-2 text-sm text-grayCustom-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Etiam suscipit lacus vitae.</p>
                    </div>
                    <div class="rounded-lg border border-gray-100 p-3">
                        <x-badge color="yellow">Pending</x-badge>
                        <p class="mt-2 text-sm text-grayCustom-600">Lorem ipsum dolor sit amet.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
