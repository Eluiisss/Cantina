<div>
    <div class="p-4 border-b">
        <h2 class="text-3xl main-color-blue-text dark:main-color-yellow-text transition duration-500">
            Código pedido: {{substr($order->order_code, 0 ,4)}}
        </h2>
        <p class="text-sm main-color-blue-text dark:main-color-yellow-text transition duration-500">Detalles del pedido.</p>
    </div>
    <div class="md:grid md:grid-cols-2 md:space-y-0 space-y-1 p-4 border-b">
        <p class="main-color-blue-text dark:main-color-yellow-text transition duration-500">Estado del pedido</p>
        <p class="main-color-blue-text dark:main-color-yellow-text transition duration-500">{{trans("orders.list.order_status")[$order->order_status]}}</p>
    </div>
    @if($order->collected_date)
        <div class="md:grid md:grid-cols-2 md:space-y-0 space-y-1 p-4 border-b">
            <p class="main-color-blue-text dark:main-color-yellow-text transition duration-500">Fecha de recogida</p>
            <p class="main-color-blue-text dark:main-color-yellow-text transition duration-500">{{$order->collected_date->toDayDateTimeString()}}</p>
        </div>
    @endif
    <div class="md:grid md:grid-cols-2 md:space-y-0 space-y-1 p-4 border-b">
        <p class="main-color-blue-text dark:main-color-yellow-text transition duration-500">Estado de pago</p>
        <p class="main-color-blue-text dark:main-color-yellow-text transition duration-500">{{trans("orders.list.payment_status")[$order->payment_status]}}</p>
    </div>
    @if($order->payment_date)
        <div class="md:grid md:grid-cols-2 md:space-y-0 space-y-1 p-4 border-b">
            <p class="main-color-blue-text dark:main-color-yellow-text transition duration-500">Fecha del pago </p>
            <p class="main-color-blue-text dark:main-color-yellow-text transition duration-500">{{$order->payment_date->toDayDateTimeString()}}</p>
        </div>
    @endif
    <div class="md:grid md:grid-cols-2 md:space-y-0 space-y-1 p-4 border-b">
        <p class="main-color-blue-text dark:main-color-yellow-text transition duration-500">Fecha de pedido</p>
        <p class="main-color-blue-text dark:main-color-yellow-text transition duration-500">{{$order->created_at->toDayDateTimeString()}}</p>
    </div>
    <div class="p-4 border-b">
        <h2 class="text-2xl main-color-blue-text dark:main-color-yellow-text transition duration-500">
            Datos del pedido
        </h2>
    </div>
    <div class="md:grid md:grid-cols-1 md:space-y-0 space-y-1 p-4 border-b">
        <p class="main-color-blue-text dark:main-color-yellow-text transition duration-500">Articulos</p>
        <ul class="py-6 space-y-12 px-3 md:px-8">
            @php $total_price = 0  @endphp
            @foreach ($order->articles as $article)
                <li class="grid grid-cols-6 gap-2 border-b-1">
                    <div class="col-span-1 self-center">
                        @if($article->image)
                            <img src="{{asset('storage/img/articles/'. $article->image)}}" alt="Product" class="rounded w-full">
                        @else
                            <img src="{{URL::asset('img/no_picture.jpg')}}" alt="Product" class="rounded w-full">
                        @endif
                    </div>
                    <div class="flex flex-col items-center justify-center col-span-3 pt-2 px-4 md:px-1">
                        <span class="main-color-blue-text dark:main-color-yellow-text transition duration-500 text-sm md:text-md text-center font-semi-bold">
                            <a href="{{route(auth()->user()->hasRole(['administrator', 'employee'])? 'articles.show' : 'shop.show',
                                     ['article' => $article->id])}}">{{$article->name}}</a>
                        </span>
                        <span class="main-color-blue-text dark:main-color-yellow-text transition duration-500 text-xs md:text-sm text-center inline-block pt-2">{{$article->category->name}}</span>
                    </div>
                    <div class="flex items-center justify-center col-span-2 pt-3 border-b">
                        <div class="flex flex-col items-center space-x-2 text-sm justify-between">
                            <span class="main-color-blue-text dark:main-color-yellow-text transition duration-500 text-sm md:text-md text-center">{{$article->pivot->quantity}} x
                              @if($article->discount>0)
                                {{$article->discounted_price}}€
                                <span class="line-through text-red-600 text-sm md:text-md text-center">
                                    {{$article->price . " € "}}
                                </span>
                            @else
                                {{$article->price}}€
                            @endif
                            </span>
                            <span class="text-red-500 transition duration-500 font-semibold inline-block">{{number_format(($article->pivot->quantity)*($article->discounted_price),2)}}€</span>
                        </div>
                    </div>
                </li>
                @php $total_price += ($article->pivot->quantity)*($article->discounted_price) @endphp
            @endforeach
            <div class="font-semibold text-xl px-8 border-b flex justify-between py-8 main-color-blue-text dark:main-color-yellow-text transition duration-500">
                <span>Total</span>
                <span>€{{number_format($total_price, 2)}}</span>
            </div>
        </ul>
    </div>
    @if (auth()->user()->hasRole(['administrator', 'employee']))
    <div class="p-4 border-b">
        <h2 class="text-2xl main-color-blue-text dark:main-color-yellow-text transition duration-500">
            Datos del cliente
        </h2>
    </div>
    <div class="md:grid md:grid-cols-2 md:space-y-0 space-y-1 p-4 border-b">
        <p class="main-color-blue-text dark:main-color-yellow-text transition duration-500">Nombre</p>
        <p class="main-color-blue-text dark:main-color-yellow-text transition duration-500">{{$order->user->name}}</p>
    </div>
    <div class="md:grid md:grid-cols-2 md:space-y-0 space-y-1 p-4 border-b">
        <p class="main-color-blue-text dark:main-color-yellow-text transition duration-500">Clase</p>
        <p class="main-color-blue-text dark:main-color-yellow-text transition duration-500">{{$order->user->class}}</p>
    </div>
    <div class="md:grid md:grid-cols-2 md:space-y-0 space-y-1 p-4 border-b">
        <p class="main-color-blue-text dark:main-color-yellow-text transition duration-500">Correo</p>
        <p class="main-color-blue-text dark:main-color-yellow-text transition duration-500">{{$order->user->email}}</p>
    </div>
    <div class="md:grid md:grid-cols-2 md:space-y-0 space-y-1 p-4 border-b">
        <p class="main-color-blue-text dark:main-color-yellow-text transition duration-500">Teléfono</p>
        <p class="main-color-blue-text dark:main-color-yellow-text transition duration-500">{{$order->user->phone}}</p>
    </div>
    @endif
</div>
