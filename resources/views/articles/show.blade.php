<x-app-layout>
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
                <div class="p-4 border-b">
                    <h2 class="text-2xl ">
                        Información sobre el producto
                    </h2>
                </div>
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
                        @if($article->discount>0)
                            {{round((($article->price) - ($article->price * $article->discount)/100), 2) . " € "}}
                            <span class="line-through text-red-600">
                                    {{$article->price . " € "}}
                                </span>
                            (Descuento {{$article->discount}}%)
                        @else
                            {{$article->price}}€
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
                @component('articles._articleDetails', ['article' => $article]) @endcomponent
                <div class="md:grid md:grid-cols-6 md:space-y-2 space-y-1 p-4">
                    <a href="{{ (url()->previous() == route('articles.edit', $article->id))?  route('articles.index') : url()->previous() }}"
                       class="bg-blue-500 text-white text-center active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150">
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
