@extends('layout')

@section('title', 'Articles')

@section('content')

<section>
    <div class="min-h-screen flex items-center justify-center px-4">

        <div class="max-w-4xl  bg-white w-full rounded-lg shadow-xl">
            <div class="p-4 border-b">
                <h2 class="text-3xl ">
                   Detalles de {{$article->name}}
                </h2>
                <p class="text-sm text-gray-500">
                    Detalles del prodcuto.
                </p>
            </div>
            <div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Nombre
                    </p>
                    <p>
                        {{$article->name}}
                    </p>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Categoría
                    </p>
                    <p>
                        {{$article->category->name}}
                    </p>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Precio
                    </p>
                    <p>
                        {{$article->price}}€
                        @if($article->discount>0)
                            (Descuento {{$article->discount}}%)
                        @endif
                    </p>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Stock
                    </p>
                    <p>
                        {{$article->stock}} unidades
                    </p>
                </div>
                <div class="p-4 border-b">
                    <h2 class="text-2xl ">
                       Información nutricional
                    </h2>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">Vegetariano</p>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-{{$article->nutrition->is_veg?"green":"red"}}-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="{{$article->nutrition->is_veg? "M5 13l4 4L19 7":"M6 18L18 6M6 6l12 12"}}" />
                    </svg>
                    <p class="text-gray-600">Libre de alergenos</p>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-{{!$article->nutrition->is_allergy?"green":"red"}}-600"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="{{!$article->nutrition->is_allergy? "M5 13l4 4L19 7":"M6 18L18 6M6 6l12 12"}}" />
                    </svg>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">Proteinas</p>
                    <p>{{$article->nutrition->proteins}} g.</p>
                    <p class="text-gray-600">Sal</p>
                    <p>{{$article->nutrition->sodium}} g.</p>
                    <p class="text-gray-600">Calorías</p>
                    <p>{{$article->nutrition->calories}} kcal.</p>
                </div>
                <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                    <p class="text-gray-600">
                        Ingredientes
                    </p>
                    <p>
                       {{$article->nutrition->ingredients_description}}
                    </p>
                </div>
                @if($article->nutrition->is_allergy)
                <div class="p-4 border-b">
                    <h2 class="text-2xl ">
                        Información sobre alergenos
                    </h2>
                </div>
                    <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                        <p class="text-gray-600">
                            Acerca de alergenos
                        </p>
                        <div class="p-6 border-l-4 border-yellow-600 rounded-r-xl bg-yellow-50">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-600">Información</h3>
                                    <div class="mt-2 text-sm text-yellow-600">
                                        <p>{{$article->nutrition->allergy_description}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
