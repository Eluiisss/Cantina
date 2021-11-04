@extends('layout')

@section('title', 'Usuarios')

@section('content')

<section>
    <div class="min-h-screen flex items-center justify-center px-4">

        <div class="max-w-4xl  bg-white w-full rounded-lg shadow-xl">
            <div class="p-4 border-b">
                <h2 class="text-3xl ">
                   {{$user->name}}
                </h2>
                <p class="text-sm text-gray-500">
                    Información
                </p>
            </div>
            <div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Nombre
                    </p>
                    <p>
                        {{$user->name}}
                    </p>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Número de estudiante(NRE)
                    <p>
                        {{$user->nre->nre}}
                    </p>
                </div>

                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Clase
                    </p>
                    <p>
                        {{$user->class}}
                    </p>
                </div>
                <div class="p-4 border-b">
                    <h2 class="text-2xl ">
                       Contacto
                    </h2>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Clase
                    </p>
                    <p>
                        {{$user->email}}
                    </p>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        teléfono
                    </p>
                    <p>
                        {{$user->phone}}
                    </p>
                </div>
            
                <div class="md:grid md:grid-cols-6 md:space-y-2 space-y-1 p-4">
                    <a href="{{ (url()->previous() == route('users.index'))?  route('users.index') : url()->previous() }}"
                       class="bg-blue-500 text-white text-center active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150">
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection