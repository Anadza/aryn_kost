<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-white">
            Konfirmasi Booking
        </h2>
    </x-slot>

    <div class="py-10">

        <div class="max-w-6xl mx-auto px-6">

            <div class="grid lg:grid-cols-3 gap-8">

                {{-- ========================= --}}
                {{-- Informasi Kamar --}}
                {{-- ========================= --}}
                <div class="lg:col-span-1">

                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                        <img
                            src="{{ $kamar->fotoUrl() }}"
                            alt="{{ $kamar->tipe }} {{ $kamar->no_kamar }}"
                            class="w-full h-56 object-cover">

                        <div class="p-6">

                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white
                                {{ $kamar->status == 'kosong'
                                    ? 'bg-green-500'
                                    : ($kamar->status == 'booking'
                                        ? 'bg-yellow-500'
                                        : 'bg-red-500') }}">

                                {{ $kamar->statusLabel() }}

                            </span>

                            <h2 class="text-2xl font-bold text-gray-800 mt-4">

                                {{ $kamar->tipe }}
                                {{ $kamar->no_kamar }}

                            </h2>

                            <p class="text-3xl font-bold text-[#254D70] mt-4">

                                {{ $kamar->hargaFormatted() }}

                                <span class="text-base text-gray-500 font-normal">

                                    / bulan

                                </span>

                            </p>

                            <hr class="my-6">

                            <div class="space-y-3 text-sm">

                                <div class="flex justify-between">

                                    <span class="text-gray-500">Kapasitas</span>

                                    <span class="font-semibold">

                                        {{ $kamar->kapasitas }}

                                    </span>

                                </div>

                                <div class="flex justify-between">

                                    <span class="text-gray-500">Ukuran</span>

                                    <span class="font-semibold">

                                        {{ $kamar->ukuran }}

                                    </span>

                                </div>

                                <div class="flex justify-between">

                                    <span class="text-gray-500">Kasur</span>

                                    <span class="font-semibold">

                                        {{ $kamar->kasur }}

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- ========================= --}}
                {{-- Form Booking --}}
                {{-- ========================= --}}
                <div class="lg:col-span-2">

                    <div class="bg-white rounded-2xl shadow-sm p-8">

                        <h3 class="text-2xl font-bold text-gray-800 mb-8">

                            Form Booking

                        </h3>

                        {{-- Nanti action akan diarahkan ke proses simpan booking --}}
                        <form action="#" method="POST">

                            @csrf

                            {{-- Check In --}}
                            <div class="mb-6">

                                <label class="block font-semibold mb-2">

                                    Tanggal Check In

                                </label>

                                <input
                                    type="date"
                                    name="check_in"
                                    class="w-full rounded-lg border-gray-300 focus:border-[#254D70] focus:ring-[#254D70]">

                            </div>

                            {{-- Durasi --}}
                            <div class="mb-6">

                                <label class="block font-semibold mb-2">

                                    Durasi Sewa

                                </label>

                                <select
                                    name="durasi"
                                    class="w-full rounded-lg border-gray-300 focus:border-[#254D70] focus:ring-[#254D70]">

                                    <option value="">Pilih Durasi</option>

                                    <option value="1">1 Bulan</option>
                                    <option value="3">3 Bulan</option>
                                    <option value="6">6 Bulan</option>
                                    <option value="12">12 Bulan</option>

                                </select>

                            </div>

                            {{-- Catatan --}}
                            <div class="mb-8">

                                <label class="block font-semibold mb-2">

                                    Catatan (Opsional)

                                </label>

                                <textarea
                                    rows="5"
                                    name="catatan"
                                    placeholder="Tambahkan catatan jika diperlukan..."
                                    class="w-full rounded-lg border-gray-300 focus:border-[#254D70] focus:ring-[#254D70]"></textarea>

                            </div>

                            {{-- Ringkasan --}}
                            <div class="bg-gray-50 rounded-xl p-5 mb-8">

                                <h4 class="font-bold mb-4">

                                    Ringkasan Booking

                                </h4>

                                <div class="space-y-3">

                                    <div class="flex justify-between">

                                        <span>Nomor Kamar</span>

                                        <strong>

                                            {{ $kamar->no_kamar }}

                                        </strong>

                                    </div>

                                    <div class="flex justify-between">

                                        <span>Tipe</span>

                                        <strong>

                                            {{ $kamar->tipe }}

                                        </strong>

                                    </div>

                                    <div class="flex justify-between">

                                        <span>Harga / Bulan</span>

                                        <strong class="text-[#254D70]">

                                            {{ $kamar->hargaFormatted() }}

                                        </strong>

                                    </div>

                                </div>

                            </div>

                            {{-- Tombol --}}
                            <div class="flex justify-end gap-4">

                                <a
                                    href="{{ route('penghuni.booking.show', $kamar) }}"
                                    class="px-6 py-3 rounded-lg border border-gray-300 hover:bg-gray-100 transition">

                                    Kembali

                                </a>

                                <button
                                    type="submit"
                                    class="px-8 py-3 rounded-lg bg-[#254D70] hover:bg-[#1D3E5A] text-white font-semibold transition">

                                    Konfirmasi Booking

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>