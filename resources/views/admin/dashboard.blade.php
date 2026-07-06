<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-primary text-xl leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900">
                    Halo, {{ auth()->user()->name }}! Kamu login sebagai <strong>Admin</strong>.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
