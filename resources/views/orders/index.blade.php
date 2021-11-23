<x-app-layout>
    <section class="text-gray-600">
        <div class="container px-5 py-24 mx-auto">
            <h2 class="text-4xl mb-5">{{trans('orders.title.index')}}</h2>
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden sm:rounded">
                            @if ($orders->isNotEmpty())
                                <table class="min-w-full">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase "> ID </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase "> Código </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase "> Estado Pedido </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase "> Estado Pago </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase "> Prodcutos </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase "> Cliente </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase "> Fecha </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Delete</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($orders as $row)
                                        <tr class="{{ $loop->index %2 == 0? "bg-white" : "bg-gray-200"}}">
                                            <td class="px-2 py-4 text-sm font-medium text-gray-900  whitespace-nowrap">{{$row->id}}</td>
                                            <td class="px-2 py-4 text-sm font-medium text-gray-900  whitespace-nowrap">{{ucfirst($row->order_code)}}</td>
                                            <td class="px-2 py-4 text-sm font-medium text-gray-900  whitespace-nowrap">{{trans("orders.list.order_status")[$row->order_status]}}</td>
                                            <td class="px-2 py-4 text-sm font-medium text-gray-900  whitespace-nowrap">{{trans("orders.list.payment_status")[$row->payment_status]}}</td>
                                            <td class="px-2 py-4 text-sm font-medium text-gray-900  whitespace-nowrap">{{$row->articles->count()}}</td>
                                            <td class="px-2 py-4 text-sm font-medium text-gray-900  whitespace-nowrap">{{$row->user->name}}</td>
                                            <td class="px-2 py-4 text-sm font-medium text-gray-900  whitespace-nowrap">{{$row->created_at}}</td>

                                            <td class="px-6 py-4 text-sm font-medium text-right  whitespace-nowrap">
                                                <a href="{{route('orders.show', $row)}}" class="text-blue-600 hover:text-blue-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium text-right  whitespace-nowrap">
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{$orders->links()}}
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
</x-app-layout>
