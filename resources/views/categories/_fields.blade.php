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
            <label class='flex flex-col border-4 border-dashed w-full h-32 hover:bg-gray-100 hover:border-blue-300 group'>
                <div class='flex flex-col items-center justify-center pt-7'>
                    <svg class="w-10 h-10 text-blue-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <p class='text-sm text-gray-400 group-hover:text-blue-600 pt-1 tracking-wider'>Añadir foto</p>
                </div>
                <input type='file' class="hidden" />
            </label>
        </div>
    </div>
</div>
