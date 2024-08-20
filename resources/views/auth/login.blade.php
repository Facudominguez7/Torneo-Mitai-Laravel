<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <a href="{{ route('register') }}" class="mt-2">
        <h1 class="text-white">No tiene una cuenta?
            <button
                class="rounded-lg p-1 bg-yellow-200  bg-opacity-50 hover:bg-yellow-700 shadow-xl backdrop-blur-md transition-colors duration-300">
                Registrarse
            </button>
        </h1>
    </a>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4 flex flex-col justify-center items-center">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4 text-2xl flex flex-col justify-center items-center">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            @if (Route::has('password.request'))
                <a class="mt-4 text-white hover:text-yellow-200" href="{{ route('password.request') }}">
                    {{ __('¿Olvidó su contraseña?') }}
                </a>
            @endif
        </div>
        <div class="mt-8 flex justify-center flex-col items-center text-lg text-black">
            <x-primary-button>
                {{ __('Acceder') }}
            </x-primary-button>
            <div class="flex items-center justify-center mt-5">
                <hr class="w-64 border-white mr-2" />
                <span class="text-white text-2xl">O</span>
                <hr class="w-64 border-white ml-2" />
            </div>
                <div class="flex flex-row-reverse mt-3 bg-white hover:bg-gray-100 border border-gray-300 rounded-lg p-2 shadow-sm">
                    <a class="pl-5 flex items-center" href="/auth/redirect">
                        Iniciar sesión con Google
                    </a>
                    <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 48 48">
                        <path fill="#fbc02d" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12	s5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20	s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path><path fill="#e53935" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039	l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path><path fill="#4caf50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36	c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path><path fill="#1565c0" d="M43.611,20.083L43.595,20L42,20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571	c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                        </svg>
                </div>
        </div>

        <!-- Remember Me
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>
        -->
    </form>

</x-guest-layout>
