
<section class="bg-blue-100 h-30 p-8">
    <div class="container mx-auto">
        <input class="w-full h-16 px-3 rounded mb-8 focus:outline-none focus:shadow-outline text-xl px-8 shadow-lg"
               wire:model.debounce.150ms="search" name="search" placeholder="Buscar" value="{{ request('search') }}">
        <nav class="flex">
            @foreach($categories as $value)
                <button wire:click="filterCategory('{{$value->name}}')"
                    class="no-underline py-2 px-4 font-medium mr-3 {{$category == $value->name ? 'main-color-blue-bg text-white':'bg-yellow-500 text-black'}}  hover:bg-yellow-400 hover:text-black">{{ $value->name }}</button>
            @endforeach
        </nav>
        <div class="px-2 pt-4 my-2">
            <div class="mb-4 mx-2 inline-block">
                <input id="veg" type="checkbox" wire:model="veg"
                       class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded">
                <label for="veg" class="text-sm ml-3 font-medium text-gray-900">{{trans('shop.products.vegetarian')}}</label>
            </div>
            <div class="mb-4 mx-2 inline-block">
                <input id="allergy" type="checkbox" wire:model="allergy"
                       class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded">
                <label for="allergy" class="text-sm ml-3 font-medium text-gray-900">{{trans('shop.products.allegy')}}</label>
            </div>
        </div>
    </div>
</section>

