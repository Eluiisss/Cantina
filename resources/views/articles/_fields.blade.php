{{ csrf_field() }}
<h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
    Detalles
</h6>
<div class="flex flex-wrap">
    <div class="w-full lg:w-12/12 px-4">
        <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="article_name">
                Nombre del prodcuto
            </label>
            <input type="text" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                   name="article_name" type="text" placeholder="Nombre del prodcuto" value="{{ old('article_name', $article->name) }}">
        </div>
    </div>
    <div class="w-full lg:w-12/12 px-4">
        <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="article_category">
                Categoría
            </label>
            <select class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                    name="article_category">
                <option value="">Selecciona una categoría</option>
                @foreach($categories as $value)
                    <option value="{{ $value->id }}" {{(old('article_category', $article->category_id) == $value->id ) ? ' selected' : '' }}>{{$value->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="w-full lg:w-4/12 px-4">
        <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="article_price">
                Precio
            </label>
            <input type="number" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                   name="article_price" type="number" min="0" max="10000" step="0.01" placeholder="Precio" value="{{ old('article_price', $article->price) }}">
        </div>
    </div>
    <div class="w-full lg:w-4/12 px-4">
        <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="article_stock">
                Stock
            </label>
            <input type="number" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                   name="article_stock" type="number" min="0" max="1000" placeholder="0-1000" value="{{ old('article_stock', $article->stock) ?? 0 }}">
        </div>
    </div>
    <div class="w-full lg:w-4/12 px-4">
        <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="article_discount">
                Descuento %
            </label>
            <input type="number" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                   name="article_discount" type="number" min="0" max="100"  placeholder="0% - 100%" value="{{ old('article_discount', $article->discount ?? 0) }}">
        </div>
    </div>

</div>

<hr class="mt-6 border-b-1 border-blueGray-300">

<h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
    Informacion nutricional
</h6>
<div class="flex flex-wrap">
    <div class="w-full lg:w-4/12 px-4">
        <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="article_calories">
                Calorías
            </label>
            <input type="number" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                   name="article_calories" type="number" min="0" max="5000" step="0.1" placeholder="Ej. 1000 kcal" value="{{ old('article_calories', optional($article->nutrition)->calories) }}">
        </div>
    </div>
    <div class="w-full lg:w-4/12 px-4">
        <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="article_sodium">
                Sal
            </label>
            <input type="number" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                   name="article_sodium" type="number" min="0" max="500" step="0.1" placeholder="Ej. 2.5g" value="{{ old('article_sodium', optional($article->nutrition)->sodium) }}">
        </div>
    </div>
    <div class="w-full lg:w-4/12 px-4">
        <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="article_proteins">
                Proteínas
            </label>
            <input type="number" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                   name="article_proteins" type="number" min="0" max="200" step="0.1" placeholder="Ej. 100g" value="{{ old('article_proteins', optional($article->nutrition)->proteins) }}">
        </div>
    </div>
    <div class="w-full lg:w-6/12 px-4">
        <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="article_proteins">
                Apto para vegetarianos
            </label>
            <div>
                @foreach(trans('articles.forms.status') as $state => $label)
                    <label class="inline-flex items-center">
                        <input type="radio" class="form-radio" name="article_veg" id="article_veg_{{ $state }}" value="{{ $state }}"
                            {{ old('article_veg', optional($article->nutrition)->is_veg) == $state ? 'checked' : ''}}>
                        <span class="ml-2">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>
    </div>
    <div class="w-full lg:w-12/12 px-4">
        <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                Ingredientes
            </label>
            <textarea type="text" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                      name="article_ingredients_description" rows="4" placeholder="Opcional* Descripción detallada">{{old('article_ingredients_description', optional($article->nutrition)->ingredients_description)}}</textarea>
        </div>
    </div>
</div>

<hr class="mt-6 border-b-1 border-blueGray-300">

<h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
    Alergenos
</h6>
<div class="flex flex-wrap">
    <div class="w-full lg:w-6/12 px-4">
        <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="article_proteins">
                Contiene alargenos
            </label>
            <div>
                @foreach(trans('articles.forms.status') as $state => $label)
                    <label class="inline-flex items-center">
                        <input type="radio" class="form-radio" name="article_allergy" id="article_allergy_{{ $state }}" value="{{ $state }}"
                            {{ old('article_allergy', optional($article->nutrition)->is_allergy) == $state ? 'checked' : ''}}>
                        <span class="ml-2">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>
    </div>
    <div class="w-full lg:w-12/12 px-4">
        <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlfor="grid-password">
                Descripción
            </label>
            <textarea type="text" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                      name="article_allergy_description" rows="4" placeholder="Descripción minuciosa">{{old('article_allergy_description', optional($article->nutrition)->allergy_description)}}</textarea>
        </div>
    </div>
</div>
