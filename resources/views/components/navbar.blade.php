<header class="sticky top-0 z-20 bg-primary">
    <div class="flex items-center justify-between gap-4 px-2 py-4 md:px-4">

        <!-- Tombol Toggle Sidebar -->
        <button @click="sidebarOpen = !sidebarOpen" class="shrink-0 rounded-lg p-2 text-white hover:bg-white/10"
            aria-label="Toggle sidebar">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Informasi Header Dinamis -->
        @if (str_contains(request()->url(), 'dashboard'))
            @if (auth()->user()->hasRole('penghuni'))
                <div class="min-w-0 flex-1">
                    <h1 class="truncate text-lg font-bold text-white md:text-2xl">Hallo, {{ auth()->user()->name }}!!</h1>
                    <p class="truncate text-sm text-white/80">Selamat datang di arynKost!</p>
                </div>
            @else
                <div class="flex-1"></div>
            @endif
        @else
            <div class="flex-1"></div>
        @endif

        <!-- Menu Kanan: Notifikasi & Profile -->
        <div class="flex shrink-0 items-center gap-4">

            <!-- Tombol Notifikasi Lonceng -->
            @if (auth()->user()->hasRole('admin'))
                <a href="{{ route('admin.notifikasi.index') }}" class="relative rounded-full p-2 text-white hover:bg-white/10 transition z-50" aria-label="Notifikasi Admin">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                        <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                        <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                    </svg>
                    <span class="absolute right-1 top-1 h-2.5 w-2.5 rounded-full border border-primary bg-red-500"></span>
                </a>
            @else
                <a href="#" class="relative rounded-full p-2 text-white hover:bg-white/10 transition z-50" aria-label="Notifikasi">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                        <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                        <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                    </svg>
                    <span class="absolute right-1 top-1 h-2.5 w-2.5 rounded-full border border-primary bg-red-500"></span>
                </a>
            @endif

            <!-- Dropdown User Profile -->
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex h-9 w-9 items-center justify-center rounded-full bg-white/15 font-semibold text-white hover:bg-white/25">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link href="#">
                        {{ __('Profil') }}
                    </x-dropdown-link>

                    <!-- Form Logout -->
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
