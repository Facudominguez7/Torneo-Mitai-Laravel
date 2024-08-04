<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4 flex flex-col justify-center items-center">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mb-4 flex flex-col justify-center items-center">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4 flex flex-col justify-center items-center">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4 flex flex-col justify-center items-center">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-8 flex justify-center flex-col items-center text-lg text-black">
            <div class="flex justify-center flex-row items-center">
                <a class="pr-5 underline text-sm text-white hover:text-yellow-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
                <x-primary-button>
                    {{ __('Acceder') }}
                </x-primary-button>
            </div>
            <div class="flex items-center justify-center mt-5">
                <hr class="w-64 border-white mr-2" />
                <span class="text-white text-2xl">O</span>
                <hr class="w-64 border-white ml-2" />
            </div>
            <a href="socialite/google" class="mt-3 bg-white hover:bg-gray-100 border border-gray-300 rounded-lg p-2 shadow-sm">
                Registrarse con Google
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/24px-Google_%22G%22_Logo.svg.png" alt="Google" class="w-4 h-4 ml-2">
            </a>
        </div>
    </form>
</x-guest-layout>