<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<div class="font-sans antialiased" x-data="{
    sidebarOpen: window.innerWidth >= 768
}" x-cloak>

    <div class="flex bg-secondary min-h-screen">

        <div class="h-screen transition-all duration-300 shrink-0"
            :class="sidebarOpen ? 'w-64' : 'w-0 overflow-hidden'">

            <x-sidebar />

        </div>

        <div class="flex flex-col flex-1 transition-all duration-300">

            <x-navbar />

            <main class="flex-1 p-4 md:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</div>
</body>

</html>
