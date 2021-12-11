<section>
    <div class="{{$showShop}} container px-5 py-6 mx-auto">
        <h2 class="text-4xl mb-10 text-right main-color-blue-text dark:main-color-yellow-text transition duration-500">{{trans('shop.title.index')}}</h2>
        @include('shop._filters')
        <div class="flex flex-col">
            @if(session('message'))
                <div class="px-6 main-color-blue-bg main-color-yellow-text text-center py-4 lg:px-4 rounded-md">
                    <div class="p-2 bg-transparent items-center  leading-none lg:rounded-full flex lg:inline-flex" role="alert">
                        <span class="flex rounded-full main-color-yellow-bg main-color-blue-text uppercase px-2 py-1 text-xs font-bold mr-3">¡Atención!</span>
                        <span class="font-semibold mr-2 text-center flex-auto"> {{session('message')}}</span>
                        <svg class="fill-current opacity-75 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z"/></svg>
                    </div>
                </div>
            @endif
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden container mx-auto px-6">
                        <div class="products grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-6">

                            @if ($articles->isNotEmpty())
                                @foreach($articles as $article)
                                    <div wire:click.stop="openProductModal('{{$article->id}}')"
                                         class="w-full max-w-sm mx-auto rounded-md shadow-md overflow-hidden bg-transparent backdrop-filter
                                                transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110 cursor-pointer">
                                        <div class="flex items-end justify-end h-56 w-full bg-cover"
                                             style="background-image: url('{{ $article->image? asset('storage/img/articles/'. $article->image): URL::asset('img/no_picture.jpg')}}')">
                                        </div>
                                        <div class="flex flex-col px-5 py-3">
                                            <h2 class="text-gray-700 uppercase main-color-blue-text dark:main-color-yellow-text transition duration-500">{{$article->name}}</h2>
                                            <div class="flex justify-between items-center py-4">
                                                <span class="text-gray-500 mt-2 main-color-blue-text dark:main-color-yellow-text transition duration-500 items-center">
                                                {{number_format($article->discounted_price,2)}} €
                                                @if($article->discount>0)
                                                    <span class="line-through text-red-600">{{number_format($article->price,2) . " € "}}</span>
                                                @endif
                                                </span>
                                                @if ($cart->where('id', $article->id)->count())
                                                    <a href="{{ route('shop.cart') }}" class="p-2 rounded-full main-color-blue-bg main-color-yellow-text text-xs text-center mx-5 uppercase">Ver Carrito</a>
                                                @else
                                                    <form action="{{route('cart.store')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="article_id" value="{{$article->id}}">
                                                        <x-button x-on:click.stop="" type="submit" class="p-2 rounded-full bg-blue-600 text-white mx-5 -mb-4 hover:bg-blue-500 focus:outline-none focus:bg-blue-500 main-color-blue-bg transition duration-500">
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
                                        </div>
                                    </div>
                                @endforeach
                                @if($articles->hasMorePages())
                                    <div x-data="{
                                            observe () {
                                                let observer = new IntersectionObserver((entries) => {
                                                    entries.forEach(entry => {
                                                        if (entry.isIntersecting) {
                                                            @this.call('loadMoreProducts')
                                                        }
                                                    })
                                                }, {
                                                    root: null
                                                })
                                                observer.observe(this.$el)
                                            }
                                        }"
                                         x-init="observe">
                                        @include('shared._loading')
                                    </div>
                                @endif
                            @else
                                <p class="text-left md:text-center text-blueGray-700 text-xl">
                                    {{trans('shop.products.empty')}}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($selectedProduct)
    @php $detailProduct = $articles->filter(function($item) use($selectedProduct) {return $item->id == $selectedProduct;})->first() @endphp
    <div class="{{$productModal}} min-h-screen flex items-center justify-center px-4 container px-5 py-6 mx-auto">
        <section>
            <div class="flex items-center justify-center px-4">
                <div class="max-w-5xl bg-transparent backdrop-filter w-full rounded-lg shadow-xl">
                    <div class="flex flex-col md:flex-row max-h-md mb-5 bg-transparent shadow-lg rounded-t-lg overflow-hidden">
                        <div class="w-full md:w-1/3 bg-cover" style="background-image: url('{{ $detailProduct->image? asset('storage/img/articles/'. $detailProduct->image): URL::asset('img/no_picture.jpg')}}')"></div>
                        <div class="image-fade w-full md:w-2/3 p-4 backdrop-filter">
                            <h1 class="main-color-blue-text font-bold text-2xl">{{$detailProduct->name}}</h1>
                            <p class="main-color-blue-text mt-2 text-sm">{{$detailProduct->category->name}}</p>
                            <div class="flex item-center justify-between mt-3">
                                <h1 class="main-color-blue-text font-bold text-xl">{{number_format($detailProduct->discounted_price,2)}} €</h1>

                                @if ($cart->where('id', $detailProduct->id)->count())
                                    <a href="{{ route('shop.cart') }}" class="p-2 rounded-full main-color-blue-bg main-color-yellow-text text-xs text-center mx-5 uppercase">Ver Carrito</a>
                                @else
                                    <form action="{{route('cart.store')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="article_id" value="{{$detailProduct->id}}">
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
                    @component('articles._articleDetails', ['article' => $detailProduct]) @endcomponent
                    <div class="md:grid md:grid-cols-6 md:space-y-2 space-y-1 p-4">
                        <button wire:click="closeProductModal()"
                           class="main-color-blue-bg main-color-yellow-text transition duration-500 text-center font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1">
                            Volver
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @endif
</section>
