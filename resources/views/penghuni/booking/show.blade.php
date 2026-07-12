<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">
            Detail Kamar
        </h2>
    </x-slot>

    <div class="py-10">

        <div class="max-w-6xl mx-auto px-6">

            <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

                {{-- ========================= --}}
                {{-- FOTO KAMAR --}}
                {{-- ========================= --}}
                <div class="relative bg-gray-100">

                    <img
                        src="{{ $kamar->fotoUrl() }}"
                        alt="{{ $kamar->tipe }} {{ $kamar->no_kamar }}"
                        class="w-full h-[450px] object-contain bg-gray-100">

                    <span
                        class="absolute top-5 right-5 px-4 py-2 rounded-full text-sm font-semibold text-white shadow

                        {{ $kamar->status == 'kosong'
                            ? 'bg-green-500'
                            : ($kamar->status == 'booking'
                                ? 'bg-yellow-500'
                                : 'bg-red-500') }}">

                        {{ $kamar->statusLabel() }}

                    </span>

                </div>

                {{-- ========================= --}}
                {{-- CONTENT --}}
                {{-- ========================= --}}
                <div class="p-8">

                    {{-- Judul --}}
                    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-end gap-4">

                        <div>

                            <h1 class="text-4xl font-bold text-gray-800">

                                {{ $kamar->tipe }}
                                {{ $kamar->no_kamar }}

                            </h1>

                            <p class="text-gray-500 mt-2">

                                Kamar nyaman untuk kebutuhan harian maupun bulanan.

                            </p>

                        </div>

                        <div class="text-left lg:text-right">

                            <p class="text-gray-500">

                                Harga Sewa

                            </p>

                            <h2 class="text-4xl font-bold text-[#254D70]">

                                {{ $kamar->hargaFormatted() }}

                            </h2>

                            <span class="text-gray-500">

                                / bulan

                            </span>

                        </div>

                    </div>

                    <hr class="my-8">

                    {{-- ========================= --}}
                    {{-- INFORMASI --}}
                    {{-- ========================= --}}
                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-5">

                        <div class="bg-gray-50 rounded-2xl p-5">

                            <p class="text-sm text-gray-500">

                                Nomor Kamar

                            </p>

                            <h3 class="font-bold text-xl mt-2">

                                {{ $kamar->no_kamar }}

                            </h3>

                        </div>

                        <div class="bg-gray-50 rounded-2xl p-5">

                            <p class="text-sm text-gray-500">

                                Tipe

                            </p>

                            <h3 class="font-bold text-xl mt-2">

                                {{ $kamar->tipe }}

                            </h3>

                        </div>

                        <div class="bg-gray-50 rounded-2xl p-5">

                            <p class="text-sm text-gray-500">

                                Kapasitas

                            </p>

                            <h3 class="font-bold text-xl mt-2">

                                👤 {{ $kamar->kapasitas ?: '-' }}

                            </h3>

                        </div>

                        <div class="bg-gray-50 rounded-2xl p-5">

                            <p class="text-sm text-gray-500">

                                Ukuran

                            </p>

                            <h3 class="font-bold text-xl mt-2">

                                📐 {{ $kamar->ukuran ?: '-' }}

                            </h3>

                        </div>

                    </div>

                    {{-- Kasur --}}
                    <div class="mt-5">

                        <div class="bg-gray-50 rounded-2xl p-5">

                            <p class="text-sm text-gray-500">

                                Jenis Kasur

                            </p>

                            <h3 class="font-bold text-xl mt-2">

                                🛏 {{ $kamar->kasur ?: '-' }}

                            </h3>

                        </div>

                    </div>

                    {{-- ========================= --}}
                    {{-- FASILITAS --}}
                    {{-- ========================= --}}
                    <div class="mt-10">

                        <h3 class="text-2xl font-bold text-gray-800 mb-5">

                            Fasilitas Kamar

                        </h3>

                        <div class="flex flex-wrap gap-3">

                            @forelse($kamar->fasilitasArray() as $fasilitas)

                                <span
                                    class="bg-[#EEF6FB] text-[#254D70] font-semibold px-5 py-3 rounded-full">

                                    ✓ {{ $fasilitas }}

                                </span>

                            @empty

                                <span class="italic text-gray-400">

                                    Belum ada fasilitas

                                </span>

                            @endforelse

                        </div>

                    </div>

                    {{-- ========================= --}}
                    {{-- TOMBOL --}}
                    {{-- ========================= --}}
                    <div class="flex flex-col sm:flex-row gap-4 mt-10">

                        <a
                            href="{{ route('penghuni.booking') }}"
                            class="flex-1 text-center border border-gray-300 py-3 rounded-xl font-semibold hover:bg-gray-100 transition">

                            ← Kembali

                        </a>

                        @if($kamar->status == 'kosong')

                            <a
                                href="{{ route('penghuni.booking.confirm', $kamar) }}"
                                class="flex-1 text-center bg-[#254D70] hover:bg-[#1E3D59] text-white py-3 rounded-xl font-semibold transition">

                                Booking Sekarang

                            </a>

                        @else

                            <button
                                disabled
                                class="flex-1 bg-gray-300 text-gray-600 py-3 rounded-xl font-semibold cursor-not-allowed">

                                Tidak Tersedia

                            </button>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>