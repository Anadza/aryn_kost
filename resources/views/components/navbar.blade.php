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
                    <h1 class="font-bold text-white text-lg md:text-2xl truncate">Hallo, {{ auth()->user()->name }}!!</h1>
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
            <button class="relative hover:bg-white/10 p-2 rounded-full text-white" aria-label="Notifikasi">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                    <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                    <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                </svg>
                <span class="top-1 right-1 absolute bg-red-500 border border-primary rounded-full w-2.5 h-2.5"></span>
            </button>

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
