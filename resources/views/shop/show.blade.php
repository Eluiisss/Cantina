@extends('clientsLayout')

@section('title', 'ShowProduct')

@section('content')

    <section>
        <div class="min-h-screen flex items-center justify-center px-4">
            <div class="max-w-5xl  bg-white w-full rounded-lg shadow-xl">
                <div class="flex max-h-md mb-5 bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="w-1/3 bg-cover" style="background-image: url('{{ $article->image? asset('storage/img/articles/'. $article->image): URL::asset('img/no_picture.jpg')}}')"></div>
                    <div class="w-2/3 p-4">
                        <h1 class="text-gray-900 font-bold text-2xl">{{$article->name}}</h1>
                        <p class="mt-2 text-gray-600 text-sm">{{$article->category->name}}</p>
                        <div class="flex item-center justify-between mt-3">
                            <h1 class="text-gray-700 font-bold text-xl">€{{number_format($article->discounted_price,2)}}</h1>
                            <button class="px-3 py-2 bg-blue-800 text-white text-xs font-bold uppercase rounded">Añadir al carrito</button>
                        </div>
                    </div>
                </div>
                @component('articles._articleDetails', ['article' => $article]) @endcomponent
                <div class="md:grid md:grid-cols-6 md:space-y-2 space-y-1 p-4">
                    <a href="{{ url()->previous() }}"
                       class="bg-blue-500 text-white text-center active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150">
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
