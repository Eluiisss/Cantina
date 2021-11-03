@extends('layout')

@section('title', 'Category')

@section('content')

    <section>
        <div class="min-h-screen flex items-center justify-center px-4">

            <div class="max-w-4xl  bg-white w-full rounded-lg shadow-xl">
                <div class="p-4 border-b">
                    <h2 class="text-3xl ">
                        Categoria:  {{$category->name}}
                    </h2>
                    <p class="text-sm text-gray-500">
                        Detalles sobre esta categoría.
                    </p>
                </div>
                <div>
                    <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                        <p class="text-gray-600">
                            Nombre
                        </p>
                        <p>
                            {{$category->name}}
                        </p>
                    </div>
                    <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                        <p class="text-gray-600">
                            Artículos asociados
                        </p>
                        <p>
                            {{$category->articles->count()}}
                        </p>
                    </div>
                    @if($category->description)
                    <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                        <p class="text-gray-600">
                            Acerca de:
                        </p>
                        <p>
                            {{$category->description}}
                        </p>
                    </div>
                    @endif
                    <div class="md:grid md:grid-cols-6 md:space-y-2 space-y-1 p-4">
                        <a href="{{ (url()->previous() == route('categories.edit', $category->id))?  route('categories.index') : url()->previous() }}"
                           class="bg-blue-500 text-white text-center active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150">
                            Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
