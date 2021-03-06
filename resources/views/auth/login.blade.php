<x-app-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/" class="focus:outline-none text-center">
                <x-application-logo />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full bg-transparent dark:main-color-yellow-text" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Contraseña')" />

                <x-input id="password" class="block mt-1 w-full bg-transparent dark:main-color-yellow-text"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 main-color-blue-text shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm main-color-blue-text dark:main-color-yellow-text transition duration-500">{{ __('Recuérdame') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm main-color-blue-text dark:main-color-yellow-text transition duration-500" href="{{ route('password.request') }}">
                        {{ __('¿Has olvidado tu contraseña?') }}
                    </a>
                @endif

                <x-button class="ml-3 main-color-blue-bg main-color-yellow-text font-bold dark:bg-gray-800 transition duration-500">
                    {{ __('Iniciar sesión') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-app-layout>
