
@include('head')

<body class="bg-cover md:bg-no-repeat" style="background-image:url({{ asset('fotos/fondo_en_cancha_gpt.webp') }})">
    <div class="flex mb-10 h-auto w-auto mx-auto items-center justify-center">
        <div class="container h-auto mx-auto px-4 md:w-1/2 mt-10">
            <div
                class="rounded-xl bg-gray-800 bg-opacity-50 px-16 py-10 shadow-xl md:shadow-lg backdrop-blur-md max-sm:px-8">
                <div class="text-white">
                    <div class="mb-8 flex flex-col items-center">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('fotos/Logo_Mitai_SinFondo.png') }}" width="150"
                                alt="Logo_Mitai_SinFondo" srcset="" />
                            <h1 class="mb-2 text-2xl">Torneos Mita'í</h1>
                        </a>
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
