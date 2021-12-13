<x-app-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/" class="flex flex-col justify-center items-center focus:outline-none text-center">
                <x-application-logo />
                <p class="mt-3 px-4 text-sm md:text-base main-color-blue-text dark:main-color-yellow-text transition duration-500">Usted está registrando un nuevo empleado. Rellene el formulario para completar el proceso.</p>
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('users.storeEmployee') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Nombre')" />

                <x-input id="name" class="block mt-1 w-full main-color-blue-text bg-transparent dark:main-color-yellow-text" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full main-color-blue-text bg-transparent dark:main-color-yellow-text" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Contraseña')" />

                <x-input id="password" class="block mt-1 w-full main-color-blue-text bg-transparent dark:main-color-yellow-text"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirme su contraseña')" />

                <x-input id="password_confirmation" class="block mt-1 w-full main-color-blue-text bg-transparent dark:main-color-yellow-text"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4 main-color-yellow-text main-color-blue-bg transition duration-500">
                    {{ __('Registrar empleado') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-app-layout>