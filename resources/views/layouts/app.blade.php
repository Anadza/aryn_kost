<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #F8EFD8;
        }

        table tbody tr {
            transition: .25s;
        }

        table tbody tr:hover {
            transform: scale(1.005);
        }
    </style>

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
<body class="font-sans antialiased">

    <div class="min-h-screen bg-gray-100">

        @include('layouts.navigation')

        @isset($header)

            <header class="bg-white shadow">

                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

                    {{ $header }}

                </div>

            </header>

        @endisset

        <main>

            {{ $slot }}

        </main>

    </div>

</body>

</html>
