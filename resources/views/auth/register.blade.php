<x-app-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/" class="focus:outline-none text-center">
                <x-application-logo />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Nombre')" />

                <x-input id="name" class="block mt-1 w-full main-color-blue-text" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- NRE -->
            <div class="mt-4">
                <x-label for="nre" :value="__('Número Regional de Estudiante (NRE)')" />

                <x-input id="nre" class="block mt-1 w-full main-color-blue-text" type="text" name="nre" :value="old('nre')" required />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full main-color-blue-text" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Contraseña')" />

                <x-input id="password" class="block mt-1 w-full main-color-blue-text"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirme su contraseña')" />

                <x-input id="password_confirmation" class="block mt-1 w-full main-color-blue-text"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('¿Ya te has registrado?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('¡Regístrate!') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-app-layout>
