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

        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@vite(['resources/css/app.css', 'resources/js/app.js'])


    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    <div class="bg-secondary min-h-screen"
        x-data="{ sidebarOpen: true }"
        x-init="sidebarOpen = window.innerWidth >= 768"
        x-cloak>

        {{-- Sidebar: satu variabel sidebarOpen ngontrol semua breakpoint --}}
        <x-sidebar />

        {{-- Konten: padding-left ikut reaktif nyesuain sidebar kebuka/tertutup di desktop.
             Di mobile selalu pl-0 karena sidebar jadi overlay, gak makan tempat. --}}
        <div class="flex flex-col min-h-screen transition-all duration-300"
            :class="sidebarOpen ? 'md:pl-64' : 'md:pl-0'">

            <x-navbar />

            <main class="flex-1 p-4 md:p-6">
                {{ $slot }}
            </main>

        </div>
    </div>

</body>
</html>
