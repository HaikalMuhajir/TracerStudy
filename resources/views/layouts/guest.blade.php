<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tracer Study POLINEMA</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href={{ asset('assets/img/logo/polinema.png')}} type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md px-6 py-6 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex justify-center items-center ">
                <a href="login">
                    <x-application-logo />
                </a>
            </div>
            <h1 class="text-center font-bold" style="font-weight: 500 !important; font-size: 2rem !important; color:rgb(7, 1, 39)">
                Tracer Study
            </h1>
            <br>
            {{ $slot }}
        </div>
    </div>
</body>

</html>
