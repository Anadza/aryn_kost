<x-app-layout>

    <x-slot name="header">

        <h2 class="text-3xl font-bold text-[#23466E]">

            Detail Penghuni

        </h2>

    </x-slot>

    <div class="min-h-screen bg-[#F8EFD8] py-8">

        <div class="max-w-3xl mx-auto">

            <div class="bg-white rounded-[28px] shadow-lg overflow-hidden">

                <!-- Header -->

                <div class="bg-[#23466E] px-8 py-5">

                    <h1 class="text-2xl text-white font-bold">

                        Detail Penghuni

                    </h1>

                </div>

                <!-- Body -->

                <div class="p-8">

                    <!-- Nama -->

                    <div class="mb-5">

                        <label class="block mb-2 font-semibold">

                            Nama

                        </label>

                        <input

                            type="text"

                            value="{{ $penghuni->nama }}"

                            readonly

                            class="w-full rounded-xl border-gray-300 bg-gray-100">

                    </div>

                    <!-- Kamar & HP -->

                    <div class="grid grid-cols-2 gap-6">

                        <div>

                            <label class="block mb-2 font-semibold">

                                Nomor Kamar

                            </label>

                            <input

                                type="text"

                                value="{{ $penghuni->nomor_kamar }}"

                                readonly

                                class="w-full rounded-xl border-gray-300 bg-gray-100">

                        </div>

                        <div>

                            <label class="block mb-2 font-semibold">

                                No HP

                            </label>

                            <input

                                type="text"

                                value="{{ $penghuni->no_hp }}"

                                readonly

                                class="w-full rounded-xl border-gray-300 bg-gray-100">

                        </div>

                    </div>

                    <!-- Check In & Status -->

                    <div class="grid grid-cols-2 gap-6 mt-5">

                        <div>

                            <label class="block mb-2 font-semibold">

                                Check In

                            </label>

                            <input

                                type="text"

                                value="{{ \Carbon\Carbon::parse($penghuni->check_in)->format('d F Y') }}"

                                readonly

                                class="w-full rounded-xl border-gray-300 bg-gray-100">

                        </div>

                        <div>

                            <label class="block mb-2 font-semibold">

                                Status

                            </label>

                            <input

                                type="text"

                                value="{{ $penghuni->status }}"

                                readonly

                                class="w-full rounded-xl border-gray-300 bg-gray-100">

                        </div>

                    </div>

                    <!-- Tombol -->

                    <div class="mt-10">

                        <a

                            href="{{ route('admin.penghuni.index') }}"

                            class="bg-[#23466E]
                            hover:bg-[#193856]
                            text-white
                            px-6
                            py-3
                            rounded-xl">

                            Kembali

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>