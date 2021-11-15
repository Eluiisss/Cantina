{{ csrf_field() }}
<h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
    Detalles
</h6>
<div class="flex flex-wrap">
    <div class="w-full lg:w-12/12 px-4">
        <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="article_name">
                Nombre para la categoría
            </label>
            <input type="text" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                   name="category_name" type="text" placeholder="Nombre para la categoría" value="{{ old('category_name', $category->name) }}">
        </div>
    </div>
    <div class="w-full lg:w-12/12 px-4">
        <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                Descripción
            </label>
            <textarea type="text" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                      name="category_description" rows="4" placeholder="*Opcional Acerca de esta categoría">{{old('category_description', $category->description)}}</textarea>
        </div>
    </div>
    <div class="w-full lg:w-12/12 px-4">
        <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                Foto
            </label>
            @if($category->image)
                <div class="col-span-1 self-center">
                    <img src="{{asset('storage/img/categories/'. $category->image)}}" alt="Image" class="rounded scale-20">
                </div>
            @endif
            <input type='file'  name="category_image" />
        </div>
    </div>
</div>
