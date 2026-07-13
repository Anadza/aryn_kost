<div class="w-full bg-white dark:bg-gray-800 rounded-2xl flex flex-col items-center text-center">

    {{-- Foto Profil --}}
    <div
        class="w-32 h-32 rounded-full bg-blue-100 flex items-center justify-center text-5xl text-blue-700 mb-5 shadow">

        👤

    </div>

    {{-- Nama --}}
    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
        {{ $user->name }}
    </h3>

    {{-- Email --}}
    <p class="text-gray-500 text-sm mt-1">
        {{ $user->email }}
    </p>

    {{-- Role --}}
    <div class="mt-4">

        <span
            class="inline-block bg-blue-100 text-blue-700 text-sm font-medium px-4 py-1 rounded-full">

            {{ ucfirst($user->role) }}

        </span>

    </div>

    {{-- Garis --}}
    <div class="w-full border-t border-gray-200 dark:border-gray-700 my-8"></div>

    {{-- Tombol Logout --}}
    <form method="POST" action="{{ route('logout') }}" class="w-full">

        @csrf

        <x-danger-button
            :href="route('logout')"
            onclick="event.preventDefault(); this.closest('form').submit();"
            class="w-full justify-center">

            {{ __('Log Out') }}

        </x-danger-button>

    </form>

</div>