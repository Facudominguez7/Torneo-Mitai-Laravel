<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        input::placeholder {
            color: white;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-cover bg-no-repeat" style="background-image:url({{ asset('fotos/fondo_en_cancha_gpt.webp') }})">
    <div class="flex mb-10 h-auto w-auto mx-auto items-center justify-center">
        <div class="container h-screen mx-auto px-4 md:w-1/2 mt-10">
            <div
                class="rounded-xl bg-gray-800 bg-opacity-50 px-16 py-10 shadow-xl md:shadow-lg backdrop-blur-md max-sm:px-8">
                <div class="text-white">
                    <div class="mb-8 flex flex-col items-center">
                        <img src="{{ asset('fotos/Logo_Mitai_SinFondo.png') }}" width="150" alt="Logo_Mitai_SinFondo"
                            srcset="" />
                        <h1 class="mb-2 text-2xl">Torneos Mita'í</h1>
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
