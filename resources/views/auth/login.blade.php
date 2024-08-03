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
            <x-text-input id="email"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4 text-2xl flex flex-col justify-center items-center">
            <x-input-label  for="password" :value="__('Contraseña')" />
            <x-text-input id="password"
                type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            @if (Route::has('password.request'))
                <a class="mt-4 text-white hover:text-yellow-200" href="{{ route('password.request') }}">
                    {{ __('¿Olvidó su contraseña?') }}
                </a>
            @endif
        </div>
        <div class="mt-8 flex justify-center text-lg text-black">
            <x-primary-button>
                {{ __('Iniciar Sesión') }}
            </x-primary-button>
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
