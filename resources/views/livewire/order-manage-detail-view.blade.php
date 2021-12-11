<div>
    @if($order)
        <div class="flex flex-col items-center py-2 md:py-4 h-auto border-b-2 mb-8">
            <div class="flex space-x-4 items-center">
                <div class="h-auto w-12 rounded-full overflow-hidden">
                    @if($order->user->image)
                        <div class="col-span-1 self-center">
                            <img src="{{asset('storage/img/users/'. $order->user->image)}}" alt="Image" loading="lazy" class="h-full w-full object-cover">
                        </div>
                    @else
                        <div class="col-span-1 self-center">
                            <img src="https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png" alt="Image" loading="lazy" class="h-full w-full object-cover">
                        </div>
                    @endif
                </div>
                <div class="flex flex-col">
                    <h3 class="font-semibold text-sm md:text-lg main-color-blue-text dark:main-color-yellow-text transition duration-500">{{$order->user->name}}</h3>
                    <p class="text-sm text-light text-gray-400">{{$order->user->email}}</p>
                </div>
            </div>

            <div class="m-3 h-auto">
                @if ($order->order_status =='pendiente')
                <button wire:click="setOrderAsCollected('{{$order->id}}')"
                    class="bg-white text-gray-800 font-bold rounded border-b-2 border-blue-500 hover:border-blue-600 hover:bg-blue-500 hover:text-white text-sm md:text-base shadow-md py-2 px-3 md:px-6 inline-flex items-center">
                    <span class="mr-2">¡{{trans('orders.manage.collected')}}!</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
                <button wire:click="setOrderAsNotCollected('{{$order->id}}')"
                    class="bg-white text-gray-800 font-bold rounded border-b-2 border-red-500 hover:border-red-600 hover:bg-red-500 hover:text-white text-sm md:text-base shadow-md py-2 px-3 md:px-6 inline-flex items-center">
                    <span class="mr-2">{{trans('orders.manage.report')}}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-6 md:w-6" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentcolor" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                    </svg>
                </button>
                @elseif ($order->order_status =='recogido')
                    <p class="font-semibold text-xl text-green-400"> {{trans('orders.manage.collected')}}</p>
                @elseif ($order->order_status=='no_recogido')
                    <p class="font-semibold text-xl text-red-600"> {{trans('orders.manage.notCollected')}}</p>
                @elseif ($order->order_status=='cancelado')
                    <p class="font-semibold text-xl text-yellow-600"> {{trans('orders.manage.cancel')}}</p>
                @endif
            </div>
        </div>
        <div class="h-screen overflow-y-scroll">
            @component('orders._orderDetails', ['order' => $order]) @endcomponent
        </div>
    @else
        <div class="flex justify-between items-center py-2 md:py-4 h-auto border-b-2">
            <div class="flex space-x-4 items-center">
                <div class="flex flex-col">
                    <h3 class="font-semibold text-sm md:text-lg main-color-blue-text dark:main-color-yellow-text transition duration-500">{{trans('orders.manage.clientDataHeader')}}</h3>
                    <p class="text-sm text-light text-gray-400">{{trans('orders.manage.selectOrder')}}</p>
                </div>
            </div>
        </div>
        <section class="flex items-top justify-center py-5 px-4">
            <div class="max-w-lg h-40 w-full rounded-lg shadow-lg p-4 main-color-blue-bg main-color-yellow-text">
                <h3 class="font-semibold text-lg tracking-wide">{{trans('orders.manage.selectOrder')}}</h3>
                <p class="font-light my-1">{{trans('orders.manage.selectOrderDetailed')}}</p>
            </div>
        </section>
    @endif
</div>

