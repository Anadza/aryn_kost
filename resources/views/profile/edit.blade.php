<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">

            {{-- Card Kiri --}}
            <div class="h-[calc(100vh-180px)] w-full md:w-1/3 bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700 p-4 sm:p-8">

                <div class="w-full">
                    @include('profile.partials.profile-information')
                </div>

            </div>

            {{-- Card Kanan --}}
            <div class="h-[calc(100vh-180px)] w-full md:w-2/3 bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-200 dark:border-gray-700 p-4 sm:p-8">

                <div class="w-full">
                    @include('profile.partials.update-profile-information-form')
                </div>

            </div>

        </div>
    </div>

</x-app-layout>