@if($row->trashed())
    <div class="flex flex-shrink-0 ml-12 items-center justify-start font-medium text-sm md:px-4 md:justify-end md:ml-0">
        <form action="{{ route('users.restore', $row) }}" class="mr-2" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="extend-width flex items-center justify-center p-1 md:p-2 bg-green-500 rounded-md extend-width">
                <p class="px-2 text-sm text-white font-bold uppercase hidden">Restaurar</p>
                <svg class="w-3 h-3 md:w-5 md:h-5" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.74996 6.75001L1.99996 5.00001L1.41663 5.58334L3.74996 7.91668L8.74996 2.91668L8.16663 2.33334L3.74996 6.75001Z" fill="#FFFFFF"/>
                </svg>
            </button>
        </form>
        <form action="{{ route('users.destroy', $row) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="extend-width flex items-center justify-center p-1 md:p-2 bg-red-700 rounded-md">
                <p class="px-2 text-sm text-white font-bold uppercase hidden">Borrar</p>
                <svg class="w-3 h-3 md:w-5 md:h-5" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.91671 2.67084L7.32921 2.08334L5.00004 4.4125L2.67087 2.08334L2.08337 2.67084L4.41254 5L2.08337 7.32917L2.67087 7.91667L5.00004 5.5875L7.32921 7.91667L7.91671 7.32917L5.58754 5L7.91671 2.67084Z" fill="#FFFFFF"/>
                </svg>
            </button>
        </form>
    </div>
@else
    <form action="{{ route('users.trash', $row) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="flex flex-shrink-0 ml-12 items-center justify-start font-medium text-sm md:px-4 md:justify-end md:ml-0">
            <p class="px-2 main-color-blue-text text-2xs font-bold md:hidden dark:main-color-yellow-text transition duration-500">Acciones:</p>
            @if($row->isAn('user'))
                @if($row->banned)
                    <a href="{{ route('users.bann', ['id' => $row->id]) }}" class="extend-width flex items-center justify-center p-1 md:p-2 mx-3 bg-red-700 rounded-md">
                        <p class="px-2 text-sm text-white font-bold uppercase hidden">Deshabilitar</p>
                        <svg class="w-3 h-3 md:w-5 md:h-5" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.91671 2.67084L7.32921 2.08334L5.00004 4.4125L2.67087 2.08334L2.08337 2.67084L4.41254 5L2.08337 7.32917L2.67087 7.91667L5.00004 5.5875L7.32921 7.91667L7.91671 7.32917L5.58754 5L7.91671 2.67084Z" fill="#FFFFFF"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('users.bann', ['id' => $row->id]) }}" class="extend-width flex items-center justify-center p-1 md:p-2 mx-3 bg-green-500 rounded-md">
                        <p class="px-2 text-sm text-white font-bold uppercase hidden">Habilitar</p>
                        <svg class="w-3 h-3 md:w-5 md:h-5" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.74996 6.75001L1.99996 5.00001L1.41663 5.58334L3.74996 7.91668L8.74996 2.91668L8.16663 2.33334L3.74996 6.75001Z" fill="#FFFFFF"/>
                        </svg>
                    </a>
                @endif
            @endif

            <a href= "{{ route('users.show', ['user' => $row]) }}"class="extend-width flex items-center justify-center p-1 md:p-2 mr-1 main-color-blue-bg rounded-md">
                <p class="px-2 text-sm main-color-yellow-text font-bold uppercase hidden">Visualizar</p>
                <svg class="w-3 h-3 md:w-5 md:h-5" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.99996 1.875C2.91663 1.875 1.13746 3.17083 0.416626 5C1.13746 6.82917 2.91663 8.125 4.99996 8.125C7.08329 8.125 8.86246 6.82917 9.58329 5C8.86246 3.17083 7.08329 1.875 4.99996 1.875ZM4.99996 7.08333C3.84996 7.08333 2.91663 6.15 2.91663 5C2.91663 3.85 3.84996 2.91667 4.99996 2.91667C6.14996 2.91667 7.08329 3.85 7.08329 5C7.08329 6.15 6.14996 7.08333 4.99996 7.08333ZM4.99996 3.75C4.30829 3.75 3.74996 4.30833 3.74996 5C3.74996 5.69167 4.30829 6.25 4.99996 6.25C5.69163 6.25 6.24996 5.69167 6.24996 5C6.24996 4.30833 5.69163 3.75 4.99996 3.75Z" fill="#FFC000"/>
                </svg>
            </a>
            <a href="{{ route('users.edit', ['user' => $row]) }}" class="extend-width flex items-center justify-center p-1 md:p-2 {{ $row->isAn('employee') | $row->isAn('user') ? 'mr-1' : ''}} main-color-blue-bg rounded-md">
                <p class="px-2 text-sm main-color-yellow-text font-bold uppercase hidden">Editar</p>
                <svg class="w-3 h-3 md:w-5 md:h-5" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.25 7.1875V8.75H2.8125L7.42083 4.14167L5.85833 2.57917L1.25 7.1875ZM8.62917 2.93334C8.79167 2.77084 8.79167 2.50834 8.62917 2.34584L7.65417 1.37084C7.49167 1.20834 7.22917 1.20834 7.06667 1.37084L6.30417 2.13334L7.86667 3.69584L8.62917 2.93334Z" fill="#FFC000"/>
                </svg>
            </a>
            @if($row->isAn('employee') | $row->isAn('user'))
                <button type="submit" class="extend-width flex items-center justify-center p-1 md:p-2 bg-red-700 rounded-md">
                    <p class="px-2 text-sm text-white font-bold uppercase hidden">A la papelera</p>
                    <svg class="w-3 h-3 md:w-5 md:h-5" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.49219 1.56641H6.83789L6.36523 1.09375H4.00195L3.5293 1.56641H1.875V2.51172H8.49219V1.56641ZM2.34766 2.98437V8.65625C2.34766 9.17617 2.77305 9.60156 3.29297 9.60156H7.07422C7.59414 9.60156 8.01953 9.17617 8.01953 8.65625V2.98437H2.34766ZM6.12891 6.29297V8.18359H4.23828V6.29297H3.29297L5.18359 4.40234L7.07422 6.29297H6.12891Z" fill="white"/>
                        <defs>
                            <clipPath id="clip0_157_209">
                                <rect width="10" height="10" rx="3" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>
                </button>
            @endif
        </div>
    </form>
@endif

