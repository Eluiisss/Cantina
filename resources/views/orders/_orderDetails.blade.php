<div>
    <div class="p-4 border-b">
        <h2 class="text-3xl ">
            Código pedido: {{substr($order->order_code, 0 ,4)}}
        </h2>
        <p class="text-sm text-gray-500">
            Detalles del pedido.
        </p>
    </div>
    <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
        <p class="text-gray-600">
            Estado del pedido
        </p>
        <p>
            {{trans("orders.list.order_status")[$order->order_status]}}
        </p>
    </div>
    @if($order->collected_date)
        <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
            <p class="text-gray-600">
                Fecha de recogida
            </p>
            <p>
                {{$order->collected_date->toDayDateTimeString()}}
            </p>
        </div>
    @endif
    <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
        <p class="text-gray-600">
            Estado de pago
        </p>
        <p>
            {{trans("orders.list.payment_status")[$order->payment_status]}}
        </p>
    </div>
    @if($order->payment_date)
        <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
            <p class="text-gray-600">
                Fecha del pago
            </p>
            <p>
                {{$order->payment_date->toDayDateTimeString()}}
            </p>
        </div>
    @endif
    <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
        <p class="text-gray-600">
            Fecha de pedido
        </p>
        <p>
            {{$order->created_at->toDayDateTimeString()}}
        </p>
    </div>
    <div class="p-4 border-b">
        <h2 class="text-2xl ">
            Datos del pedido
        </h2>
    </div>
    @if($order->client_note)
    <div class="flex main-color-blue-bg rounded-lg p-4 mb-4 text-sm text-white">
        <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
        <div>
            <span class="font-large">{{trans('orders.manage.clientNoteText')}}</span>
            <p>{{$order->client_note}}</p>
        </div>
    </div>
    @endif
    <div class="md:grid md:grid-cols-1 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
        <p class="text-gray-600">
            Articulos
        </p>
        <ul class="py-6 border-b space-y-12 px-8">
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
                    <div class="flex flex-col col-span-3 pt-2">
                        <span class="text-gray-600 text-md font-semi-bold">
                            <a href="{{route(auth()->user()
                                    ->hasRole(['administrator', 'employee'])? 'articles.show' : 'shop.show',
                                     ['article' => $article->id])}}">{{$article->name}}</a>
                        </span>
                        <span class="text-gray-400 text-sm inline-block pt-2">{{$article->category->name}}</span>
                    </div>
                    <div class="col-span-2 pt-3 border-b">
                        <div class="flex items-center space-x-2 text-sm justify-between">
                                            <span class="text-gray-400">{{$article->pivot->quantity}} x
                                              @if($article->discount>0)
                                                    {{$article->discounted_price}}€
                                                    <span class="line-through text-red-600">
                                                            {{$article->price . " € "}}
                                                             </span>
                                                @else
                                                    {{$article->price}}€
                                                @endif
                                            </span>
                            <span class="text-red-500 font-semibold inline-block">{{number_format(($article->pivot->quantity)*($article->discounted_price),2)}}€</span>
                        </div>
                    </div>
                </li>
                @php $total_price += ($article->pivot->quantity)*($article->discounted_price) @endphp
            @endforeach
            <div class="font-semibold text-xl px-8 border-b flex justify-between py-8 text-gray-600">
                <span>Total</span>
                <span>€{{number_format($total_price, 2)}}</span>
            </div>
        </ul>
    </div>
    @if (auth()->user()->hasRole(['administrator', 'employee']))
    <div class="p-4 border-b">
        <h2 class="text-2xl ">
            Datos del cliente
        </h2>
    </div>
    <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
        <p class="text-gray-600">
            Nombre
        </p>
        <p>
            {{$order->user->name}}
        </p>
    </div>
    @if($order->user->class)
    <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
        <p class="text-gray-600">
            Clase
        </p>
        <p>
            {{$order->user->class}}
        </p>
    </div>
    @endif
    <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
        <p class="text-gray-600">
            Correo
        </p>
        <p>
            {{$order->user->email}}
        </p>
    </div>
    @if($order->user->phone)
    <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
        <p class="text-gray-600">
            Teléfono
        </p>
        <p>
            {{$order->user->phone}}
        </p>
    </div>
    @endif
        @endif
</div>
