<section id="cart">
    <div class="flex justify-center my-6">
        <div class="backdrop-filter flex flex-col w-full px-6 py-4 main-color-blue-text dark:main-color-yellow-text bg-transparent transition duration-500 shadow-lg pin-r pin-y md:w-4/5 lg:w-4/5">
            <h1 class="d-flex md:py-12 text-right text-2xl md:text-3xl uppercase">Tu Carrito</h1>
            <div class="flex-1">
                <table class="w-full text-xs md:text-sm lg:text-base" cellspacing="0">
                    <thead>
                    <tr class="h-12 uppercase">
                        <th class="hidden md:table-cell lg:text-center">Artículo</th>
                        <th class="hidden md:table-cell lg:text-center lg:pl-0 pl-5">Cantidad</th>
                        <th class="hidden md:table-cell text-right">Precio(Unidad)</th>
                        <th class="hidden md:table-cell text-right">Precio Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $total= 0?>
                    @foreach($cart as $art)
                        <tr>
                            <td class="pb-4 sm:table-cell">
                                <div class="flex items-center">
                                    <x-button wire:click.prevent="delete('{{$art->rowId}}')">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="24" height="24" rx="12" fill="#E20000"/>
                                            <path d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z" fill="white"/>
                                        </svg>
                                    </x-button>
                                    <img src="{{asset('storage/img/articles/'.Session::get($art->name.''.$art->id))}}" class="w-20 rounded" alt="IMAGEN">
                                    <p class="hidden mb-2 px-4 md:ml-4 sm:block text-center"> {{$art->name}}</p>
                                </div>
                            </td>
                            <td class="justify-center sm:justify-end mt-6">
                                <div class="w-20 h-10 relative flex flex-row justify-center w-full h-8">
                                    <div class="inline-flex">
                                        <x-button wire:click="lessQty('{{$art->rowId}}')" class="text-base main-color-blue-text dark:main-color-yellow-text">
                                            -
                                        </x-button>
                                        <p class="flex justify-center items-center ml-2 mr-2">{{$art->qty}}</p>
                                        <x-button wire:click="moreQty('{{$art->rowId}}')" class="text-base main-color-blue-text dark:main-color-yellow-text">
                                            +
                                        </x-button>
                                    </div>
                                </div>
                            </td>
                            <td class="hidden text-right md:table-cell">
                                <span class="text-sm lg:text-base font-medium">
                                  {{number_format($art->price,2)}} €
                                </span>
                            </td>
                            <td class="text-right">
                                <span class="text-sm lg:text-base font-medium">
                                  {{number_format(($art->qty * $art->price),2)}} € <?php $total+= $art->qty * $art->price?>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <hr class="pb-6 mt-6 main-color-blue-text dark:main-color-yellow-text transition duration-500">
                <div class="my-4 mt-6 -mx-2 lg:flex">
                    <div class="lg:px-2 lg:w-1/2">
                        <div class="p-4">
                            <p class="mb-4 italic">Puedes incluir sugerencias o peticiones aqui:</p>
                            <textarea name="client_note" wire:model.lazy="client_note" wire:change="setClientNote()" class="w-full h-24 p-2 bg-transparent main-color-yellow-border rounded"></textarea>
                            <p class="italic">Máximo 1000 caracteres</p>
                        </div>
                    </div>
                    <div class="lg:px-2 lg:w-1/2">
                        <div class="p-4 main-color-blue-bg main-color-yellow-text rounded-full">
                            <h1 class="ml-2 font-bold uppercase">Detalles</h1>
                        </div>
                        <div class="p-4">
                            <p class="mb-6 italic">Recoger en la cantina del instituto</p>
                            <div class="flex justify-between pt-4 main-color-yellow-border border-b"></div>
                            <div class="flex justify-between main-color-yellow-border border-b">
                                <div class="lg:py-2 m-2 text-lg lg:text-xl font-bold text-center main-color-blue-text dark:main-color-yellow-text transition duration-500">
                                    Total: {{number_format($total,2)}} €
                                </div>
                            </div>
                            @if(Auth::user()->credit >= $total)
                                <a href="{{route('orders.newPayedOrder')}}">
                                    <button class="flex items-center justify-center w-full px-10 py-3 mt-6 font-medium uppercase main-color-blue-bg main-color-yellow-text transition duration-500 rounded-full shadow item-center focus:shadow-outline focus:outline-none">
                                        <svg aria-hidden="true" data-prefix="far" data-icon="credit-card" class="w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M527.9 32H48.1C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48.1 48h479.8c26.6 0 48.1-21.5 48.1-48V80c0-26.5-21.5-48-48.1-48zM54.1 80h467.8c3.3 0 6 2.7 6 6v42H48.1V86c0-3.3 2.7-6 6-6zm467.8 352H54.1c-3.3 0-6-2.7-6-6V256h479.8v170c0 3.3-2.7 6-6 6zM192 332v40c0 6.6-5.4 12-12 12h-72c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h72c6.6 0 12 5.4 12 12zm192 0v40c0 6.6-5.4 12-12 12H236c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h136c6.6 0 12 5.4 12 12z"/></svg>
                                        <span class="ml-2 mt-5px">Usar Crédito ( {{number_format((Auth::user()->credit), 2)}} € )</span>
                                    </button>
                                </a>
                            @else
                                <a href="#">
                                    <button class="flex items-center justify-center w-full px-10 py-3 mt-6 font-medium main-color-yellow-text transition duration-500 uppercase bg-red-800 rounded-full shadow item-center hover:bg-gray-700 focus:shadow-outline focus:outline-none">
                                        <svg aria-hidden="true" data-prefix="far" data-icon="credit-card" class="w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M527.9 32H48.1C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48.1 48h479.8c26.6 0 48.1-21.5 48.1-48V80c0-26.5-21.5-48-48.1-48zM54.1 80h467.8c3.3 0 6 2.7 6 6v42H48.1V86c0-3.3 2.7-6 6-6zm467.8 352H54.1c-3.3 0-6-2.7-6-6V256h479.8v170c0 3.3-2.7 6-6 6zM192 332v40c0 6.6-5.4 12-12 12h-72c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h72c6.6 0 12 5.4 12 12zm192 0v40c0 6.6-5.4 12-12 12H236c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h136c6.6 0 12 5.4 12 12z"/></svg>
                                        <span class="ml-2 mt-5px">Crédito insuficiente( {{number_format((Auth::user()->credit), 2)}} € )</span>
                                    </button>
                                </a>
                            @endif
                            <a href="{{route('orders.newOrder')}}">
                                <button class="flex items-center justify-center w-full px-10 py-3 mt-6 font-medium main-color-blue-bg main-color-yellow-text transition duration-500 uppercase rounded-full shadow item-center hover:bg-gray-700 focus:shadow-outline focus:outline-none">
                                    <span class="ml-2 mt-5px">Pagar en la cantina</span>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

