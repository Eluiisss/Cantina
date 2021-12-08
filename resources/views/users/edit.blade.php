<x-app-layout>
    <div class="container px-5 py-6 mx-auto">
        @include('shared._errors')
        <section class=" py-1 bg-blueGray-50">
            <div class="w-full lg:w-8/12 px-4 mx-auto mt-6">
                <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
                    <div class="rounded-t bg-white mb-0 px-6 py-6">
                        <div class="text-center flex justify-between">
                            <h6 class="text-blueGray-700 text-xl font-bold">
                                @yield('title')
                                @if($user->image)
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="{{asset('storage/img/users/'. $user->image)}}" >
                                    </div>
                                 @else
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png" >
                                    </div>
                                @endif
                            </h6>
                        </div>
                    </div>
                    <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
                        <form method="post" action="{{ route('users.update', $user) }}" enctype="multipart/form-data">
                            {{ method_field('PUT') }}
                            @include('users._fields')
                            <button class="bg-green-500 text-white active:bg-green-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150" type="submit">
                                Editar Usuario
                            </button>
                            @if(Auth::user()->hasRole('administrator') || Auth::user()->hasRole('employee') )
                            <a href="{{ route('users.index') }}" class="bg-blue-500 text-white active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150">
                                Volver
                            </a>
                            @else
                            <a href="{{ route('shop.index') }}" class="bg-blue-500 text-white active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150">
                                Volver
                            </a>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
