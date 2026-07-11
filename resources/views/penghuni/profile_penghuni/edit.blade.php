<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile Penghuni') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">

            {{-- Card Kiri --}}
            <div class="w-full md:w-1/3 bg-white dark:bg-gray-800 shadow rounded-2xl p-6">

                @include('penghuni.profile_penghuni.profile-information')

            </div>

            {{-- Card Kanan --}}
            <div class="w-full md:w-2/3 bg-white dark:bg-gray-800 shadow rounded-2xl p-6">

                @include('penghuni.profile_penghuni.update-profile-form')

            </div>

        </div>

    </div>

</x-app-layout>