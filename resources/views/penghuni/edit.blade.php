<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <h2 class="text-3xl font-bold text-[#23466E]">

                Edit Data Penghuni

            </h2>

        </div>

    </x-slot>

    <div class="min-h-screen bg-[#F8EFD8] py-8">

        <div class="max-w-4xl mx-auto">

            <div class="bg-white rounded-[30px] shadow-lg overflow-hidden">

                <!-- Header -->

                <div class="bg-[#23466E] px-8 py-6">

                    <h1 class="text-2xl font-bold text-white">

                        Edit Data Penghuni

                    </h1>

                </div>

                <!-- Form -->

                <form
                    action="{{ route('admin.penghuni.update',$penghuni->id) }}"
                    method="POST"
                    class="p-8">

                    @csrf
                    @method('PUT')

                    <!-- Nama -->

                    <div class="mb-5">

                        <label class="block font-semibold text-gray-700 mb-2">

                            Nama Penghuni

                        </label>

                        <input

                            type="text"

                            name="nama"

                            value="{{ old('nama',$penghuni->nama) }}"

                            class="w-full rounded-xl border border-gray-300 px-4 py-3
                            focus:ring-2 focus:ring-[#23466E] focus:outline-none">

                        @error('nama')

                            <p class="text-red-500 text-sm mt-2">

                                {{ $message }}

                            </p>

                        @enderror

                    </div>

                    <!-- Nomor Kamar & No HP -->

                    <div class="grid grid-cols-2 gap-6">

                        <div>

                            <label class="block font-semibold text-gray-700 mb-2">

                                Nomor Kamar

                            </label>

                            <input

                                type="text"

                                name="nomor_kamar"

                                value="{{ old('nomor_kamar',$penghuni->nomor_kamar) }}"

                                class="w-full rounded-xl border border-gray-300 px-4 py-3
                                focus:ring-2 focus:ring-[#23466E]">

                            @error('nomor_kamar')

                                <p class="text-red-500 text-sm mt-2">

                                    {{ $message }}

                                </p>

                            @enderror

                        </div>

                        <div>

                            <label class="block font-semibold text-gray-700 mb-2">

                                No HP

                            </label>

                            <input

                                type="text"

                                name="no_hp"

                                value="{{ old('no_hp',$penghuni->no_hp) }}"

                                class="w-full rounded-xl border border-gray-300 px-4 py-3
                                focus:ring-2 focus:ring-[#23466E]">

                            @error('no_hp')

                                <p class="text-red-500 text-sm mt-2">

                                    {{ $message }}

                                </p>

                            @enderror

                        </div>

                    </div>

                    <!-- Check In & Status -->

                    <div class="grid grid-cols-2 gap-6 mt-6">

                        <div>

                            <label class="block font-semibold text-gray-700 mb-2">

                                Check In

                            </label>

                            <input

                                type="date"

                                name="check_in"

                                value="{{ old('check_in',$penghuni->check_in) }}"

                                class="w-full rounded-xl border border-gray-300 px-4 py-3
                                focus:ring-2 focus:ring-[#23466E]">

                            @error('check_in')

                                <p class="text-red-500 text-sm mt-2">

                                    {{ $message }}

                                </p>

                            @enderror

                        </div>

                        <div>

                            <label class="block font-semibold text-gray-700 mb-2">

                                Status

                            </label>

                            <select

                                name="status"

                                class="w-full rounded-xl border border-gray-300 px-4 py-3
                                focus:ring-2 focus:ring-[#23466E]">

                                <option value="Active"

                                    {{ old('status',$penghuni->status)=='Active' ? 'selected' : '' }}>

                                    Active

                                </option>

                                <option value="Inactive"

                                    {{ old('status',$penghuni->status)=='Inactive' ? 'selected' : '' }}>

                                    Inactive

                                </option>

                            </select>

                            @error('status')

                                <p class="text-red-500 text-sm mt-2">

                                    {{ $message }}

                                </p>

                            @enderror

                        </div>

                    </div>

                    <!-- Tombol -->

                    <div class="flex justify-end gap-4 mt-10">

                        <a

                            href="{{ route('admin.penghuni.index') }}"

                            class="px-6 py-3 rounded-xl bg-gray-300 hover:bg-gray-400 transition">

                            Kembali

                        </a>

                        <button

                            type="submit"

                            class="px-6 py-3 rounded-xl bg-[#23466E] hover:bg-[#193856]
                            text-white font-semibold transition">

                            Update Data

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>