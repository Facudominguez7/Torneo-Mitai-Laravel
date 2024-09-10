<!DOCTYPE html>
<html lang="es">
@include('head')

<body class="bg-[--color-primary]">
    @include('layouts.navigation')
    <main>
        <style>
            .bannerFondo {
                height: 400px;
            }
        </style>
        <div class="bannerFondo bg-bottom bg-repeat-x"
            style="background-image: url({{ asset('fotos/fondo_en_cancha.webp') }})">
        </div>
        <div class="-mt-72 ">
            <div
                class="max-w-md mx-auto p-6 bg-black shadow-lg rounded-md text-center bg-opacity-70 mt-[-20rem] lg:mb-0 mb-10">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('fotos/Logo_Mitai_SinFondo.png') }}" width="125" alt="Logo_Mitai_SinFondo" />
                </div>
                <p class="text-sm tracking-widest text-white">Torneos</p>
                <h1 class="font-bold text-5xl text-white mb-5">
                    Mita'í
                </h1>
                @if (isset($EdicionSeleccionada) || isset($ultimaEdicion))@if (isset($EdicionSeleccionada))
                <a href="{{ route('fixture', ['idEdicion' => $EdicionSeleccionada]) }}"
                    class="bg-yellow-100 hover:bg-yellow-300 text-black font-bold py-2 px-4 rounded">
                    Fixture
                </a>
                @else
                <a href="{{ route('fixture', ['idEdicion' => $ultimaEdicion]) }}"
                    class="bg-yellow-100 hover:bg-yellow-300 text-black font-bold py-2 px-4 rounded">
                    Fixture
                </a>
                @endif
                @endif
            </div>
            <div class="flex justify-center">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:grid-cols-3  xl:grid-cols-4 ">
                    <div class="p-2 sm:p-10 text-center flex-1 mb-4">
                        <div
                            class="h-64 w-64 flex justify-center rounded overflow-hidden shadow-md bg-yellow-200  transition duration-500">
                            <div class="flex justify-center items-center flex-col">
                                <i class="fa-solid fa-trophy text-black" style="font-size:48px;"></i>
                                <div class="px-6 py-4">
                                    <div class="font-bold text-xl mb-2 text-black">Campeones</div>
                                    @if (isset($EdicionSeleccionada) || isset($ultimaEdicion))
                                    <div class="mt-5">
                                        @if (isset($EdicionSeleccionada))
                                        <a href="{{ route('campeones', ['idEdicion' => $EdicionSeleccionada]) }}"
                                            class="bg-black hover:bg-yellow-500 text-white font-bold py-2 px-4 rounded">
                                            Ver más
                                        </a>
                                        @else
                                        <a href="{{ route('campeones', ['idEdicion' => $ultimaEdicion]) }}"
                                            class="bg-black hover:bg-yellow-500 text-white font-bold py-2 px-4 rounded">
                                            Ver más
                                        </a>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 sm:p-10 text-center flex-1 mb-4">
                        <div
                            class="h-64 w-64 flex justify-center rounded overflow-hidden shadow-md bg-gray-300  transition duration-500">
                            <div class="flex justify-center items-center flex-col">
                                <i class="fa-solid fa-medal text-black" style="font-size:48px;"></i>
                                <div class="px-6 py-4">
                                    <div class="font-bold text-xl mb-2 text-black">Subcampeones</div>
                                    @if (isset($EdicionSeleccionada) || isset($ultimaEdicion))
                                    <div class="mt-5">
                                        @if (isset($EdicionSeleccionada))
                                        <a href="{{ route('subcampeones', ['idEdicion' => $EdicionSeleccionada]) }}"
                                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                            Ver más
                                        </a>
                                        @else
                                        <a href="{{ route('subcampeones', ['idEdicion' => $ultimaEdicion]) }}"
                                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                            Ver más
                                        </a>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 sm:p-10 text-center  flex-1 mb-4">
                        <div
                            class="h-64 w-64 flex justify-center rounded overflow-hidden shadow-md bg-green-300  transition duration-500">
                            <div class="flex justify-center items-center flex-col">
                                <img src="{{ asset('fotos/guante-arquero.png') }}" class="w-16 h-16">
                                <div class="px-6 py-4">
                                    <div class="font-bold text-xl mb-2 text-black">Vallas Menos Vencidas</div>
                                    @if (isset($EdicionSeleccionada) || isset($ultimaEdicion))
                                    <div class="mt-5">
                                        @if (isset($EdicionSeleccionada))
                                        <a href="{{ route('vallas', ['idEdicion' => $EdicionSeleccionada]) }}"
                                            class="bg-green-800 hover:bg-green-900 text-white font-bold py-2 px-4 rounded">
                                            Ver más
                                        </a>
                                        @else
                                        <a href="{{ route('vallas', ['idEdicion' => $ultimaEdicion]) }}"
                                            class="bg-green-800 hover:bg-green-900 text-white font-bold py-2 px-4 rounded">
                                            Ver más
                                        </a>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 sm:p-10 text-center flex-1 mb-4">
                        <div
                            class="h-64 w-64 flex justify-center rounded overflow-hidden shadow-md bg-blue-300  transition duration-500">
                            <div class="flex justify-center items-center flex-col">
                                <img src="{{ asset('fotos/Botin-con-pelota.png') }}" class="w-20 h-20">
                                <div class="px-6 py-4">
                                    <div class="font-bold text-xl mb-2 text-black">Goleadores</div>
                                    @if (isset($EdicionSeleccionada) || isset($ultimaEdicion))
                                    <div class="mt-5">
                                        @if (isset($EdicionSeleccionada))
                                        <a href="{{ route('goleadores', ['idEdicion' => $EdicionSeleccionada]) }}"
                                            class="bg-white hover:bg-blue-400 text-black font-bold py-2 px-4 rounded">
                                            Ver más
                                        </a>
                                        @else
                                        <a href="{{ route('goleadores', ['idEdicion' => $ultimaEdicion]) }}"
                                            class="bg-white hover:bg-blue-400 text-black font-bold py-2 px-4 rounded">
                                            Ver más
                                        </a>
                                        @endif
                                        </a>
                                    </div>
                                    @endif
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