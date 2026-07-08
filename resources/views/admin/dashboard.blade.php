@php session()->flash('isDashboard', true); @endphp
<x-app-layout>
    <div class="space-y-6">

        <div class="gap-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white shadow-sm p-6 rounded-xl min-w-0 overflow-hidden">
                <p class="text-grayCustom-500 text-sm">Total Kamar</p>
                <p class="mt-2 font-bold text-primary text-2xl sm:text-3xl">30</p>
            </div>
            <div class="bg-white shadow-sm p-6 rounded-xl min-w-0 overflow-hidden">
                <p class="text-grayCustom-500 text-sm">Penyewa Aktif</p>
                <p class="mt-2 font-bold text-primary text-2xl sm:text-3xl">28</p>
            </div>
            <div class="bg-white shadow-sm p-6 rounded-xl min-w-0 overflow-hidden">
                <p class="text-grayCustom-500 text-sm">Pendapatan Bulan ini</p>
                <p class="mt-2 font-bold text-primary text-lg sm:text-2xl lg:text-2xl break-words">Rp25.000.000</p>
            </div>
            <div class="bg-white shadow-sm p-6 rounded-xl min-w-0 overflow-hidden">
                <p class="text-grayCustom-500 text-sm">Pembayaran Tertunda</p>
                <p class="mt-2 font-bold text-primary text-2xl sm:text-3xl">3</p>
            </div>
        </div>

        <div class="gap-4 grid grid-cols-1 lg:grid-cols-3">
            <!-- Grafik Pemasukan -->
            <div class="lg:col-span-2 bg-white shadow-sm p-6 rounded-xl min-w-0 overflow-hidden">
                <h2 class="mb-4 font-semibold text-primary text-lg">Grafik Pemasukan Bulanan</h2>
                <div class="flex justify-center items-center bg-grayCustom-50 rounded-lg h-64 md:h-80">
                    {{-- TODO: pasang komponen chart (mis. Chart.js) di sini --}}
                    <span class="text-grayCustom-400 text-sm">Placeholder grafik pemasukan</span>
                </div>
            </div>

            <div class="bg-white shadow-sm p-6 rounded-xl min-w-0 overflow-hidden">
                <h2 class="mb-4 font-semibold text-primary text-lg">Data Pengaduan</h2>
                <div class="space-y-3 max-h-80 overflow-y-auto">
                    <div class="p-3 border border-grayCustom-100 rounded-lg">
                        <x-badge color="blue">Diproses</x-badge>
                        <p class="mt-2 text-grayCustom-600 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Etiam suscipit lacus vitae.</p>
                    </div>
                    <div class="p-3 border border-grayCustom-100 rounded-lg">
                        <x-badge color="success">Selesai</x-badge>
                        <p class="mt-2 text-grayCustom-600 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            Etiam suscipit lacus vitae.</p>
                    </div>
                    <div class="p-3 border border-gray-100 rounded-lg">
                        <x-badge color="yellow">Pending</x-badge>
                        <p class="mt-2 text-grayCustom-600 text-sm">Lorem ipsum dolor sit amet.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
