<header class="top-0 z-20 sticky bg-primary">
    <div class="flex justify-between items-center gap-4 px-2 md:px-4 py-4">

        <button @click="sidebarOpen = !sidebarOpen" class="hover:bg-white/10 p-2 rounded-lg text-white shrink-0"
            aria-label="Toggle sidebar">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        @if (str_contains(request()->url(), 'dashboard'))
            @if (auth()->user()->hasRole('penghuni'))
                <div class="flex-1 min-w-0">
                    <h1 class="font-bold text-white text-lg md:text-2xl truncate">Hallo, {{ auth()->user()->name }}!!
                    </h1>
                    <p class="text-white/80 text-sm truncate">Selamat datang di arynKost!</p>
                </div>
            @else
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="top-1/2 left-4 absolute w-4 h-4 text-white/70 -translate-y-1/2">
                            <circle cx="11" cy="11" r="7" />
                            <path d="m21 21-4.35-4.35" />
                        </svg>
                        <input type="text" placeholder="Cari..."
                            class="bg-transparent py-2.5 pr-4 pl-11 border border-white/40 focus:border-transparent rounded-full focus:outline-none focus:ring-2 focus:ring-white/40 w-full text-white text-sm placeholder-white/70">
                    </div>
                </div>
            @endif
        @else
            {{-- Bagian tengah kosong bersih di halaman selain dashboard --}}
            <div class="flex-1"></div>
        @endif

        <div class="flex items-center gap-4 shrink-0">
            @php
                $showNotifikasi =
                    auth()->user()->hasRole('admin') &&
                    \Illuminate\Support\Facades\Route::has('admin.notifikasi.index');
                $unreadNotifikasiCount = $showNotifikasi ? \App\Models\Notifikasi::belumDibaca()->count() : 0;
            @endphp

            <!-- Tombol Notifikasi di Pojok Kanan Atas -->
            <a href="{{ route('admin.notifikasi.index') }}"
                class="relative p-2 text-gray-400 hover:text-gray-500 rounded-full focus:outline-none transition z-50">
                <span class="sr-only">Lihat Notifikasi</span>
                <!-- Ikon Lonceng -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>

                <span class="absolute top-2 right-2 block h-2.5 w-2.5 rounded-full bg-red-500 ring-2 ring-white"></span>
            </a>

            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="flex justify-center items-center bg-white/15 hover:bg-white/25 rounded-full w-9 h-9 font-semibold text-white">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link href="#">
                        {{ __('Profil') }}
                    </x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</header>
