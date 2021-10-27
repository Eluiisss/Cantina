@extends('layout')

@section('title', 'Articles')

@section('content')

    <section class="text-gray-600">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden sm:rounded">
                            <div>
                            <a href="{{ route('articles.create') }}" class="bg-blue-500 text-white active:bg-green-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150">
                                    Añadir nuevo producto
                                </a>
                            </div>
                            <table class="min-w-full">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase "> ID </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase "/>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase "> Nombre </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase "> Precio </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase "> Stock </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase "> ¿Alergenos? </th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase "> Categoria </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($articles as $row)
                                <tr class="{{ $loop->index %2 == 0? "bg-white" : "bg-gray-200"}}">
                                    <td class="px-2 py-4 text-sm font-medium text-gray-900  whitespace-nowrap">{{$row->id}}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <img src="{{$row->image}}" class="object-contain h-28 w-full object-scale-down">
                                    </td>
                                    <td class="px-2 py-4 text-sm font-medium text-gray-900  whitespace-nowrap">{{$row->name}}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{$row->price}} €</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{$row->stock}} unidades</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{($row->nutrition->is_allergy)? 'Si': 'No'}}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{$row->category->name}}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-right  whitespace-nowrap">
                                        <a href="#" class="text-blue-600 hover:text-blue-900"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg></a>
                                    </td>
                                </tr>
                                @endforeach

                                </tbody>
                            </table>
                            {{$articles->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
