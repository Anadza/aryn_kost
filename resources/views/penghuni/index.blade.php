<x-app-layout>

    @php
        $routePrefix = auth()->user()->hasRole('owner') ? 'owner' : 'admin';
    @endphp

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <h2 class="font-bold text-[#23466E] text-3xl">

                Data Penghuni

            </h2>

        </div>

    </x-slot>

    <div class="bg-[#F8EFD8] py-8 min-h-screen">

        <div class="mx-auto max-w-7xl">

            <!-- Card -->

            <div class="bg-white shadow-lg rounded-[30px] overflow-hidden">

                <!-- Header Card -->

                <div class="flex justify-between items-center px-8 py-6">

                    <h1 class="font-bold text-[#23466E] text-2xl">

                        Data Penghuni

                    </h1>

                </div>

                <!-- Search -->

                <div class="px-8 pb-6">

                    <div class="flex justify-between items-center">

                        <div class="flex gap-4">

                            <!-- Search -->

                            <div class="relative">

                                <i
                                    class="top-1/2 left-4 absolute text-gray-400 -translate-y-1/2 fa-solid fa-magnifying-glass"></i>

                                <input type="text" placeholder="Cari Penghuni..."
                                    class="pr-4 pl-11 border border-gray-300 rounded-xl focus:outline-none focus:ring-[#23466E] focus:ring-2 w-80 h-11">

                            </div>

                            <!-- Filter -->

                            <select
                                class="border border-gray-300 rounded-xl focus:outline-none focus:ring-[#23466E] focus:ring-2 w-44 h-11">

                                <option>

                                    Semua Status

                                </option>

                                <option>

                                    Active

                                </option>

                                <option>

                                    Inactive

                                </option>

                            </select>

                        </div>

                    </div>

                </div>

                <!-- Tabel mulai -->

                <div class="overflow-x-auto">

                    <table class="w-full">
                        <!-- Modal -->

                        <div id="modalPenghuni"
                            class="hidden z-50 fixed inset-0 justify-center items-center bg-black/40">

                            <div class="bg-[#5E7C99] shadow-2xl rounded-[30px] w-[720px] overflow-hidden">

                                <!-- Header Modal -->

                                <div class="bg-white px-8 py-5">

                                    <h2 class="font-bold text-[#23466E] text-3xl">

                                        Tambah Data Penghuni

                                    </h2>

                                </div>

                                <!-- FORM akan kita isi di Bagian 2 -->

                                <div class="p-8">
                                    <form action="{{ route($routePrefix . '.penghuni.store') }}" method="POST">

                                        @csrf

                                        <!-- Nama -->

                                        <div class="mb-5">

                                            <label class="block mb-2 font-semibold text-white">

                                                Nama

                                            </label>

                                            <input type="text" name="nama" value="{{ old('nama') }}"
                                                class="px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-[#23466E] focus:ring-2 w-full"
                                                placeholder="Masukkan nama penghuni">

                                            @error('nama')
                                                <p class="mt-2 text-red-200 text-sm">

                                                    {{ $message }}

                                                </p>
                                            @enderror

                                        </div>


                                        <!-- Nomor Kamar & No HP -->

                                        <div class="gap-6 grid grid-cols-2">

                                            <div>

                                                <label class="block mb-2 font-semibold text-white">

                                                    Nomor Kamar

                                                </label>

                                                <input type="text" name="nomor_kamar"
                                                    value="{{ old('nomor_kamar') }}"
                                                    class="px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-[#23466E] focus:ring-2 w-full"
                                                    placeholder="Contoh : A01">

                                                @error('nomor_kamar')
                                                    <p class="mt-2 text-red-200 text-sm">

                                                        {{ $message }}

                                                    </p>
                                                @enderror

                                            </div>


                                            <div>

                                                <label class="block mb-2 font-semibold text-white">

                                                    No HP

                                                </label>

                                                <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                                                    class="px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-[#23466E] focus:ring-2 w-full"
                                                    placeholder="08xxxxxxxxxx">

                                                @error('no_hp')
                                                    <p class="mt-2 text-red-200 text-sm">

                                                        {{ $message }}

                                                    </p>
                                                @enderror

                                            </div>

                                        </div>


                                        <!-- Check In & Status -->

                                        <div class="gap-6 grid grid-cols-2 mt-6">

                                            <div>

                                                <label class="block mb-2 font-semibold text-white">

                                                    Check In

                                                </label>

                                                <input type="date" name="check_in" value="{{ old('check_in') }}"
                                                    class="px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-[#23466E] focus:ring-2 w-full">

                                                @error('check_in')
                                                    <p class="mt-2 text-red-200 text-sm">

                                                        {{ $message }}

                                                    </p>
                                                @enderror

                                            </div>


                                            <div>

                                                <label class="block mb-2 font-semibold text-white">

                                                    Status

                                                </label>

                                                <select name="status"
                                                    class="px-4 py-3 border border-gray-300 rounded-xl outline-none focus:ring-[#23466E] focus:ring-2 w-full">

                                                    <option value="">

                                                        Pilih Status

                                                    </option>

                                                    <option value="Active">

                                                        Active

                                                    </option>

                                                    <option value="Inactive">

                                                        Inactive

                                                    </option>

                                                </select>

                                                @error('status')
                                                    <p class="mt-2 text-red-200 text-sm">

                                                        {{ $message }}

                                                    </p>
                                                @enderror

                                            </div>

                                        </div>


                                        <!-- Tombol -->

                                        <div class="flex justify-end gap-4 mt-10">

                                            <button type="button" id="closeModal"
                                                class="bg-white hover:bg-gray-100 px-6 py-3 rounded-xl font-semibold text-[#23466E]">

                                                Kembali

                                            </button>


                                            <button type="submit"
                                                class="bg-[#23466E] hover:bg-[#18344F] shadow-md px-8 py-3 rounded-xl font-semibold text-white">

                                                Simpan

                                            </button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                            <thead>

                                <tr class="bg-[#23466E] text-white">

                                    <th class="px-6 py-4 font-semibold text-left">
                                        No
                                    </th>

                                    <th class="px-6 py-4 font-semibold text-left">
                                        Nama Penghuni
                                    </th>

                                    <th class="px-6 py-4 font-semibold text-center">
                                        Nomor Kamar
                                    </th>

                                    <th class="px-6 py-4 font-semibold text-center">
                                        No HP
                                    </th>

                                    <th class="px-6 py-4 font-semibold text-center">
                                        Check In
                                    </th>

                                    <th class="px-6 py-4 font-semibold text-center">
                                        Status
                                    </th>

                                    <th class="px-6 py-4 font-semibold text-center">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($penghunis as $penghuni)
                                    <tr class="hover:bg-gray-50 border-b transition">

                                        <td class="px-6 py-5">

                                            {{ $loop->iteration }}

                                        </td>

                                        <td class="px-6 py-5 font-semibold text-gray-700">

                                            {{ $penghuni->nama }}

                                        </td>

                                        <td class="px-6 py-5 text-center">

                                            {{ $penghuni->nomor_kamar }}

                                        </td>

                                        <td class="px-6 py-5 text-center">

                                            {{ $penghuni->no_hp }}

                                        </td>

                                        <td class="px-6 py-5 text-center">

                                            {{ \Carbon\Carbon::parse($penghuni->check_in)->format('d M Y') }}

                                        </td>

                                        <td class="px-6 py-5 text-center">

                                            @if ($penghuni->status == 'Active')
                                                <span
                                                    class="inline-flex items-center bg-green-100 px-4 py-1 rounded-full font-semibold text-green-700 text-sm">

                                                    ● Active

                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center bg-red-100 px-4 py-1 rounded-full font-semibold text-red-600 text-sm">

                                                    ● Inactive

                                                </span>
                                            @endif

                                        </td>

                                        <td class="px-6 py-5">

                                            <div class="flex justify-center gap-3">

                                                <!-- Detail -->

                                                <a href="{{ route($routePrefix . '.penghuni.show', $penghuni->id) }}"
                                                    class="flex justify-center items-center bg-blue-100 hover:bg-blue-500 rounded-full w-10 h-10 hover:text-white transition">

                                                    <i class="fa-solid fa-eye"></i>

                                                </a>

                                                <!-- Edit -->

                                                <a href="{{ route($routePrefix . '.penghuni.edit', $penghuni->id) }}"
                                                    class="flex justify-center items-center bg-yellow-100 hover:bg-yellow-500 rounded-full w-10 h-10 hover:text-white transition">

                                                    <i class="fa-solid fa-pen"></i>

                                                </a>

                                                <!-- Delete -->

                                                <form id="delete-form-{{ $penghuni->id }}"
                                                    action="{{ route($routePrefix . '.penghuni.destroy', $penghuni->id) }}"
                                                    method="POST">

                                                    @csrf

                                                    @method('DELETE')

                                                    <button type="button" onclick="hapusData({{ $penghuni->id }})"
                                                        class="flex justify-center items-center bg-red-100 hover:bg-red-500 rounded-full w-10 h-10 hover:text-white transition">

                                                        <i class="fa-solid fa-trash"></i>

                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="7">

                                            <div class="py-16 text-center">

                                                <i class="mb-4 text-gray-300 text-5xl fa-solid fa-users"></i>

                                                <h3 class="font-semibold text-gray-500 text-xl">

                                                    Belum ada data penghuni

                                                </h3>

                                                <p class="mt-2 text-gray-400">

                                                    Silakan tambahkan penghuni terlebih dahulu.

                                                </p>

                                            </div>

                                        </td>

                                    </tr>
                                @endforelse

                            </tbody>

                    </table>

                </div>

                {{-- ========================= --}}
                {{-- Pagination --}}
                {{-- ========================= --}}

                <div class="bg-white px-8 py-6 border-t">

                    {{ $penghunis->links() }}

                </div>

            </div>

        </div>

        {{-- SweetAlert Success Tambah --}}
        @if (session('success'))
            <script>
                Swal.fire({

                    icon: 'success',

                    title: 'Berhasil',

                    text: '{{ session('success') }}',

                    timer: 2000,

                    showConfirmButton: false

                });
            </script>
        @endif



        {{-- SweetAlert Success Delete --}}
        @if (session('success_delete'))
            <script>
                Swal.fire({

                    icon: 'success',

                    title: 'Berhasil',

                    text: '{{ session('success_delete') }}',

                    timer: 1800,

                    showConfirmButton: false

                });
            </script>
        @endif



        {{-- ========================= --}}
        {{-- Javascript --}}
        {{-- ========================= --}}

        <script>
            const modal = document.getElementById('modalPenghuni');

            const openBtn = document.getElementById('openModal');

            const closeBtn = document.getElementById('closeModal');

            openBtn.addEventListener('click', () => {

                modal.classList.remove('hidden');

                modal.classList.add('flex');

            });

            closeBtn.addEventListener('click', () => {

                modal.classList.remove('flex');

                modal.classList.add('hidden');

            });

            window.addEventListener('click', (e) => {

                if (e.target === modal) {

                    modal.classList.remove('flex');

                    modal.classList.add('hidden');

                }

            });



            /* =============================
               SweetAlert Delete
            ============================= */

            function hapusData(id) {

                Swal.fire({

                    title: 'Yakin ingin menghapus?',

                    text: 'Data penghuni tidak dapat dikembalikan.',

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonText: 'Ya, Hapus',

                    cancelButtonText: 'Batal',

                    confirmButtonColor: '#dc2626',

                    cancelButtonColor: '#64748b',

                    reverseButtons: true

                }).then((result) => {

                    if (result.isConfirmed) {

                        document.getElementById('delete-form-' + id).submit();

                    }

                });

            }
        </script>



        {{-- ========================= --}}
        {{-- Auto Open Modal --}}
        {{-- ========================= --}}

        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', () => {

                    modal.classList.remove('hidden');

                    modal.classList.add('flex');

                });
            </script>
        @endif

</x-app-layout>
