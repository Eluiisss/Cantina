<div class="container px-5 py-6 mx-auto">
    <h2 class="text-4xl mb-5 text-right main-color-blue-text dark:main-color-yellow-text transition duration-500">{{trans('shop.title.index')}}</h2>
    @include('shop._filters')
    @if($category)
        <h3 class="text-2xl mb-5  main-color-blue-text dark:main-color-yellow-text transition duration-500">{{$category}}</h3>
    @endif
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="overflow-hidden sm:rounded">
                    <div class="container mx-auto px-6">
                        
                        @if(session('message'))
                        <div class="bg-indigo-900 text-center py-4 lg:px-4">
                            <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
                              <span class="flex rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3">New</span>
                              <span class="font-semibold mr-2 text-left flex-auto"> {{session('message')}}</span>
                              <svg class="fill-current opacity-75 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>
                            </div>
                        </div>  
                        @endif
                        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-6">

                            @if ($articles->isNotEmpty())
                                @foreach($articles as $article)
                                    <div class="w-full max-w-sm mx-auto rounded-md shadow-md overflow-hidden bg-transparent backdrop-filter">
                                        <div class="flex items-end justify-end h-56 w-full bg-cover"
                                             style="background-image: url('{{ $article->image? asset('storage/img/articles/'. $article->image): URL::asset('img/no_picture.jpg')}}')">
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
                                            {{--
                                             <form action="{{route('article.addToCart', ['id' => $article->id])}}">
                                                <x-button type="submit" class="p-2 rounded-full bg-blue-600 text-white mx-5 -mb-4 hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                                                        <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                        </svg>
                                                </x-button>
                                            </form>
                                            --}}
                                        </div>
                                        <div class="px-5 py-3">
                                            <a href="{{route('shop.show', ['article' => $article])}}" class="text-gray-700 uppercase main-color-blue-text dark:main-color-yellow-text transition duration-500">{{$article->name}}</a>
                                            <br>
                                            <span class="text-gray-500 mt-2 main-color-blue-text dark:main-color-yellow-text transition duration-500">
                                                {{number_format($article->discounted_price,2)}} €
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
