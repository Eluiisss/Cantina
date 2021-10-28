@extends('layout')

@section('title', 'Articles')

@section('content')

    <section class="text-gray-600">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden sm:rounded">
                            @if(!request()->routeIs('articles.trashed'))
                            <div>
                            <a href="{{ route('articles.create') }}" class="bg-blue-500 text-white active:bg-green-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150">
                                    Añadir nuevo producto
                            </a>
                            <a href="{{ route('articles.trashed') }}" class="bg-blue-500 text-white active:bg-green-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150">
                                Ver papelera
                            </a>
                            </div>
                            @else
                                <div>
                                <a href="{{ route('articles.index') }}" class="bg-blue-500 text-white active:bg-green-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150">
                                    Volver
                                </a>
                                </div>
                            @endif
                        @if ($articles->isNotEmpty())
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
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Delete</span>
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
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{optional($row->nutrition)->is_allergy? 'Si': 'No'}}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{$row->category->name}}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-right  whitespace-nowrap">
                                    @if(request()->routeIs('articles.trashed'))
                                            <a href="{{ route('articles.restore', $row->id) }}" class="text-blue-600 hover:text-blue-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.707 3.293a1 1 0 010 1.414L5.414 7H11a7 7 0 017 7v2a1 1 0 11-2 0v-2a5 5 0 00-5-5H5.414l2.293 2.293a1 1 0 11-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"></path>
                                                </svg>
                                            </a>
                                    @else
                                        <a href="{{ route('articles.show', $row) }}" class="text-blue-600 hover:text-blue-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('articles.edit', $row) }}" class="text-blue-600 hover:text-blue-900"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </a>
                                    @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-right  whitespace-nowrap">
                                        @if(request()->routeIs('articles.trashed'))
                                            <form action="{{ route('articles.destroy', $row->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-blue-600 hover:text-blue-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('articles.trash', $row) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-blue-600 hover:text-blue-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$articles->links()}}
                        @else
                                    <p class="text-left md:text-center text-blueGray-700 text-xl">
                                        Sin datos
                                    </p>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
