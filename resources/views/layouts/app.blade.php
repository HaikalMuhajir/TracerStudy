<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tracer Study Polinema</title>

    <!-- Fonts -->
    <link rel="shortcut icon" href={{ asset('assets/img/logo/polinema.png') }} type="image/x-icon">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @php
            $isFormAlumni = request()->is('form-alumni/*');
            $isFormPengguna = request()->is('form-pengguna/*');
        @endphp

        {{-- Tampilkan navigation hanya jika BUKAN halaman form-alumni dan form-pengguna --}}
        @unless($isFormAlumni || $isFormPengguna)
            @include('layouts.navigation')
        @endunless

        <!-- Page Heading -->
        @if (isset($header) && !($isFormAlumni || $isFormPengguna))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif


        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>


</html>