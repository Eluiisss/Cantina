<x-app-layout>
    <section class="text-gray-600">
        <div class="container px-5 py-6 mx-auto">
            <h2 class="text-4xl mb-5">{{trans('shop.title.index')}}</h2>
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden sm:rounded">
                            <div class="container mx-auto px-6">
                                <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-6">
                                    @if ($articles->isNotEmpty())
                                    @foreach($articles as $article)
                                    <div class="w-full max-w-sm mx-auto rounded-md shadow-md overflow-hidden">
                                        <div class="flex items-end justify-end h-56 w-full bg-cover"
                                             style="background-image: url('{{ $article->image? asset('storage/img/articles/'. $article->image): URL::asset('img/no_picture.jpg')}}')">
                                            <x-button class="p-2 rounded-full bg-blue-600 text-white mx-5 -mb-4 hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                                                <a href="{{route('article.addToCart', ['id' => $article->id])}}" class="text-gray-700 uppercase">
                                                    <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                    </svg>
                                                </a>

                                            </x-button>
                                        </div>
                                        <div class="px-5 py-3">
                                            <a href="{{route('shop.show', ['article' => $article])}}" class="text-gray-700 uppercase">{{$article->name}}</a>
                                            <br>
                                            <span class="text-gray-500 mt-2">
                                                €{{number_format($article->discounted_price,2)}}
                                                @if($article->discount>0)
                                                    <span class="line-through text-red-600">
                                                            {{number_format($article->price,2) . " € "}}
                                                    </span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                        <p class="text-left md:text-center text-blueGray-700 text-xl">
                                            {{trans('shop.products.empty')}}
                                        </p>
                                    @endif
                                </div>
                                {{$articles->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
