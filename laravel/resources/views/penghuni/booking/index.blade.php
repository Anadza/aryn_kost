<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <h2 class="text-2xl font-bold text-white">
                Booking Kamar
            </h2>

            <a href="#"
                class="bg-white text-[#1E4363] border border-gray-200 px-5 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">

                Lihat Booking Saya →

            </a>

        </div>
    </x-slot>

    <div class="py-10">

        <div class="max-w-7xl mx-auto px-6">

            <div class="grid grid-cols-12 gap-6">

                {{-- Sidebar --}}
                <div class="col-span-12 lg:col-span-3">

                    @include('penghuni.booking.filter')

                </div>

                {{-- Daftar Kamar --}}
                <div class="col-span-12 lg:col-span-9">

                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

                        {{-- Header --}}
                        <div class="flex items-center justify-between mb-6">

                            <div>

                                <h3 class="text-xl font-bold text-gray-800">
                                    Daftar Kamar
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">

                                    Menampilkan
                                    <span class="font-semibold">
                                        {{ $kamars->total() }}
                                    </span>
                                    kamar

                                </p>

                            </div>

                        </div>

                        {{-- Card Kamar --}}
                        @if ($kamars->count())

                            <div class="grid md:grid-cols-2 gap-6">

                                @foreach ($kamars as $kamar)

                                    @include('penghuni.booking.card')

                                @endforeach

                            </div>

                            {{-- Pagination --}}
                            <div class="mt-8">

                                {{ $kamars->links() }}

                            </div>

                        @else

                            {{-- Empty State --}}
                            <div class="py-20 text-center">

                                <div class="text-6xl mb-4">

                                    📦

                                </div>

                                <h3 class="text-xl font-bold text-gray-700">

                                    Tidak ada kamar ditemukan

                                </h3>

                                <p class="text-gray-500 mt-2">

                                    Coba ubah filter pencarian Anda agar mendapatkan hasil yang sesuai.

                                </p>

                                <a
                                    href="{{ route('penghuni.booking') }}"
                                    class="inline-block mt-6 bg-[#254D70] hover:bg-[#1f3f5c] text-white px-6 py-3 rounded-lg font-semibold transition">

                                    Reset Filter

                                </a>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>