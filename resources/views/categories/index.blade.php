@extends('layout')

@section('title', 'Categories')

@section('content')

    <section class="text-gray-600">
        <div class="container px-5 py-24 mx-auto">
            <h2 class="text-4xl mb-5">{{trans('categories.title.index')}}</h2>
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden sm:rounded">
                            <div>
                                <a href="{{route('categories.create')}}" class="bg-blue-500 text-white active:bg-green-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150">
                                    Nueva categoría
                                </a>
                            </div>
                            @if ($categories->isNotEmpty())
                                <table class="min-w-full">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase "> ID </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase "/>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase "> Nombre </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase "> Acerca de </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Delete</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($categories as $row)
                                        <tr class="{{ $loop->index %2 == 0? "bg-white" : "bg-gray-200"}}">
                                            <td class="px-2 py-4 text-sm font-medium text-gray-900  whitespace-nowrap">{{$row->id}}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                <img src="{{$row->image}}" class="object-contain h-28 w-full object-scale-down">
                                            </td>
                                            <td class="px-2 py-4 text-sm font-medium text-gray-900  whitespace-nowrap">{{$row->name}}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{$row->description ?(Str::limit(($row->description), 20, '...')): "Sin descripción"}}</td>
                                            <td class="px-6 py-4 text-sm font-medium text-right  whitespace-nowrap">
                                                <a href="{{route('categories.show', $row)}}" class="text-blue-600 hover:text-blue-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                <a href="{{route('categories.edit', $row)}}" class="text-blue-600 hover:text-blue-900"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                    </svg>
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium text-right  whitespace-nowrap">
                                                @if(!$row->articles()->exists())
                                                <form action="{{ route('categories.destroy', $row->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-blue-600 hover:text-blue-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{$categories->links()}}
                            @else
                                <p class="text-left md:text-center text-blueGray-700 text-xl">
                                    {{trans('ui_elements.lists.empty')}}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
