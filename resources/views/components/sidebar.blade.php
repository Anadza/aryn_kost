@php
    $isAdminOrOwner = auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner');
    $roleForRoute = auth()->user()->hasRole('admin')
        ? 'admin'
        : (auth()->user()->hasRole('owner')
            ? 'owner'
            : 'penghuni');

    $navRoute = function (string $name) use ($roleForRoute) {
        $full = "{$roleForRoute}.{$name}";
        return \Illuminate\Support\Facades\Route::has($full) ? route($full) : '#';
    };
@endphp

<div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-200"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" @click="sidebarOpen = false" class="md:hidden z-30 fixed inset-0 bg-black/50"
    style="display: none;" x-cloak></div>

<aside
    class="left-0 z-40 fixed inset-y-0 flex flex-col bg-primary w-64 overflow-y-auto transition-transform duration-300"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    <div class="flex items-center gap-1 px-6 py-6 shrink-0">
        <img src="{{ asset('logo.png') }}" alt="Logo arynKost" class="w-auto h-16 shrink-0">
        <span class="font-sans font-bold text-white text-2xl">arynKost</span>
    </div>

    <nav class="flex-1 space-y-1 px-3 pb-6">
        @if ($isAdminOrOwner)
            <a href="{{ route("{$roleForRoute}.dashboard") }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs("{$roleForRoute}.dashboard") ? 'bg-white/15 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 shrink-0">
                    <rect x="3" y="3" width="7" height="7" rx="1.5" />
                    <rect x="14" y="3" width="7" height="7" rx="1.5" />
                    <rect x="3" y="14" width="7" height="7" rx="1.5" />
                    <rect x="14" y="14" width="7" height="7" rx="1.5" />
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ $navRoute('kamar.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs("{$roleForRoute}.kamar.*") ? 'bg-white/15 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 shrink-0">
                    <path d="M2 11v7" />
                    <path d="M2 11V8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v3" />
                    <path d="M2 11h20v7H2z" />
                    <path d="M6 11V9" />
                </svg>
                <span>Data Kamar</span>
            </a>

            <a href="{{ $navRoute('pembayaran.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs("{$roleForRoute}.pembayaran.*") ? 'bg-white/15 text-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 shrink-0">
                    <rect x="2" y="5" width="20" height="14" rx="2" />
                    <path d="M2 10h20" />
                </svg>
                <span>Pembayaran</span>
            </a>

            <a href="{{ $navRoute('penghuni.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs("{$roleForRoute}.penghuni.*") ? 'bg-[#567B9D] text-white shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 shrink-0">
                    <circle cx="9" cy="8" r="3" />
                    <path d="M2 20v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1" />
                    <circle cx="19" cy="9" r="2.5" />
                </svg>
                <span>Data Penghuni</span>
            </a>

            <a href="{{ $navRoute('pengaduan.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs("{$roleForRoute}.pengaduan.*") ? 'bg-[#567B9D] text-white shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 shrink-0">
                    <path
                        d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                </svg>
                <span>Data Pengaduan</span>
            </a>

            <a href="{{ route('penghuni.profile') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs("{$roleForRoute}.profile.edit") ? 'bg-[#567B9D] text-white shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 shrink-0">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M4 21v-1a8 8 0 0 1 16 0v1" />
                </svg>
                <span>Profil</span>
            </a>
        @else
            {{-- Penghuni --}}
            <a href="{{ route('penghuni.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('penghuni.dashboard') ? 'bg-[#567B9D] text-white shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 shrink-0">
                    <rect x="3" y="3" width="7" height="7" rx="1.5" />
                    <rect x="14" y="3" width="7" height="7" rx="1.5" />
                    <rect x="3" y="14" width="7" height="7" rx="1.5" />
                    <rect x="14" y="14" width="7" height="7" rx="1.5" />
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ $navRoute('kamar.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('penghuni.kamar.*') ? 'bg-[#567B9D] text-white shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 shrink-0">
                    <path d="M2 4v16" />
                    <path d="M2 8h18a2 2 0 0 1 2 2v10" />
                    <path d="M2 17h20" />
                    <path d="M6 8v-2a2 2 0 0 1 2-2h3" />
                </svg>
                <span>Kamar Pribadi</span>
            </a>

            <a href="{{ $navRoute('penghuni.booking') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('penghuni.booking.*') ? 'bg-[#567B9D] text-white shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 shrink-0">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M4 21v-1a6 6 0 0 1 6-6h4a6 6 0 0 1 6 6v1" />
                </svg>
                <span>Booking</span>
            </a>

            <a href="{{ route('penghuni.pembayaran.upload') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('penghuni.pembayaran.upload') ? 'bg-[#567B9D] text-white shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 shrink-0">
                    <rect x="2" y="5" width="20" height="14" rx="2" />
                    <path d="M2 10h20" />
                </svg>
                <span>Pembayaran</span>
            </a>

            <a href="{{ $navRoute('pengaduan.create') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('penghuni.pengaduan.*') ? 'bg-[#567B9D] text-white shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 shrink-0">
                    <path
                        d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                </svg>
                <span>Ajukan Pengaduan</span>
            </a>

            <a href="{{ route('penghuni.profile') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                {{ request()->routeIs('penghuni.profile') ? 'bg-[#567B9D] text-white shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">

                <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="w-5 h-5 shrink-0">
            <a href="{{ route('profile.edit') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('profile.edit') ? 'bg-[#567B9D] text-white shadow-sm' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 shrink-0">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M4 21v-1a8 8 0 0 1 16 0v1" />
                </svg>

                <span>Profil</span>
            </a>
        @endif
    </nav>
</aside>
