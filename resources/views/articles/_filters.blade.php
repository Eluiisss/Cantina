<form method="get" action="{{$view == 'index' ? route('articles.index'):route('articles.trashed')}}">
    <div class="container mx-auto">
        <div class="py-8">
            <div class="my-2 flex sm:flex-row flex-col">
                <div class="flex flex-row mb-1 sm:mb-0">
                    <div class="relative">
                        <select name="category"
                                class=" main-color-blue-bg main-color-yellow-text appearance-none h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r">
                            <option value="" selected>Cateogía (Todas)</option>
                            @foreach($categories as $value)
                                <option value="{{ $value->name }}" {{ request('category') === $value ? 'selected' : '' }} >{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if($view == 'index')
                <div class="flex flex-row mb-1 sm:mb-0">
                    <div class="relative">
                        <select name="stock"
                                class=" main-color-blue-bg main-color-yellow-text appearance-none h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r">
                            @foreach(trans('articles.filters.stock') as $value => $text)
                                <option value="{{ $value }}" {{ request('stock') === $value ? 'selected' : '' }} >{{ $text }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex flex-row mb-1 sm:mb-0">
                    <div class="relative">
                        <select name="allergy"
                                class=" main-color-blue-bg main-color-yellow-text appearance-none h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r">
                            @foreach(trans('articles.filters.allergy') as $value => $text)
                                <option value="{{ $value }}" {{ request('allergy') === $value ? 'selected' : '' }} >{{ $text }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex flex-row mb-1 sm:mb-0">
                    <div class="relative">
                        <select name="veg"
                                class="main-color-blue-bg main-color-yellow-text appearance-none h-full rounded-r border-t sm:rounded-r-none sm:border-r-0 border-r border-b block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-l focus:border-r">
                            @foreach(trans('articles.filters.veg') as $value => $text)
                                <option value="{{ $value }}" {{ request('veg') === $value ? 'selected' : '' }} >{{ $text }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif
                <div class="block relative">
                    <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current text-gray-500">
                            <path
                                d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z">
                            </path>
                        </svg>
                    </span>
                    <input name="search" placeholder="Buscar" value="{{ request('search') }}"
                           class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-3 py-2 main-color-blue-bg main-color-yellow-text  outline-none focus:ring-2 shadow-lg transform active:scale-x-75 transition-transform mx-5 flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span class="ml-2">Filtrar</span>
                </button>
            </div>
        </div>
    </div>
</form>

