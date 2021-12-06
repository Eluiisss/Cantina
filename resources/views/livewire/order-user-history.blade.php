<section class="text-gray-600">

    <div class="px-12">
        <h2 class="text-4xl mb-5 text-right pt-5">{{trans('orders.userHistory.title')}}</h2>
        <div class="relative">
            @if($orders->isNotEmpty())
                <ul class="rounded-md shadow-md bg-white absolute left-0 right-0 -bottom-18 mt-3 p-3">
                    <li class="text-lg uppercase text-gray-400 border-b border-gray border-solid py-2 px-5 mb-2">
                        {{trans('orders.userHistory.currentOrders')}}
                    </li>
                    @foreach($orders->filter(function($item) {return $item->order_status == 'pendiente';})->all() as $row)
                        @include('orders.user_history._userOrderRow', ['color' => "blue", 'hover' => "yellow"])
                    @endforeach
                    <li class="text-lg uppercase text-gray-400 border-b border-gray border-solid py-2 px-5 mb-2">
                        {{trans('orders.userHistory.processedOrders')}}
                    </li>
                    @foreach($orders->filter(function($item) {return $item->order_status == 'recogido';})->all() as $row)
                       @include('orders.user_history._userOrderRow',['color' => "green",'hover' => "blue"])
                    @endforeach
                    @foreach($orders->filter(function($item) {return $item->order_status == 'no_recogido';})->all() as $row)
                        @include('orders.user_history._userOrderRow',['color' => "yellow", 'hover' => "red"])
                    @endforeach
                </ul>
            @else
                <ul class="rounded-md shadow-md bg-white absolute left-0 right-0 -bottom-18 mt-3 p-3">
                    <li class="grid grid-cols-10 gap-4 justify-center items-center px-4 py-2 rounded-lg">
                        <div class="col-start-2 col-end-11 pl-8 border-l-2 border-solid border-gray">
                            <h3 class="text-gray-900  text-md font-semibold">{{trans('orders.userHistory.noOrdersTitle')}}</h3>
                            <p class="text-gray-600 mt-1 font-regular text-sm">
                                {{trans('orders.userHistory.noOrdersAbout')}}
                            </p>
                        </div>
                    </li>
                </ul>
            @endif
        </div>
    </div>

    <div class="{{$orderModal}} modal h-screen w-full fixed left-0 top-0 flex justify-center items-center bg-black bg-opacity-50">
        <main class="container mx-auto max-w-screen-lg h-full">
            <div  class="relative h-full flex flex-col bg-white shadow-xl rounded-md" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);" ondragleave="dragLeaveHandler(event);" ondragenter="dragEnterHandler(event);">
                <div class="h-screen overflow-y-scroll">
                    @if($selectedOrder)
                        @php $detailOrder = $orders->filter(function($item) use($selectedOrder) {return $item->id == $selectedOrder;})->first() @endphp
                        @component('orders._orderDetails', ['order' => $detailOrder]) @endcomponent
                    @endif
                </div>
                <footer class="flex justify-end px-8 pb-8 pt-4">
                    @if($selectedOrder)
                        @if($detailOrder->order_status == 'pendiente')
                        <a href="{{route('orders.cancel',['order' => $selectedOrder ])}}">
                            <button id="submit" class="rounded-sm px-3 py-1 bg-blue-700 hover:bg-blue-500 text-white focus:shadow-outline focus:outline-none">
                                {{trans('orders.userHistory.modalCancelOrder')}}
                            </button>
                        </a>
                        @endif
                    @endif
                    <button wire:click="closeOrderModal()" id="cancel" class="ml-3 rounded-sm px-3 py-1 hover:bg-gray-300 focus:shadow-outline focus:outline-none">
                        {{trans('orders.userHistory.modalBack')}}
                    </button>
                </footer>
            </div>
        </main>
    </div>
</section>




