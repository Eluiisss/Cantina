@extends('layout')

@section('title', 'Orders Manage')

@section('content')
    <main class="flex w-full h-auto shadow-lg rounded-3xl">
        <section class="flex flex-col pt-3 w-4/12 bg-gray-50">
            <form method="get" action="{{ route('orders.manage') }}">
                <label class="px-3">
                    <input class="rounded-lg p-4 bg-gray-100 transition duration-200 focus:outline-none focus:ring-2 w-full"
                           name="search" value="{{ request('search') }}" placeholder="{{trans('orders.manage.search')}}" />
                </label>

                <div class="text-right">
                    <button type="submit" class="btn btn-sm btn-primary">Filtrar</button>
                </div>
            </form>
            <label class="px-3 mt-2">
                <select class="rounded-lg p-4  main-color-blue-bg main-color-yellow-text transition duration-200 focus:outline-none focus:ring-2 w-1/2">
                    @foreach(trans('orders.manage.filters.order') as $value => $text)
                        <option value="{{ $value }}">{{ $text }}</option>
                    @endforeach
                </select>
            </label>
            @livewire('order-manage-side-bar')
        </section>
        <section class="w-8/12 px-4 flex flex-col bg-white rounded-r-3xl">
            @livewire('order-manage-detail-view')
        </section>
    </main>
@endsection
