<div>
    <div>
        <label class="px-3">
            <input class="rounded-lg p-4 bg-gray-100 transition duration-200 focus:outline-none focus:ring-2 w-full"
                   name="search" wire:model.debounce.150ms="search" value="{{ request('search') }}" placeholder="{{ trans('orders.manage.search')}}" />
        </label>
        <div class="px-3 mt-2 py-2 my-3">
            <select name="orderStatus" wire:model="orderStatus" class="rounded-lg p-4  main-color-blue-bg main-color-yellow-text transition duration-200 focus:outline-none focus:ring-2 w-1/2">
                @foreach(trans('orders.manage.filters.order') as $value => $text)
                    <option value="{{ $value }}">{{ $text }}</option>
                @endforeach
            </select>
        </div>
        <div class="px-3 pt-1 my-2">
            <div class="flex items-start items-center mb-4 mx-2">
                <input id="dailyOrders" type="checkbox" wire:model="daily"
                       class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded">
                <label for="dailyOrders" class="text-sm ml-3 font-medium text-gray-900">{{trans('orders.manage.dailyCheck')}}</label>
            </div>
        </div>
    </div>

    <div class="h-screen overflow-y-scroll">
        <ul class="mt-6">
            @if ($orders->isNotEmpty())
                @foreach ($orders as $row)
                    <li wire:click="$emit('orderSelected', {{$row->id}})" class="py-5 px-5 transition p-4 border-l-8 {{$select==$row->id?'bg-yellow-100':'hover:bg-indigo-100'}}
                    @if ($row->order_status == 'pendiente')
                            border-red-600
                    @elseif ($row->order_status == 'no_recogido')
                            border-yellow-500
                    @else
                            border-gray-200
                    @endif">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold">PEDIDO: {{ucfirst($row->order_code)}} @if ($row->order_status =='recogido')({{trans('orders.manage.collected')}})@elseif ($row->order_status=='no_recogido')({{trans('orders.manage.cancel')}})@endif</h3>
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
                        <h3 class="text-lg font-semibold">{{trans('orders.manage.nodata')}}</h3>
                    </div>
                </li>
            @endif
        </ul>
    </div>
</div>

