
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
      <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-8 py-3 text-left text-xs font-bold main-color-blue-text uppercase tracking-wider">
                Datos de usuario
              </th>
              <th scope="col" class="px-8 py-3 text-right text-xs font-bold main-color-blue-text uppercase tracking-wider">
                Acciones
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($users as $row)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10">
                    <img class="h-10 w-10 rounded-full" src="https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png" alt="">
                  </div>
                  <div class="ml-4 main-color-blue-text">
                      <div class="flex flex-auto items-center text-xs font-medium font-bold">
                          <span>{{strlen($row->name) > 25 ? substr($row->name, 0, 25) . '...' : $row->name}}</span>
                          @if($row->hasRole('administrator'))
                              <span class="rounded-full main-color-blue-bg ml-8 h-2 h-2.5 w-2.5"></span>
                          @elseif($row->hasRole('employee'))
                              <span class="rounded-full main-color-yellow-bg-bg ml-8 h-2.5 w-2.5"></span>
                          @elseif($row->hasRole('user') && $row->banned == 0)
                              <span class="rounded-full bg-red-700 ml-8 h-2.5 w-2.5">
                                  <a href="{{ route('users.bann', ['id' => $row->id]) }}">&nbsp;</a>
                              </span>
                          @else
                              <span class="rounded-full bg-green-500 ml-8 h-2.5 w-2.5">
                                  <a href="{{ route('users.bann', ['id' => $row->id]) }}">&nbsp;</a>
                              </span>
                          @endif
                      </div>
                      <div class="grid grid-cols-2 text-2xs w-28 ">
                          <span class="font-bold">{{$row->nre->nre}}</span>
                          <span class="ml-4">{{strlen($row->email) > 25 ? substr($row->email, 0, 25) . '...' : $row->email}}</span>
                          <span>{{$row->phone}}</span>
                          @if($row->isAn('administrator'))
                              <span class="ml-4 uppercase">Administrador</span>
                          @elseif($row->isAn('employee'))
                              <span class="ml-4 uppercase">Empleado</span>
                          @elseif($row->isAn('user'))
                              <div class="ml-4">
                                  <span>{{ $row->class }}</span>
                                  <span class="ml-4">Puntos de Fidelidad: 0</span>
                              </div>
                          @endif
                      </div>
                  </div>
                </div>
              </td>
              <td class="py-4 whitespace-nowrap">
                  <div class="flex flex-shrink-0 items-center justify-end text-sm font-medium p-1 md:px-3">
                      <a href="{{ route('users.destroy', ['id' => $row->id]) }}" class="p-1 md:p-2 mr-1 main-color-blue-bg rounded-sm">
                          <svg class="w-3 h-3 md:w-5 md:h-5" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M4.99996 1.875C2.91663 1.875 1.13746 3.17083 0.416626 5C1.13746 6.82917 2.91663 8.125 4.99996 8.125C7.08329 8.125 8.86246 6.82917 9.58329 5C8.86246 3.17083 7.08329 1.875 4.99996 1.875ZM4.99996 7.08333C3.84996 7.08333 2.91663 6.15 2.91663 5C2.91663 3.85 3.84996 2.91667 4.99996 2.91667C6.14996 2.91667 7.08329 3.85 7.08329 5C7.08329 6.15 6.14996 7.08333 4.99996 7.08333ZM4.99996 3.75C4.30829 3.75 3.74996 4.30833 3.74996 5C3.74996 5.69167 4.30829 6.25 4.99996 6.25C5.69163 6.25 6.24996 5.69167 6.24996 5C6.24996 4.30833 5.69163 3.75 4.99996 3.75Z" fill="#FFC000"/>
                          </svg>
                      </a>
                      <a href="{{ route('users.show', ['user' => $row]) }}" class="p-1 md:p-2 {{ $row->isAn('employee') | $row->isAn('user') ? 'mr-1' : ''}} main-color-blue-bg rounded-sm">
                          <svg class="w-3 h-3 md:w-5 md:h-5" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M1.25 7.1875V8.75H2.8125L7.42083 4.14167L5.85833 2.57917L1.25 7.1875ZM8.62917 2.93334C8.79167 2.77084 8.79167 2.50834 8.62917 2.34584L7.65417 1.37084C7.49167 1.20834 7.22917 1.20834 7.06667 1.37084L6.30417 2.13334L7.86667 3.69584L8.62917 2.93334Z" fill="#FFC000"/>
                          </svg>
                      </a>
                      @if($row->isAn('employee') | $row->isAn('user'))
                          <a href="{{ route('users.edit', ['user' => $row]) }}" class="p-1 md:p-2 bg-red-700 rounded-sm">
                              <svg class="w-3 h-3 md:w-5 md:h-5" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M8.49219 1.56641H6.83789L6.36523 1.09375H4.00195L3.5293 1.56641H1.875V2.51172H8.49219V1.56641ZM2.34766 2.98437V8.65625C2.34766 9.17617 2.77305 9.60156 3.29297 9.60156H7.07422C7.59414 9.60156 8.01953 9.17617 8.01953 8.65625V2.98437H2.34766ZM6.12891 6.29297V8.18359H4.23828V6.29297H3.29297L5.18359 4.40234L7.07422 6.29297H6.12891Z" fill="white"/>
                                  <defs>
                                      <clipPath id="clip0_157_209">
                                          <rect width="10" height="10" rx="3" fill="white"/>
                                      </clipPath>
                                  </defs>
                              </svg>
                          </a>
                      @endif
                  </div>
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

