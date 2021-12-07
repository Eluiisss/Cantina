<section>
    <div class="flex flex-col backdrop-filter container mx-auto">
        <input class="py-4 px-4 rounded mb-8 focus:outline-none focus:shadow-outline text-sm md:text-base text-right main-color-blue-text dark:main-color-yellow-text transition duration-500 shadow-lg"
               wire:model.debounce.150ms="search" name="search" placeholder="¿Qué te apetece tomar?" value="{{ request('search') }}">
        <nav class="flex justify-end">
            <select wire:model.lazy="category" name="category" id="category" class="main-color-blue-bg main-color-yellow-text">
                <option value="null">Escoge una categoría</option>
                @foreach($categories as $value)
                    <option wire:key="filterCategory('{{$value->name}}')" value="{{$value->name}}"
                            class="no-underline py-2 px-4 font-medium mr-3 {{$category == $value->name ? 'main-color-blue-bg main-color-yellow-text' : 'main-color-yellow-bg main-color-blue-text'}} hover:bg-yellow-400 hover:text-black"
                            {{ request('category') == $value->name ? 'selected' : '' }}>{{ $value->name }}</option>
                @endforeach
            </select>
        </nav>
        <div class="flex-auto text-right px-2 pt-4 my-2">
            <div class="mb-4 mx-2 inline-block">
                <input id="veg" type="checkbox" wire:model="veg"
                       class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded">
                <label for="veg" class="text-sm ml-3 font-medium main-color-blue-text dark:main-color-yellow-text transition duration-500">{{trans('shop.products.vegetarian')}}</label>
            </div>
            <div class="mb-4 mx-2 inline-block">
                <input id="allergy" type="checkbox" wire:model="allergy"
                       class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded">
                <label for="allergy" class="text-sm ml-3 font-medium main-color-blue-text dark:main-color-yellow-text transition duration-500">{{trans('shop.products.allegy')}}</label>
            </div>
        </div>
    </div>
</section>

