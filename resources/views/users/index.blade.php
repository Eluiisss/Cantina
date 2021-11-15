
@extends('layout')


@section('title','Users')


@section('content')
<!-- This example requires Tailwind CSS v2.0+ -->
<div class="filters w-full inline-block">
    @include('users._filters')
</div>
<div class="flex flex-col">
  <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
      <div class="shadow overflow-hidden border-b border-gray-200 rounded-md">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-4 py-3 text-left text-xs font-bold main-color-blue-text uppercase tracking-wider">
                Datos de usuario
              </th>
              <th scope="col" class="px-4 py-3 text-right text-xs font-bold main-color-blue-text uppercase tracking-wider hidden md:block">
                Acciones
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($users as $row)
            <tr>
                <td class="px-4 py-4 whitespace-nowrap" x-data="{ open: false }">
                    <button class="cursor-pointer md:cursor-default" x-on:click="open = !open">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" src="https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png" alt="">
                            </div>
                            <div class="ml-4 main-color-blue-text">
                                <div class="flex flex-auto items-center text-xs md:text-lg font-medium font-bold">
                                    <span>{{strlen($row->name) > 25 ? substr($row->name, 0, 25) . '...' : $row->name}}</span>
                                    @if($row->hasRole('administrator'))
                                        <span class="rounded-full main-color-blue-bg ml-8 h-2 h-2.5 w-2.5"></span>
                                    @elseif($row->hasRole('employee'))
                                        <span class="rounded-full main-color-yellow-bg ml-8 h-2.5 w-2.5"></span>
                                    @elseif($row->hasRole('user') && $row->banned == 0)
                                        <span class="rounded-full bg-red-700 ml-8 h-2.5 w-2.5"></span>
                                    @else
                                        <span class="rounded-full bg-green-500 ml-8 h-2.5 w-2.5"></span>
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
                                            <span class="ml-4">Fidelidad: 0</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </button>

                    <div class="md:hidden" x-show="open" x-transition>
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
    <div class="py-3 px-1">
        {{$users->links()}}
    </div>
</div>

@endsection

