<x-app-layout>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-slate-800">
            Tambah Data Penghuni
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto">

            <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

                <!-- Header -->
                <div class="bg-[#2D4F73] px-8 py-5">
                    <h1 class="text-2xl font-bold text-white">
                        Tambah Data Penghuni
                    </h1>
                </div>

                <!-- Form -->
                <form action="{{ route('admin.penghuni.store') }}" method="POST" class="p-8">

                    @csrf

                    <div class="mb-5">

                        <label class="block text-sm font-semibold mb-2">
                            Nama Penghuni
                        </label>

                        <input
                            type="text"
                            name="nama"
                            value="{{ old('nama') }}"
                            class="w-full rounded-xl border-gray-300 focus:ring-blue-500 focus:border-blue-500">

                    </div>

                    <div class="grid grid-cols-2 gap-6">

                        <div>

                            <label class="block text-sm font-semibold mb-2">
                                Nomor Kamar
                            </label>

                            <input
                                type="text"
                                name="nomor_kamar"
                                value="{{ old('nomor_kamar') }}"
                                class="w-full rounded-xl border-gray-300">

                        </div>

                        <div>

                            <label class="block text-sm font-semibold mb-2">
                                Nomor HP
                            </label>

                            <input
                                type="text"
                                name="no_hp"
                                value="{{ old('no_hp') }}"
                                class="w-full rounded-xl border-gray-300">

                        </div>

                    </div>

                    <div class="grid grid-cols-2 gap-6 mt-5">

                        <div>

                            <label class="block text-sm font-semibold mb-2">
                                Check In
                            </label>

                            <input
                                type="date"
                                name="check_in"
                                value="{{ old('check_in') }}"
                                class="w-full rounded-xl border-gray-300">

                        </div>

                        <div>

                            <label class="block text-sm font-semibold mb-2">
                                Status
                            </label>

                            <select
                                name="status"
                                class="w-full rounded-xl border-gray-300">

                                <option value="">Pilih Status</option>

                                <option value="Active">Active</option>

                                <option value="Inactive">Inactive</option>

                            </select>

                        </div>

                    </div>

                    <div class="flex justify-end gap-4 mt-10">

                        <a href="{{ route('admin.penghuni.index') }}"
                           class="px-6 py-3 rounded-xl bg-gray-300 hover:bg-gray-400">

                            Kembali

                        </a>

                        <button
                            type="submit"
                            class="px-6 py-3 rounded-xl bg-[#2D4F73] hover:bg-[#1F3A56] text-white">

                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>