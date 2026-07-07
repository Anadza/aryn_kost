<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <h2 class="text-3xl font-bold text-[#23466E]">

                Data Penghuni

            </h2>

        </div>

    </x-slot>

    <div class="min-h-screen bg-[#F8EFD8] py-8">

        <div class="max-w-7xl mx-auto">

            <!-- Card -->

            <div class="bg-white rounded-[30px] shadow-lg overflow-hidden">

                <!-- Header Card -->

                <div class="flex justify-between items-center px-8 py-6">

                    <h1 class="text-2xl font-bold text-[#23466E]">

                        Data Penghuni

                    </h1>

                    <!-- Tombol Tambah -->

                    <button

                        id="openModal"

                        class="bg-[#23466E]
                        hover:bg-[#18344F]
                        text-white
                        rounded-full
                        h-11
                        px-6
                        flex
                        items-center
                        gap-2
                        transition
                        shadow-md">

                        <i class="fa-solid fa-plus text-sm"></i>

                        <span class="font-medium">

                            Tambah Penghuni

                        </span>

                    </button>

                </div>

                <!-- Search -->

                <div class="px-8 pb-6">

                    <div class="flex justify-between items-center">

                        <div class="flex gap-4">

                            <!-- Search -->

                            <div class="relative">

                                <i class="fa-solid fa-magnifying-glass
                                absolute
                                left-4
                                top-1/2
                                -translate-y-1/2
                                text-gray-400"></i>

                                <input

                                    type="text"

                                    placeholder="Cari Penghuni..."

                                    class="pl-11
                                    pr-4
                                    h-11
                                    w-80
                                    rounded-xl
                                    border
                                    border-gray-300
                                    focus:ring-2
                                    focus:ring-[#23466E]
                                    focus:outline-none">

                            </div>

                            <!-- Filter -->

                            <select

                                class="w-44
                                h-11
                                rounded-xl
                                border
                                border-gray-300
                                focus:ring-2
                                focus:ring-[#23466E]
                                focus:outline-none">

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

<div

    id="modalPenghuni"

    class="fixed
    inset-0
    bg-black/40
    hidden
    justify-center
    items-center
    z-50">

    <div

        class="bg-[#5E7C99]
        rounded-[30px]
        w-[720px]
        shadow-2xl
        overflow-hidden">

        <!-- Header Modal -->

        <div class="bg-white px-8 py-5">

            <h2 class="text-3xl font-bold text-[#23466E]">

                Tambah Data Penghuni

            </h2>

        </div>

        <!-- FORM akan kita isi di Bagian 2 -->

        <div class="p-8">
<form action="{{ route('admin.penghuni.store') }}" method="POST">

    @csrf

    <!-- Nama -->

    <div class="mb-5">

        <label class="block text-white font-semibold mb-2">

            Nama

        </label>

        <input

            type="text"

            name="nama"

            value="{{ old('nama') }}"

            class="w-full
            rounded-xl
            border
            border-gray-300
            px-4
            py-3
            focus:ring-2
            focus:ring-[#23466E]
            outline-none"

            placeholder="Masukkan nama penghuni">

        @error('nama')

            <p class="text-red-200 text-sm mt-2">

                {{ $message }}

            </p>

        @enderror

    </div>


    <!-- Nomor Kamar & No HP -->

    <div class="grid grid-cols-2 gap-6">

        <div>

            <label class="block text-white font-semibold mb-2">

                Nomor Kamar

            </label>

            <input

                type="text"

                name="nomor_kamar"

                value="{{ old('nomor_kamar') }}"

                class="w-full
                rounded-xl
                border
                border-gray-300
                px-4
                py-3
                focus:ring-2
                focus:ring-[#23466E]
                outline-none"

                placeholder="Contoh : A01">

            @error('nomor_kamar')

                <p class="text-red-200 text-sm mt-2">

                    {{ $message }}

                </p>

            @enderror

        </div>


        <div>

            <label class="block text-white font-semibold mb-2">

                No HP

            </label>

            <input

                type="text"

                name="no_hp"

                value="{{ old('no_hp') }}"

                class="w-full
                rounded-xl
                border
                border-gray-300
                px-4
                py-3
                focus:ring-2
                focus:ring-[#23466E]
                outline-none"

                placeholder="08xxxxxxxxxx">

            @error('no_hp')

                <p class="text-red-200 text-sm mt-2">

                    {{ $message }}

                </p>

            @enderror

        </div>

    </div>


    <!-- Check In & Status -->

    <div class="grid grid-cols-2 gap-6 mt-6">

        <div>

            <label class="block text-white font-semibold mb-2">

                Check In

            </label>

            <input

                type="date"

                name="check_in"

                value="{{ old('check_in') }}"

                class="w-full
                rounded-xl
                border
                border-gray-300
                px-4
                py-3
                focus:ring-2
                focus:ring-[#23466E]
                outline-none">

            @error('check_in')

                <p class="text-red-200 text-sm mt-2">

                    {{ $message }}

                </p>

            @enderror

        </div>


        <div>

            <label class="block text-white font-semibold mb-2">

                Status

            </label>

            <select

                name="status"

                class="w-full
                rounded-xl
                border
                border-gray-300
                px-4
                py-3
                focus:ring-2
                focus:ring-[#23466E]
                outline-none">

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

                <p class="text-red-200 text-sm mt-2">

                    {{ $message }}

                </p>

            @enderror

        </div>

    </div>


    <!-- Tombol -->

    <div class="flex justify-end gap-4 mt-10">

        <button

            type="button"

            id="closeModal"

            class="bg-white
            text-[#23466E]
            px-6
            py-3
            rounded-xl
            font-semibold
            hover:bg-gray-100">

            Kembali

        </button>


        <button

            type="submit"

            class="bg-[#23466E]
            text-white
            px-8
            py-3
            rounded-xl
            font-semibold
            hover:bg-[#18344F]
            shadow-md">

            Simpan

        </button>

    </div>

</form>

    </div>

</div>

<thead>

    <tr class="bg-[#23466E] text-white">

        <th class="px-6 py-4 text-left font-semibold">
            No
        </th>

        <th class="px-6 py-4 text-left font-semibold">
            Nama Penghuni
        </th>

        <th class="px-6 py-4 text-center font-semibold">
            Nomor Kamar
        </th>

        <th class="px-6 py-4 text-center font-semibold">
            No HP
        </th>

        <th class="px-6 py-4 text-center font-semibold">
            Check In
        </th>

        <th class="px-6 py-4 text-center font-semibold">
            Status
        </th>

        <th class="px-6 py-4 text-center font-semibold">
            Aksi
        </th>

    </tr>

</thead>

<tbody>

@forelse($penghunis as $penghuni)

<tr class="border-b hover:bg-gray-50 transition">

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

        @if($penghuni->status == 'Active')

            <span
                class="inline-flex
                items-center
                px-4
                py-1
                rounded-full
                bg-green-100
                text-green-700
                text-sm
                font-semibold">

                ● Active

            </span>

        @else

            <span
                class="inline-flex
                items-center
                px-4
                py-1
                rounded-full
                bg-red-100
                text-red-600
                text-sm
                font-semibold">

                ● Inactive

            </span>

        @endif

    </td>

    <td class="px-6 py-5">

        <div class="flex justify-center gap-3">

            <!-- Detail -->

            <a

                href="{{ route('admin.penghuni.show',$penghuni->id) }}"

                class="w-10
                h-10
                rounded-full
                bg-blue-100
                hover:bg-blue-500
                hover:text-white
                transition
                flex
                justify-center
                items-center">

                <i class="fa-solid fa-eye"></i>

            </a>

            <!-- Edit -->

            <a

                href="{{ route('admin.penghuni.edit',$penghuni->id) }}"

                class="w-10
                h-10
                rounded-full
                bg-yellow-100
                hover:bg-yellow-500
                hover:text-white
                transition
                flex
                justify-center
                items-center">

                <i class="fa-solid fa-pen"></i>

            </a>

            <!-- Delete -->

            <form

                id="delete-form-{{ $penghuni->id }}"

                action="{{ route('admin.penghuni.destroy',$penghuni->id) }}"

                method="POST">

                @csrf

                @method('DELETE')

                <button

                    type="button"

                    onclick="hapusData({{ $penghuni->id }})"

                    class="w-10
                    h-10
                    rounded-full
                    bg-red-100
                    hover:bg-red-500
                    hover:text-white
                    transition
                    flex
                    justify-center
                    items-center">

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

            <i class="fa-solid fa-users text-5xl text-gray-300 mb-4"></i>

            <h3 class="text-xl font-semibold text-gray-500">

                Belum ada data penghuni

            </h3>

            <p class="text-gray-400 mt-2">

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

<div class="px-8 py-6 bg-white border-t">

    {{ $penghunis->links() }}

</div>

</div>

</div>

{{-- SweetAlert Success Tambah --}}
@if(session('success'))

<script>

Swal.fire({

    icon:'success',

    title:'Berhasil',

    text:'{{ session('success') }}',

    timer:2000,

    showConfirmButton:false

});

</script>

@endif



{{-- SweetAlert Success Delete --}}
@if(session('success_delete'))

<script>

Swal.fire({

    icon:'success',

    title:'Berhasil',

    text:'{{ session('success_delete') }}',

    timer:1800,

    showConfirmButton:false

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

openBtn.addEventListener('click',()=>{

    modal.classList.remove('hidden');

    modal.classList.add('flex');

});

closeBtn.addEventListener('click',()=>{

    modal.classList.remove('flex');

    modal.classList.add('hidden');

});

window.addEventListener('click',(e)=>{

    if(e.target===modal){

        modal.classList.remove('flex');

        modal.classList.add('hidden');

    }

});



/* =============================
   SweetAlert Delete
============================= */

function hapusData(id)
{

    Swal.fire({

        title:'Yakin ingin menghapus?',

        text:'Data penghuni tidak dapat dikembalikan.',

        icon:'warning',

        showCancelButton:true,

        confirmButtonText:'Ya, Hapus',

        cancelButtonText:'Batal',

        confirmButtonColor:'#dc2626',

        cancelButtonColor:'#64748b',

        reverseButtons:true

    }).then((result)=>{

        if(result.isConfirmed){

            document.getElementById('delete-form-'+id).submit();

        }

    });

}

</script>



{{-- ========================= --}}
{{-- Auto Open Modal --}}
{{-- ========================= --}}

@if($errors->any())

<script>

document.addEventListener('DOMContentLoaded',()=>{

    modal.classList.remove('hidden');

    modal.classList.add('flex');

});

</script>

@endif

</x-app-layout>