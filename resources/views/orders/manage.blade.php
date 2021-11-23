@extends('layout')

@section('title', 'Orders Manage')

@section('content')
    <main class="flex w-full h-auto shadow-lg rounded-3xl">
        <section class="flex flex-col pt-3 w-4/12 bg-gray-50">
            @livewire('order-manage-side-bar')
        </section>
        <section class="w-8/12 px-4 flex flex-col bg-white rounded-r-3xl">
            @livewire('order-manage-detail-view')
        </section>
    </main>
@endsection
