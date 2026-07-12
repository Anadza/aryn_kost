<div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow hover:shadow-xl transition duration-300">

    {{-- Foto --}}
    <div class="relative">

        <img
            src="{{ $kamar->fotoUrl() }}"
            alt="{{ $kamar->tipe }} {{ $kamar->no_kamar }}"
            class="w-full h-48 object-cover">

        <span
            class="absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-semibold text-white
            {{ $kamar->status == 'kosong'
                ? 'bg-green-500'
                : ($kamar->status == 'booking'
                    ? 'bg-yellow-500'
                    : 'bg-red-500') }}">

            {{ $kamar->statusLabel() }}

        </span>

    </div>

    {{-- Isi --}}
    <div class="p-5">

        <h3 class="text-xl font-bold text-gray-800">

            {{ $kamar->tipe }} {{ $kamar->no_kamar }}

        </h3>

        {{-- Informasi --}}
        <div class="flex items-center gap-5 mt-4 text-sm text-gray-500">

            <span>
                👤 {{ $kamar->kapasitas ?? '-' }}
            </span>

            <span>
                📐 {{ $kamar->ukuran ?? '-' }}
            </span>

            <span>
                🛏 {{ $kamar->kasur ?? '-' }}
            </span>

        </div>

        {{-- Fasilitas --}}
        <div class="flex flex-wrap gap-2 mt-5">

            @forelse($kamar->fasilitasArray() as $fasilitas)

                <span class="bg-gray-100 text-gray-700 text-xs px-3 py-1 rounded-full">

                    {{ $fasilitas }}

                </span>

            @empty

                <span class="text-xs italic text-gray-400">

                    Belum ada fasilitas

                </span>

            @endforelse

        </div>

        {{-- Harga --}}
        <div class="mt-6">

            <p class="text-sm text-gray-500">

                Harga

            </p>

            <h3 class="text-3xl font-bold text-[#254D70]">

                {{ $kamar->hargaFormatted() }}

            </h3>

            <span class="text-sm text-gray-500">

                / bulan

            </span>

        </div>

        {{-- Tombol --}}
        <div class="mt-6">

            @if($kamar->status == 'kosong')

                <a
                    href="{{ route('penghuni.booking.show', $kamar) }}"
                    class="block w-full text-center bg-[#254D70] hover:bg-[#1D3E5A] text-white py-2.5 rounded-lg font-semibold transition">

                    Pesan Sekarang

                </a>

            @else

                <button
                    disabled
                    class="block w-full bg-gray-300 text-gray-600 py-2.5 rounded-lg cursor-not-allowed font-semibold">

                    Tidak Tersedia

                </button>

            @endif

        </div>

    </div>

</div>