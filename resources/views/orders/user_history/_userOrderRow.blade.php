<li wire:click="openOrderModal('{{$row->id}}')"
    class="grid grid-cols-10 gap-4 justify-center items-center cursor-pointer px-4 py-2 rounded-lg hover:bg-{{$hover}}-100">
    <div class="flex justify-center items-center">
        <svg  class="h-20 w-20 text-{{$color}}-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
        </svg>
    </div>
    <div class="col-start-2 col-end-11 pl-8 border-l-2 border-solid border-gray">
        <h3 class="text-gray-900  text-md font-semibold">PEDIDO: {{substr($row->order_code, 0 ,4)}} @if ($row->order_status =='recogido')({{trans('orders.manage.collected')}})@elseif ($row->order_status=='no_recogido')({{trans('orders.manage.cancel')}})@endif</h3>
        <div class="text-md italic text-gray-400">Total del pedido: ({{$row->articles->count()}} Articulos)</div>
        @php $total_price = 0  @endphp
        <span class="text-md italic text-gray-400">
            Productos:
        @foreach($row->articles as $article)
            {{$article->name}} x {{$article->pivot->quantity}} ({{number_format($article->pivot->quantity*$article->discounted_price,2)}} €)
           @if(!$loop->last)
               ,
            @endif
            @php $total_price += ($article->pivot->quantity)*($article->discounted_price) @endphp
        @endforeach
      </span>
        <div class="text-md italic text-gray-400">{{($row->payment_status=='ya_pagado')? 'Pagado':'Sin pagar'}}</div>
        <span class="text-md italic text-gray-400">Importe total: €{{number_format($total_price, 2)}}</span>
        <div class="text-md text-gray-400 text-right">{{$row->created_at->diffForHumans()}}</div>
    </div>
</li>
