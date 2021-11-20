<div class="h-screen overflow-y-scroll">
    <ul class="mt-6">
        @if ($orders->isNotEmpty())
            @foreach ($orders as $row)
                <li x-data="{ select: false }"
                    x-on:click="select = ! select"
{{--                    x-bind:class="select ? 'bg-yellow-100' : 'hover:bg-indigo-100'"--}}
                    x-on:click.away="select = false"
                    class="py-5 px-5 transition p-4 border-l-8
                    @if ($row->order_status == 'pendiente')
                        border-red-600
                    @elseif ($row->order_status == 'no_recogido')
                        border-yellow-500
                    @else
                    border-gray-200
                    @endif"
                    wire:click="$emit('orderSelected', {{$row->id}})">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">PEDIDO: {{ucfirst($row->order_code)}}
                            @if ($row->order_status =='recogido')
                                ({{trans('orders.manage.collected')}})
                            @elseif ($row->order_status=='no_recogido')
                                ({{trans('orders.manage.cancel')}})
                            @endif
                        </h3>
                        <p class="text-{{($row->payment_status=='ya_pagado')? 'green-600':'red-300'}}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 15.536c-1.171 1.952-3.07 1.952-4.242 0-1.172-1.953-1.172-5.119 0-7.072 1.171-1.952 3.07-1.952 4.242 0M8 10.5h4m-4 3h4m9-1.5a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </p>
                    </div>
                    <div class="text-md italic text-gray-400">{{$row->user->name}} ({{$row->articles->count()}} Articulos)</div>
                    <div class="text-md text-gray-400 text-right">{{$row->created_at->diffForHumans()}}</div>
                </li>
            @endforeach
                @if($orders->hasMorePages())
                <li x-data="{
                            observe () {
                                let observer = new IntersectionObserver((entries) => {
                                    entries.forEach(entry => {
                                        if (entry.isIntersecting) {
                                            @this.call('loadMore')
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
                </li>
                @endif
        @else
            <li class="py-5  px-5 transition p-4 border-r-8 border-yellow-600">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold">{{trans('orders.manage.nodata')}}</h3>
                </div>
            </li>
        @endif
    </ul>
</div>

