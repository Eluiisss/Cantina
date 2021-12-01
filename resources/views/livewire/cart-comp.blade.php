<div class="flex justify-center my-6">
    <div class="flex flex-col w-full p-8 text-gray-800 bg-white shadow-lg pin-r pin-y md:w-4/5 lg:w-4/5">
      <div class="flex-1">
        <table class="w-full text-sm lg:text-base" cellspacing="0">
          <thead>
            <tr class="h-12 uppercase">
              <th class="hidden md:table-cell"></th>
              <th class="text-left">Artículo</th>
              <th class="lg:text-right text-left pl-5 lg:pl-0">
                <span class="lg:hidden" title="Quantity">Qtd</span>
                <span class="hidden lg:inline">Cantidad</span>
              </th>
              <th class="hidden text-right md:table-cell">Precio(Unidad)</th>
              <th class="text-right">Pecio Total</th>
            </tr>
          </thead>
          <tbody>
            <?php $total= 0?>
            @foreach($cart as $art)
            <tr>
              <td class="pb-4 md:table-cell">
                  <img src="{{asset('storage/img/articles/'.Session::get($art->name))}}" class="w-20 rounded" alt="IMAGEN">
              </td>
              <td>
                  <p class="mb-2 md:ml-4"> {{$art->name}}</p>
                  
                    <a wire:click.prevent="delete('{{$art->rowId}}')" href="#">
                      (Quitar objeto)
                    <a>
                  
              </td>
              <td class="justify-center md:justify-end md:flex mt-6">
                <div class="w-20 h-10">
                  <div class="relative flex flex-row w-full h-8">
                  <div class="inline-flex">
                    <button wire:click="moreQty('{{$art->rowId}}')"class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-1 px-2 rounded-l">
                      +
                    </button>
                    <p class="ml-2 mr-2">{{$art->qty}}</p>
                    <button wire:click="lessQty('{{$art->rowId}}')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-1 px-2 rounded-r">
                      -
                    </button>
                  </div>
                  </div>
                  
                </div>
              </td>
              <td class="hidden text-right md:table-cell">
                <span class="text-sm lg:text-base font-medium">
                  {{$art->price}}€
                </span>
              </td>
              <td class="text-right">
                <span class="text-sm lg:text-base font-medium">
                  {{$art->qty * $art->price}}€ <?php $total+= $art->qty * $art->price?>
                </span>
              </td>
            </tr> 
            @endforeach
          </tbody>
        </table>
        <hr class="pb-6 mt-6">
        <div class="my-4 mt-6 -mx-2 lg:flex">
          <div class="lg:px-2 lg:w-1/2">
            <div class="p-4">
              <p class="mb-4 italic">Puedes incluir sugerencias o peticiones aqui:</p>
              <textarea class="w-full h-24 p-2 bg-gray-100 rounded"></textarea>
            </div>
          </div>
          <div class="lg:px-2 lg:w-1/2">
            <div class="p-4 bg-gray-100 rounded-full">
              <h1 class="ml-2 font-bold uppercase">Detalles</h1>
            </div>
            <div class="p-4">
              <p class="mb-6 italic">Recoger en la cantina del instituto</p>
               
                  <div class="flex justify-between pt-4 border-b">
                  </div>
                  <div class="flex justify-between pt-4 border-b">
                    <div class="lg:px-4 lg:py-2 m-2 text-lg lg:text-xl font-bold text-center text-gray-800">
                      Total: {{$total}}€
                    </div>
                    <div class="lg:px-4 lg:py-2 m-2 lg:text-lg font-bold text-center text-gray-900">
                      
                    </div>
                  </div>
                <a href="{{route('shop.checkout')}}">
                  <button class="flex justify-center w-full px-10 py-3 mt-6 font-medium text-white uppercase bg-gray-800 rounded-full shadow item-center hover:bg-gray-700 focus:shadow-outline focus:outline-none">
                    <svg aria-hidden="true" data-prefix="far" data-icon="credit-card" class="w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M527.9 32H48.1C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48.1 48h479.8c26.6 0 48.1-21.5 48.1-48V80c0-26.5-21.5-48-48.1-48zM54.1 80h467.8c3.3 0 6 2.7 6 6v42H48.1V86c0-3.3 2.7-6 6-6zm467.8 352H54.1c-3.3 0-6-2.7-6-6V256h479.8v170c0 3.3-2.7 6-6 6zM192 332v40c0 6.6-5.4 12-12 12h-72c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h72c6.6 0 12 5.4 12 12zm192 0v40c0 6.6-5.4 12-12 12H236c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h136c6.6 0 12 5.4 12 12z"/></svg>
                    <span class="ml-2 mt-5px">Pagar con tajeta</span>
                  </button>
                </a>
                <a href="{{route('orders.notPayed')}}">
                  <button class="flex justify-center w-full px-10 py-3 mt-6 font-medium text-white uppercase bg-gray-800 rounded-full shadow item-center hover:bg-gray-700 focus:shadow-outline focus:outline-none">
                    <svg aria-hidden="true" data-prefix="far" data-icon="credit-card" class="w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M527.9 32H48.1C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48.1 48h479.8c26.6 0 48.1-21.5 48.1-48V80c0-26.5-21.5-48-48.1-48zM54.1 80h467.8c3.3 0 6 2.7 6 6v42H48.1V86c0-3.3 2.7-6 6-6zm467.8 352H54.1c-3.3 0-6-2.7-6-6V256h479.8v170c0 3.3-2.7 6-6 6zM192 332v40c0 6.6-5.4 12-12 12h-72c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h72c6.6 0 12 5.4 12 12zm192 0v40c0 6.6-5.4 12-12 12H236c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h136c6.6 0 12 5.4 12 12z"/></svg>
                    <span class="ml-2 mt-5px">Pagar en la cantina</span>
                  </button>
                </a>
            </div>
          </div>
        </div>
    </div>