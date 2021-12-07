<x-app-layout>
    <div class="container px-5 py-6 mx-auto">
        <section>
            <div class="min-h-screen flex items-center justify-center px-4">
                <div class="max-w-5xl bg-transparent backdrop-filter w-full rounded-lg shadow-xl">
                    <div class="flex max-h-md mb-5 bg-white shadow-lg rounded-lg overflow-hidden">
                        <div class="w-1/3 bg-cover" style="background-image: url('{{ $article->image? asset('storage/img/articles/'. $article->image): URL::asset('img/no_picture.jpg')}}')"></div>
                        <div class="w-2/3 p-4 bg-transparent backdrop-filter">
                            <h1 class="text-gray-900 font-bold text-2xl">{{$article->name}}</h1>
                            <p class="mt-2 text-gray-600 text-sm">{{$article->category->name}}</p>
                            <div class="flex item-center justify-between mt-3">
                                <h1 class="text-gray-700 font-bold text-xl">€{{number_format($article->discounted_price,2)}}</h1>

                            @if ($cart->where('id', $article->id)->count())
                                <x-button class="p-2 rounded-full bg-red-600 text-white mx-5 " disabled>
                                    <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </x-button>
                            @else
                                <form action="{{route('cart.store')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="article_id" value="{{$article->id}}">
                                    <x-button type="submit" class="p-2 rounded-full bg-blue-600 text-white mx-5 -mb-4 hover:bg-blue-500 focus:outline-none focus:bg-blue-500 main-color-blue-bg transition duration-500">
                                        <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </x-button>
                                </form>
                            @endif
                            </div>
                        </div>
                    </div>
                    @component('articles._articleDetails', ['article' => $article]) @endcomponent
                    <div class="md:grid md:grid-cols-6 md:space-y-2 space-y-1 p-4">
                        <a href="{{ url()->previous() }}"
                           class="main-color-blue-bg main-color-yellow-text transition duration-500 text-center font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1">
                            Volver
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
