@extends('layout')

@section('title', 'Orders Manage')

@section('content')

    <main class="flex w-full h-auto shadow-lg rounded-3xl">
        <section class="flex flex-col pt-3 w-4/12 bg-gray-50">
            <label class="px-3">
                <input class="rounded-lg p-4 bg-gray-100 transition duration-200 focus:outline-none focus:ring-2 w-full"
                       placeholder="{{trans('orders.manage.search')}}" />
            </label>
            <label class="px-3 mt-2">
                <select class="rounded-lg p-4  main-color-blue-bg main-color-yellow-text transition duration-200 focus:outline-none focus:ring-2 w-1/2">
                    @foreach(trans('orders.manage.filters.order') as $value => $text)
                        <option value="{{ $value }}">{{ $text }}</option>
                    @endforeach
                </select>
            </label>

            <div class="h-screen overflow-y-scroll">
            <ul class="mt-6">
                @if ($orders->isNotEmpty())
                    @foreach ($orders as $row)
                    <li class="py-5  px-5 transition hover:bg-indigo-100  p-4 border-l-8
                        @if ($row->order_status == 'pendiente')
                            border-red-600
                        @elseif ($row->order_status == 'no_recogido')
                            border-yellow-500
                        @else
                            border-gray-200
                        @endif">
                        <a href="#" class="flex justify-between items-center">
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
                        </a>
                        <div class="text-md italic text-gray-400">{{$row->user->name}} ({{$row->articles->count()}} Articulos)</div>
                        <div class="text-md text-gray-400 text-right">{{$row->created_at->diffForHumans()}}</div>
                    </li>
                    @endforeach
                @else
                    <li class="py-5  px-5 transition p-4 border-r-8 border-yellow-600">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold">{{trans('orders.manage.nodata')}}</h3>
                        </div>
                    </li>
                @endif
                </ul>
            </div>
        </section>
        <section class="w-8/12 px-4 flex flex-col bg-white rounded-r-3xl">
            <div class="flex justify-between items-center h-auto border-b-2 mb-8">
                <div class="flex space-x-4 items-center">
                    <div class="h-auto w-12 rounded-full overflow-hidden">
                        <img src="{{URL::asset('img/articles/pandilla.jpg')}}" loading="lazy" class="h-full w-full object-cover" />
                    </div>
                    <div class="flex flex-col">
                        <h3 class="font-semibold text-lg">Pepe Lucas</h3>
                        <p class="text-light text-gray-400">pepe@gmail.com</p>
                    </div>
                </div>
                <div class="m-3 h-auto">
                    <button class="bg-white text-gray-800 font-bold rounded border-b-2 border-blue-500 hover:border-blue-600 hover:bg-blue-500 hover:text-white shadow-md py-2 px-6 inline-flex items-center">
                        <span class="mr-2">¡{{trans('orders.manage.collected')}}!</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                    <button class="bg-white text-gray-800 font-bold rounded border-b-2 border-red-500 hover:border-red-600 hover:bg-red-500 hover:text-white shadow-md py-2 px-6 inline-flex items-center">
                        <span class="mr-2">{{trans('orders.manage.report')}}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentcolor" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                        </svg>
                    </button>
                </div>
            </div>
                <div class="h-screen overflow-y-scroll">
                    @component('orders._orderDetails', ['order' => $orders[1]]) @endcomponent
                </div>
        </section>
    </main>

@endsection
