<x-app-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/" class="focus:outline-none text-center">
                <x-application-logo />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('¡Muchas gracias por registrarte! Antes de comenzar, ¿puedes verificar tu correo electrónico haciendo click en el correo que te acabamos de envíar? Si no has recibido el email, te enviaremos uno nuevo lo antes posible.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm main-color-blue-text">
                {{ __('Un nuevo link de verificación ha sido enviado a la dirección de correo proporcionada durante su registro.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button>
                        {{ __('Reenviar el email de verificación') }}
                    </x-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm main-color-blue-text">
                    {{ __('Cerrar sesión') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-app-layout>
