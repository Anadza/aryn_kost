<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

    <h3 class="text-xl font-bold text-gray-800 mb-6">
        Fitur Pencarian
    </h3>

    <form action="{{ route('penghuni.booking') }}" method="GET">

        <div class="space-y-5">

            {{-- Tipe Kamar --}}
            <div>

                <label for="tipe" class="block text-sm font-semibold text-gray-700 mb-2">
                    Tipe Kamar
                </label>

                <select
                    id="tipe"
                    name="tipe"
                    class="w-full rounded-lg border-gray-300 focus:border-[#254D70] focus:ring-[#254D70]">

                    <option value="">Semua Tipe</option>

                    <option value="Standar" {{ request('tipe') == 'Standar' ? 'selected' : '' }}>
                        Standar
                    </option>

                    <option value="Deluxe" {{ request('tipe') == 'Deluxe' ? 'selected' : '' }}>
                        Deluxe
                    </option>

                    <option value="VIP" {{ request('tipe') == 'VIP' ? 'selected' : '' }}>
                        VIP
                    </option>

                </select>

            </div>

            {{-- Harga --}}
            <div>

                <label for="harga" class="block text-sm font-semibold text-gray-700 mb-2">
                    Harga / Bulan
                </label>

                <select
                    id="harga"
                    name="harga"
                    class="w-full rounded-lg border-gray-300 focus:border-[#254D70] focus:ring-[#254D70]">

                    <option value="">Semua Harga</option>

                    <option value="1000000" {{ request('harga') == '1000000' ? 'selected' : '' }}>
                        < Rp1.000.000
                    </option>

                    <option value="1500000" {{ request('harga') == '1500000' ? 'selected' : '' }}>
                        Rp1.000.000 - Rp1.500.000
                    </option>

                    <option value="1500001" {{ request('harga') == '1500001' ? 'selected' : '' }}>
                        > Rp1.500.000
                    </option>

                </select>

            </div>

            {{-- Status --}}
            <div>

                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                    Status Kamar
                </label>

                <select
                    id="status"
                    name="status"
                    class="w-full rounded-lg border-gray-300 focus:border-[#254D70] focus:ring-[#254D70]">

                    <option value="">Semua Status</option>

                    <option value="kosong" {{ request('status') == 'kosong' ? 'selected' : '' }}>
                        Kosong
                    </option>

                    <option value="booking" {{ request('status') == 'booking' ? 'selected' : '' }}>
                        Booking
                    </option>

                    <option value="terisi" {{ request('status') == 'terisi' ? 'selected' : '' }}>
                        Terisi
                    </option>

                </select>

            </div>

            {{-- Tombol --}}
            <div class="pt-2">

                <button
                    type="submit"
                    class="w-full bg-[#254D70] hover:bg-[#1f3f5c] text-white rounded-lg py-3 font-semibold transition">

                    Cari Kamar

                </button>

            </div>

        </div>

    </form>

</div>