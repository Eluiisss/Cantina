{{ csrf_field() }}
<h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
    Detalles
</h6>
<div class="flex flex-wrap">
    <div class="w-full lg:w-12/12 px-4">
        <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="user_name">
                Nombre
            </label>
            <input type="text" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                   name="user_name" type="text" placeholder="Nombre usuario" value="{{ old('user_name', $user->name) }}">
        </div>
    </div>
    
    @if(Auth::user()->hasRole('administrator') || Auth::user()->hasRole('employee') )
    <div class="w-full lg:w-12/12 px-4">
        <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="user_credit">
                Crédito
            </label>
            <input type="number" step="any" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                   name="user_credit" placeholder="Crédito" value="{{ old('user_credit', $user->credit) }}">
        </div>
    </div>
    @endif

    <div class="w-full lg:w-12/12 px-4">
        <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="user_class">
                Clase
            </label>
            <input type="text" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                   name="user_class" type="text" placeholder="clase del usuario" value="{{ old('user_class', $user->class) }}">
        </div>
    </div>

    <div class="w-full lg:w-12/12 px-4">
        <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="user_phone">
                Teléfono
            </label>
            <input type="text" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                   name="user_phone" type="text" placeholder="Telefono del usuario" value="{{ old('user_phone', $user->phone) }}">
        </div>
    </div>

    <div class="w-full lg:w-12/12 px-4">
        <div class="relative w-full mb-3">
            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" for="user_email">
                email
            </label>
            <input type="text" class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                   name="user_email" type="text" placeholder="Email del usuario" value="{{ old('user_email', $user->email) }}">
        </div>
    </div>
</div>


