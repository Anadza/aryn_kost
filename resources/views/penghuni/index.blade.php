<x-app-layout>

    <div class="min-h-screen bg-[#F8EFD8]">

        <!-- Header -->
        <div class="bg-[#244B73] shadow-md">

            <div class="max-w-7xl mx-auto px-8 h-16 flex items-center justify-between">

                <div class="flex items-center gap-3">

                    <button
                        class="text-white hover:text-gray-200 transition">

                        <i class="fa-solid fa-arrow-left text-lg"></i>

                    </button>

                    <h1 class="text-white text-3xl font-bold">
                        Data Penghuni
                    </h1>

                </div>

                <button
                    class="text-white hover:text-yellow-300 transition">

                    <i class="fa-solid fa-bell text-xl"></i>

                </button>

            </div>

        </div>

        <!-- Content -->
        <div class="max-w-7xl mx-auto py-8 px-8">

            <!-- Filter -->
            <div class="flex items-center justify-between mb-5">

                <div class="flex items-end gap-4">

                    <!-- Search -->

                    <div>

                        <label
                            class="block text-xs text-gray-500 mb-1">

                            Cari Penghuni

                        </label>

                        <div class="relative">

                            <i
                                class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>

                            <input
                                type="text"
                                placeholder="Cari Penghuni"
                                class="pl-8 pr-4 w-64 h-10 rounded-lg border border-gray-300 bg-white text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                        </div>

                    </div>

                    <!-- Status -->

                    <div>

                        <label
                            class="block text-xs text-gray-500 mb-1">

                            Status

                        </label>

                        <select
                            class="w-48 h-10 rounded-lg border border-gray-300 bg-white text-sm focus:ring-2 focus:ring-blue-500">

                            <option>Select...</option>
                            <option>Active</option>
                            <option>Inactive</option>

                        </select>

                    </div>

                </div>

                <!-- Button -->

                <button
                    class="bg-[#244B73] hover:bg-[#193856]
                    text-white
                    px-6
                    h-10
                    rounded-full
                    shadow-md
                    flex
                    items-center
                    gap-2
                    transition">

                    <i class="fa-solid fa-plus text-xs"></i>

                    <span class="text-sm font-semibold">

                        Tambah Penghuni

                    </span>

                </button>

            </div>

            <!-- Card -->

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <thead>

                            <tr
                                class="bg-gray-50 border-b text-gray-600 text-sm">

                                <th class="py-4 px-6 text-left w-14">

                                    No

                                </th>

                                <th class="py-4 px-6 text-left">

                                    Nama

                                </th>

                                <th class="py-4 px-6 text-center w-36">

                                    No. Kamar

                                </th>

                                <th class="py-4 px-6 text-center w-44">

                                    No. Hp

                                </th>

                                <th class="py-4 px-6 text-center w-44">

                                    Check-in

                                </th>

                                <th class="py-4 px-6 text-center w-32">

                                    Status

                                </th>

                                <th class="py-4 px-6 text-center w-40">

                                    Aksi

                                </th>

                            </tr>

                        </thead>

                        <tbody>
                            @php

$penghunis = [

[
'no'=>1,
'nama'=>'Rizky Maulana',
'kamar'=>'A001',
'hp'=>'081234567890',
'checkin'=>'01 Juli 2026',
'status'=>'Active'
],

[
'no'=>2,
'nama'=>'Aisyah Putri',
'kamar'=>'A002',
'hp'=>'081234567891',
'checkin'=>'03 Juli 2026',
'status'=>'Active'
],

[
'no'=>3,
'nama'=>'Fajar Nugraha',
'kamar'=>'A003',
'hp'=>'081234567892',
'checkin'=>'05 Juli 2026',
'status'=>'Inactive'
],

[
'no'=>4,
'nama'=>'Siti Nurhaliza',
'kamar'=>'A004',
'hp'=>'081234567893',
'checkin'=>'07 Juli 2026',
'status'=>'Active'
],

[
'no'=>5,
'nama'=>'Dimas Saputra',
'kamar'=>'A005',
'hp'=>'081234567894',
'checkin'=>'10 Juli 2026',
'status'=>'Inactive'
],

[
'no'=>6,
'nama'=>'Rahmat Hidayat',
'kamar'=>'A006',
'hp'=>'081234567895',
'checkin'=>'12 Juli 2026',
'status'=>'Active'
],

[
'no'=>7,
'nama'=>'Putri Amelia',
'kamar'=>'A007',
'hp'=>'081234567896',
'checkin'=>'15 Juli 2026',
'status'=>'Active'
],

[
'no'=>8,
'nama'=>'Andi Pratama',
'kamar'=>'A008',
'hp'=>'081234567897',
'checkin'=>'18 Juli 2026',
'status'=>'Inactive'
],

[
'no'=>9,
'nama'=>'Nabila Salsabila',
'kamar'=>'A009',
'hp'=>'081234567898',
'checkin'=>'20 Juli 2026',
'status'=>'Active'
],

[
'no'=>10,
'nama'=>'Yoga Prakoso',
'kamar'=>'A010',
'hp'=>'081234567899',
'checkin'=>'25 Juli 2026',
'status'=>'Active'
]

];

@endphp


@foreach($penghunis as $penghuni)

<tr class="border-b hover:bg-blue-50 transition duration-200">

    <td class="px-6 py-4 text-sm">

        {{ $penghuni['no'] }}

    </td>

    <td class="px-6 py-4 font-medium text-gray-700">

        {{ $penghuni['nama'] }}

    </td>

    <td class="px-6 py-4 text-center">

        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">

            {{ $penghuni['kamar'] }}

        </span>

    </td>

    <td class="px-6 py-4 text-center text-sm text-gray-600">

        {{ $penghuni['hp'] }}

    </td>

    <td class="px-6 py-4 text-center text-sm text-gray-600">

        {{ $penghuni['checkin'] }}

    </td>

    <td class="px-6 py-4 text-center">

        @if($penghuni['status']=='Active')

        <span class="inline-flex items-center gap-2 text-green-600 text-sm font-medium">

            <span class="w-2 h-2 rounded-full bg-green-500"></span>

            Active

        </span>

        @else

        <span class="inline-flex items-center gap-2 text-gray-500 text-sm font-medium">

            <span class="w-2 h-2 rounded-full bg-gray-400"></span>

            Inactive

        </span>

        @endif

    </td>

    <td class="px-6 py-4">

        <div class="flex justify-center items-center gap-3">

            <!-- View -->

            <button
                class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-blue-500 hover:text-white transition">

                <i class="fa-solid fa-eye text-sm"></i>

            </button>

            <!-- Edit -->

            <button
                class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-yellow-500 hover:text-white transition">

                <i class="fa-solid fa-pen text-sm"></i>

            </button>

            <!-- Delete -->

            <button
                class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-red-500 hover:text-white transition">

                <i class="fa-solid fa-trash text-sm"></i>

            </button>

        </div>

    </td>

</tr>

@endforeach
                        </tbody>

                    </table>

                </div>

                <!-- Footer Table -->
                <div class="flex items-center justify-between px-6 py-4 border-t bg-gray-50">

                    <p class="text-sm text-gray-500">
                        Menampilkan <span class="font-semibold">10</span> data penghuni
                    </p>

                    <!-- Dummy Pagination -->
                    <div class="flex items-center gap-2">

                        <button
                            class="w-9 h-9 rounded-lg border border-gray-300 text-gray-400 hover:bg-gray-100 transition">

                            <i class="fa-solid fa-chevron-left text-xs"></i>

                        </button>

                        <button
                            class="w-9 h-9 rounded-lg bg-[#244B73] text-white font-semibold shadow">

                            1

                        </button>

                        <button
                            class="w-9 h-9 rounded-lg border border-gray-300 hover:bg-gray-100 transition">

                            2

                        </button>

                        <button
                            class="w-9 h-9 rounded-lg border border-gray-300 hover:bg-gray-100 transition">

                            3

                        </button>

                        <button
                            class="w-9 h-9 rounded-lg border border-gray-300 text-gray-500 hover:bg-gray-100 transition">

                            <i class="fa-solid fa-chevron-right text-xs"></i>

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>