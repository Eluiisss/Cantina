<div>
    <div>
        <div class="grid justify-items-end inline-block transition duration-500 py-4 text-3xl">
            <h1 class="px-2 main-color-blue-text dark:main-color-yellow-text transition duration-500 uppercase text-right">Control de pedidos</h1>
        </div>
        <label class="flex w-full justify-end px-3">
            <input class="rounded-lg p-4 bg-transparent transition duration-500 focus:outline-none focus:ring-2 md:w-1/2 border-r-2 border-b-2 main-color-blue-text dark:main-color-yellow-text main-color-blue-border dark:main-color-yellow-border text-right"
                   name="search" wire:model.debounce.150ms="search" value="{{ request('search') }}" placeholder="{{ trans('orders.manage.search')}}" />
        </label>
        <div class="flex w-full justify-end px-3 mt-2 py-2 my-3">
            <select name="orderStatus" wire:model="orderStatus" class="rounded-lg p-4 main-color-blue-bg main-color-yellow-text transition duration-200 focus:outline-none focus:ring-2">
                @foreach(trans('orders.manage.filters.order') as $value => $text)
                    <option value="{{ $value }}">{{ $text }}</option>
                @endforeach
            </select>
        </div>
        <div class="px-3 pt-1 my-2">
            <div class="flex items-center justify-end items-center mb-4 mx-2">
                <input id="dailyOrders" type="checkbox" wire:model="daily"
                       class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded">
                <label for="dailyOrders" class="text-sm ml-3 font-medium main-color-blue-text dark:main-color-yellow-text transition duration-500">{{trans('orders.manage.dailyCheck')}}</label>
            </div>
        </div>
    </div>

    <div>
        <ul class="flex flex-nowrap overflow-x-auto py-4 mt-6">
            @if ($orders->isNotEmpty())
                @foreach ($orders as $row)
                    <li wire:click="$emit('orderSelected', {{$row->id}})" class="flex items-center flex-auto py-5 px-2 md:px-5 transition duration-500 border-l-8 cursor-pointer {{$select==$row->id ? 'main-color-blue-bg text-white selected':'hover:bg-yellow-100'}}
                    @if ($row->order_status == 'pendiente')
                            border-red-600
                    @elseif ($row->order_status == 'no_recogido')
                            border-yellow-500
                    @else
                            border-green-200
                    @endif">
                        <div class="content">
                            <div class="flex justify-between items-center">
                                <h3 class="selected-title text-sm md:text-lg w-48 py-2 font-semibold main-color-blue-text dark:main-color-yellow-text transition duration-500">PEDIDO: {{substr($row->order_code, 0 ,4)}} @if ($row->order_status =='recogido')({{trans('orders.manage.collected')}})@elseif ($row->order_status=='no_recogido')({{trans('orders.manage.notCollected')}})@elseif ($row->order_status=='cancelado')({{trans('orders.manage.cancel')}})@endif</h3>
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="{{ ($row->payment_status=='ya_pagado') ? 'green' : 'red' }}">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 15.536c-1.171 1.952-3.07 1.952-4.242 0-1.172-1.953-1.172-5.119 0-7.072 1.171-1.952 3.07-1.952 4.242 0M8 10.5h4m-4 3h4m9-1.5a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="text-md italic text-gray-400 text-xs md:text-base">{{$row->user->name}} ({{$row->articles->count()}} Articulos)</div>
                            <div class="text-md text-gray-400 text-right text-xs md:text-base">{{$row->created_at->diffForHumans()}}</div>
                        </div>
                    </li>
                @endforeach
                @if($orders->hasMorePages())
                    <div x-data="{
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
                    </div>
                @endif
            @else
                <li class="py-5  px-5 transition p-4 border-r-8 border-yellow-600">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm md:text-lg font-semibold main-color-blue-text dark:main-color-yellow-text transition duration-500">{{trans('orders.manage.nodata')}}</h3>
                    </div>
                </li>
            @endif
        </ul>
    </div>
</div>

