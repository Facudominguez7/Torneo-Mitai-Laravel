<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Torneo Mitai</title>
    @vite('resources/css/app.css')
    @vite('resources/js/welcome.js')
    @vite('resources/js/app.js')
    <script src="https://kit.fontawesome.com/05291cba44.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.flaticon.com/flaticon.css">
</head>

<body class="bg-[--color-primary]">
    @include('layouts.navigation')
    <main>
        <style>
            .bannerFondo {
                height: 400px;
            }
        </style>
        <div class="bannerFondo bg-bottom bg-repeat-x" style="background-image: url({{ asset('fotos/fondo_en_cancha.webp') }})">
        </div>
        <div class="-mt-64 ">
            <div class="max-w-md mx-auto p-6 bg-black shadow-lg rounded-md text-center bg-opacity-70 mt-[-20rem] lg:mb-0 mb-10">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('fotos/Logo_Mitai_SinFondo.png') }}" width="125" alt="Logo_Mitai_SinFondo" />
                </div>
                <p class="text-sm tracking-widest text-white">Torneos</p>
                <h1 class="font-bold text-5xl text-white">
                    Mita'í
                </h1>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:grid-cols-3  xl:grid-cols-4 ">
                <div class="p-2 sm:p-10 text-center cursor-pointer flex-1">
                    <div class="h-64 w-64 flex justify-center rounded overflow-hidden shadow-lg bg-oro-500 hover:bg-oro-600 transition duration-500">
                        <div class="flex justify-center items-center flex-col">
                            <i class="fa-solid fa-trophy text-black" style="font-size:48px;"></i>
                            <div class="px-6 py-4">
                                <div class="font-bold text-xl mb-2 text-black">Campeones</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-2 sm:p-10 text-center cursor-pointer flex-1">
                    <div class="h-64 w-64 flex justify-center rounded overflow-hidden shadow-lg bg-gray-500 hover:bg-gray-600 transition duration-500">
                        <div class="flex justify-center items-center flex-col">
                            <i class="fa-solid fa-medal text-black" style="font-size:48px;"></i>
                            <div class="px-6 py-4">
                                <div class="font-bold text-xl mb-2">Subcampeones</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-2 sm:p-10 text-center cursor-pointer flex-1">
                    <div class="h-64 w-64 flex justify-center rounded overflow-hidden shadow-lg hover:bg-white transition duration-500 bg-white ">
                        <div class="flex justify-center items-center flex-col">
                            <i class="fa fa-swimmer" style="font-size:48px;"></i>
                            <div class="px-6 py-4">
                                <div class="font-bold text-xl mb-2">Valla menos Vencida</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-2 sm:p-10 text-center cursor-pointer flex-1">
                    <div class="h-64 w-64 flex justify-center rounded overflow-hidden shadow-lg hover:bg-white transition duration-500 bg-white ">
                        <div class="flex justify-center items-center flex-col">
                            <i class="fa fa-swimmer" style="font-size:48px;"></i>
                            <div class="px-6 py-4">
                                <div class="font-bold text-xl mb-2">Goleadores</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
</body>

</html>