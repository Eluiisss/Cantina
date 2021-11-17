@extends('layout')

@section('title', 'Order')

@section('content')

    <section>
        <div class="min-h-screen flex items-center justify-center px-4">
            <div class="max-w-4xl  bg-white w-full rounded-lg shadow-xl">
                @component('orders._orderDetails', ['order' => $order]) @endcomponent
                <div class="md:grid md:grid-cols-6 md:space-y-2 space-y-1 p-4">
                    <a href="{{ route('orders.index') }}"
                       class="bg-blue-500 text-white text-center active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150">
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
