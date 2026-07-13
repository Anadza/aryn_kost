<div class="text-center">

    {{-- Foto Profil --}}
    <div class="w-32 h-32 mx-auto">

        @if(Auth::user()->penghuni && Auth::user()->penghuni->foto)

            <img
                src="{{ asset('storage/' . Auth::user()->penghuni->foto) }}"
                class="w-32 h-32 rounded-full object-cover border-4 border-[#254D70] shadow">

        @else

            <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center text-6xl shadow">

                👤

            </div>

        @endif

    </div>

    {{-- Nama --}}
    <h3 class="mt-6 text-2xl font-bold text-gray-800">

        {{ Auth::user()->penghuni->nama ?? Auth::user()->name }}

    </h3>

    {{-- Email --}}
    <p class="text-gray-500 mt-1">

        {{ Auth::user()->email }}

    </p>

    {{-- Status --}}
    <div class="mt-6">

        <span
            class="inline-flex items-center px-4 py-2 rounded-full bg-green-100 text-green-700 font-semibold">

            ● Penghuni Aktif

        </span>

    </div>

</div>