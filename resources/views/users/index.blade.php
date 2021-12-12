<x-app-layout>
    <div class="container px-5 py-6 mx-auto">
        <div class="filters w-full inline-block">
            @include('users._filters')
        </div>
        @if(session('key'))
        <div class="px-6 main-color-blue-bg main-color-yellow-text text-center py-4 lg:px-4 rounded-md">
            <div class="p-2 bg-transparent items-center  leading-none lg:rounded-full flex lg:inline-flex" role="alert">
                <span class="flex rounded-full main-color-yellow-bg main-color-blue-text uppercase px-2 py-1 text-xs font-bold mr-3">¡Apunte la clave!</span>
                <span class="font-semibold mr-2 text-center flex-auto"> {{session('key')}}</span>
            </div>
        </div>
        @endif
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow-lg overflow-hidden rounded-md">
                        <table class="min-w-full">
                            <thead class="bg-gray-50 dark:main-color-blue-bg transition duration-500">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-bold main-color-blue-text dark:main-color-yellow-text transition duration-500 uppercase tracking-wider">
                                    Datos de usuario
                                </th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-bold main-color-blue-text dark:main-color-yellow-text transition duration-500 uppercase tracking-wider hidden md:block">
                                    Acciones
                                </th>

                            </tr>
                            </thead>
                            <tbody class="backdrop-filter bg-transparent">
                            @foreach ($users as $row)
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap" x-data="{ open: false }">
                                        <button class="cursor-pointer md:cursor-default" @click="open = !open">
                                            <div class="flex items-center">
                                                @if($row->image)
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded-full" src="{{asset('storage/img/users/'. $row->image)}}" >
                                                    </div>
                                                @else
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <img class="h-10 w-10 rounded-full" src="https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png" >
                                                    </div>
                                                @endif
                                                <div class="ml-4 main-color-blue-text dark:main-color-yellow-text transition duration-500">
                                                    <div class="flex flex-auto items-center text-xs md:text-lg font-medium font-bold">
                                                        <span>{{strlen($row->name) > 25 ? substr($row->name, 0, 25) . '...' : $row->name}}</span>
                                                        @if($row->hasRole('administrator'))
                                                            <span class="rounded-full main-color-blue-bg ml-8 h-2 h-2.5 w-2.5"></span>
                                                        @elseif($row->hasRole('employee'))
                                                            <span class="rounded-full main-color-yellow-bg ml-8 h-2.5 w-2.5"></span>
                                                        @elseif($row->hasRole('user') && $row->banned == 1)
                                                            <span class="rounded-full bg-red-700 ml-8 h-2.5 w-2.5"></span>
                                                        @else
                                                            <span class="rounded-full bg-green-500 ml-8 h-2.5 w-2.5"></span>
                                                        @endif
                                                        @if($row->isAn('user'))
                                                            <span class="ml-4">{{ $row->credit }} €</span>
                                                        @endif
                                                    </div>
                                                    <div class="grid grid-cols-2 text-2xs md:text-base w-28">
                                                        <span class="font-bold text-left">{{$row->nre->nre}}</span>
                                                        <span class="ml-4">{{strlen($row->email) > 25 ? substr($row->email, 0, 25) . '...' : $row->email}}</span>
                                                        <span class="text-left">{{$row->phone}}</span>
                                                        @if($row->isAn('administrator'))
                                                            <span class="ml-4 uppercase">Administrador</span>
                                                        @elseif($row->isAn('employee'))
                                                            <span class="ml-4 uppercase">Empleado</span>
                                                        @elseif($row->isAn('user'))
                                                            <div class="ml-4">
                                                                <span>{{ $row->class }}</span>
                                                                <span class="ml-4">Strikes: {{$row->ban_strikes}}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </button>

                                        <div class="md:hidden" x-show="open"  x-transition:enter="transition ease-out duration-300"
                                             x-transition:enter-start="opacity-100 transform -translate-x-full"
                                             x-transition:enter-end="opacity-100 transform translate-x-0"
                                             x-transition:leave="transition ease-in duration-300"
                                             x-transition:leave-start="opacity-100 transform translate-x-0"
                                             x-transition:leave-end="opacity-100 transform -translate-x-full">
                                            @include('users._actions')
                                        </div>

                                    </td>
                                    <td class="py-4 whitespace-nowrap hidden md:block">
                                        @include('users._actions')
                                    </td>
                                </tr>
                            @endforeach

                            <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="py-6 px-1 dark:main-color-yellow-text transition duration-500">
                {{$users->appends($_GET)->links()}}
            </div>
        </div>
    </div>
</x-app-layout>
