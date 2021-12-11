<x-app-layout>
    <div class="min-h-screen flex items-center justify-center px-4 container py-6 mx-auto">
        <section>
            <div class="backdrop-filter bg-transparent flex items-center justify-center main-color-blue-text dark:main-color-yellow-text">
                <div class="max-w-4xl w-full rounded-lg shadow-xl">
                    <div class="p-4 border-b main-color-blue-border dark:main-color-yellow-border transition duration-500">
                        <h2 class="text-3xl">{{$user->name}}</h2>
                        <p class="text-sm font-bold">Información</p>
                    </div>
                    <div>

                        <div class="md:grid md:grid-cols-2 md:space-y-0 space-y-1 p-4 border-b main-color-blue-border dark:main-color-yellow-border transition duration-500">
                            <p class="text-sm font-bold">Nombre</p>
                            <p>{{$user->name}}</p>
                        </div>
                        <div class="md:grid md:grid-cols-2 md:space-y-0 space-y-1 p-4 border-b main-color-blue-border dark:main-color-yellow-border transition duration-500">
                            <p class="text-sm font-bold">Crédito</p>
                            <p>{{$user->credit}} €</p>
                        </div>
                        <div class="md:grid md:grid-cols-2 md:space-y-0 space-y-1 p-4 border-b main-color-blue-border dark:main-color-yellow-border transition duration-500">
                            <p class="text-sm font-bold">Número de estudiante (NRE)</p>
                            <p>{{$user->nre->nre}}</p>
                        </div>

                        <div class="md:grid md:grid-cols-2 md:space-y-0 space-y-1 p-4 border-b main-color-blue-border dark:main-color-yellow-border transition duration-500">
                            <p class="text-sm font-bold"> Clase</p>
                            <p>{{$user->class}}</p>
                        </div>
                        <div class="p-4 border-b main-color-blue-border dark:main-color-yellow-border transition duration-500">
                            <h2 class="text-2xl font-bold">Contacto</h2>
                        </div>
                        <div class="md:grid md:grid-cols-2 md:space-y-0 space-y-1 p-4 border-b main-color-blue-border dark:main-color-yellow-border transition duration-500">
                            <p class="text-sm font-bold">Clase</p>
                            <p>{{$user->email}}</p>
                        </div>
                        <div class="md:grid md:grid-cols-2 md:space-y-0 space-y-1 p-4 border-b main-color-blue-border dark:main-color-yellow-border transition duration-500">
                            <p class="text-sm font-bold">Teléfono</p>
                            <p>{{$user->phone}}</p>
                        </div>

                        <div class="md:grid md:grid-cols-6 md:space-y-2 space-y-1 p-4">
                            <a href="{{ (url()->previous() == route('users.index'))?  route('users.index') : url()->previous() }}"
                               class="main-color-blue-bg main-color-yellow-text text-center active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow outline-none focus:outline-none mr-1 ease-linear transition-all duration-500">
                                Volver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
