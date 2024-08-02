<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Torneo Mitai</title>
    @vite('resources/css/app.css')
    @vite('resources/js/welcome.js')
    <script src="https://kit.fontawesome.com/05291cba44.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.flaticon.com/flaticon.css">
</head>

<body class="bg-[--color-primary]">
    <nav class="bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-700">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('fotos/Logo_Mitai_SinFondo.png') }}" class="h-10 w-10" alt="MITAI Logo">
                <span class="self-center text-lg font-semibold whitespace-nowrap dark:text-white">Torneos Mitaí</span>
            </a>
            <button data-collapse-toggle="navbar-dropdown" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-dropdown" aria-expanded="false">
                <span class="sr-only">Categorias</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full lg:block lg:w-auto" id="navbar-dropdown">
                <ul
                    class="flex flex-col font-medium p-4 lg:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 lg:space-x-8 rtl:space-x-reverse lg:flex-row lg:mt-0 lg:border-0 lg:bg-white dark:bg-gray-800 lg:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <a href="{{ url('/') }}"
                            class="block py-2 px-3 text-white bg-gray-800 lg:bg-white lg:text-black  rounded lg:bg-transparentlg:text-blue-700 lg:p-0 lg:dark:text-blue-500 dark:bg-blue-600 lg:dark:bg-transparent"
                            aria-current="page">Inicio</a>
                    </li>
                    <li>
                        <div class="flex flex-row items-center">
                            <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownEdiciones"
                                class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-700 lg:p-0 lg:w-auto dark:text-white lg:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 lg:dark:hover:bg-transparent">Ediciones
                                <svg class="w-2.5 h-2.5 ms-2.5 mr-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>

                            <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownCategorias"
                                class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-700 lg:p-0 lg:w-auto dark:text-white lg:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 lg:dark:hover:bg-transparent">Categorias
                                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                        </div>
                        <!-- Dropdown menu -->
                        <div id="dropdownCategorias"
                            class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600 absolute top-full left-0 mt-2">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-400">
                                @if (is_null($EdicionSeleccionada))
                                    <li>
                                        <a href="{{ url('/') }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Debe
                                            seleccionar una Edicion
                                        </a>
                                    </li>
                                @elseif (isset($categorias) && $categorias->isEmpty())
                                    <li>
                                        <a href="{{ url('/') }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Por
                                            el momento no se agregaron categorías</a>
                                    </li>
                                @elseif (isset($categorias))
                                    @foreach ($categorias as $categoria)
                                        <li>
                                            <a href="{{ url('/?idEdicion=' . $categoria->idEdicion . '&idCategoria=' . $categoria->id) }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                {{ $categoria->nombreCategoria }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div id="dropdownEdiciones"
                            class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600 absolute top-full left-0 mt-2">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-400">
                                @if ($ediciones->isEmpty())
                                    <li>
                                        <a href="{{ url('/') }}"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            Por el momento no se agregaron ediciones para este torneo
                                        </a>
                                    </li>
                                @else
                                    @foreach ($ediciones as $edicion)
                                        <li>
                                            <a href="{{ url('/?idEdicion=' . $edicion->id) }}"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                {{ $edicion->nombre }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="{{ route('admin') }}"
                            class="py-2 px-3 text-gray-900 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-700 lg:p-0 dark:text-white lg:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent">
                            Panel de Administración
                        </a>
                    </li>
                    <li>
                        <a href="index.php?modulo=iniciar-sesion&salir=ok"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-700 lg:p-0 dark:text-white lg:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent">Cerrar
                            Sesión</a>
                    </li>
                    <li>
                        <a href="index.php?modulo=iniciar-sesion"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-700 lg:p-0 dark:text-white lg:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent">Iniciar
                            Sesión</a>
                    </li>

                    <li>
                        <button onclick="descargarPDF()"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-700 lg:p-0 dark:text-white lg:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent">Reglamento</button>
                    </li>
                    <script></script>
                    <li>
                        <a href="https://www.facebook.com/ligamitaijb" target="_blank"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-700 lg:p-0 dark:text-white lg:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main>
        <style>
            .bannerFondo {
                height: 400px;
            }
        </style>
        <div>
            <div class="bannerFondo bg-bottom bg-repeat-x"
                style="background-image: url({{ asset('fotos/fondo_en_cancha.webp') }})">
            </div>

            <div class="-mt-64 ">
                <div class="max-w-md mx-auto p-4 bg-gray-100 shadow-md  rounded-md text-center">
                    <p class="text-sm tracking-widest text-gray-600">Torneos</p>
                    <h1 class="font-bold text-5xl text-gray-600">
                        Mita'í
                    </h1>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:grid-cols-4 ">
                    <div class="p-2 sm:p-10 text-center cursor-pointer">
                        <div
                            class="py-16 max-w-sm rounded overflow-hidden shadow-lg bg-oro-500 hover:bg-oro-600 transition duration-500">
                            <div class="space-y-10">
                                <i class="fa-solid fa-trophy" style="font-size:48px;"></i>
                                <div class="px-6 py-4">
                                    <div class="space-y-5">
                                        <div class="font-bold text-xl mb-2 text-white">Campeones</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 sm:p-10 text-center cursor-pointer text-white">
                        <div
                            class="py-16 max-w-sm rounded overflow-hidden shadow-lg bg-gray-500 hover:bg-gray-600 transition duration-500">
                            <div class="space-y-10">
                                <i class="fa-solid fa-medal" style="font-size:48px;"></i>
                                <div class="px-6 py-4">
                                    <div class="space-y-5">
                                        <div class="font-bold text-xl mb-2">Subcampeones</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 sm:p-10 text-center cursor-pointer ml-2">
                        <div
                            class="py-16 max-w-sm rounded overflow-hidden shadow-lg hover:bg-white transition duration-500 bg-white ">
                            <div class="space-y-10">
                                <i class="fa fa-swimmer" style="font-size:48px;"></i>
                                <div class="px-6 py-4">
                                    <div class="space-y-5">
                                        <div class="font-bold text-xl mb-2">Valla menos Vencida</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 sm:p-10 text-center cursor-pointer ml-2">
                        <div
                            class="py-16 max-w-sm rounded overflow-hidden shadow-lg hover:bg-white transition duration-500 bg-white ">
                            <div class="space-y-10">
                                <i class="fa fa-swimmer" style="font-size:48px;"></i>
                                <div class="px-6 py-4">
                                    <div class="space-y-5">
                                        <div class="font-bold text-xl mb-2">Goleadores</div>
                                    </div>
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
