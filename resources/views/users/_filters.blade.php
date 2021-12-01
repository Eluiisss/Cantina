<div class="grid justify-items-end inline-block">
    <div class="flex flex-auto items-center md:text-3xl">
        <svg class="md:w-10 md:h-10" width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M23.75 3.75H18.525C18 2.3 16.625 1.25 15 1.25C13.375 1.25 12 2.3 11.475 3.75H6.25C4.875 3.75 3.75 4.875 3.75 6.25V23.75C3.75 25.125 4.875 26.25 6.25 26.25H23.75C25.125 26.25 26.25 25.125 26.25 23.75V6.25C26.25 4.875 25.125 3.75 23.75 3.75ZM15 3.75C15.6875 3.75 16.25 4.3125 16.25 5C16.25 5.6875 15.6875 6.25 15 6.25C14.3125 6.25 13.75 5.6875 13.75 5C13.75 4.3125 14.3125 3.75 15 3.75ZM15 8.75C17.075 8.75 18.75 10.425 18.75 12.5C18.75 14.575 17.075 16.25 15 16.25C12.925 16.25 11.25 14.575 11.25 12.5C11.25 10.425 12.925 8.75 15 8.75ZM22.5 23.75H7.5V22C7.5 19.5 12.5 18.125 15 18.125C17.5 18.125 22.5 19.5 22.5 22V23.75Z" fill="#004467"/>
        </svg>
        <h1 class="px-1 main-color-blue-text">LISTADO DE USUARIOS</h1>
    </div>
</div>
<form method="get" action="{{ route('users.index') }}">
    <div class="grid justify-items-end inline-block py-2 px-1 mt-1 w-full">
        <div class="flex flex-auto justify-end w-5/6 md:w-96">
            <input type="search" name="search" value="{{ request('search') }}"
                   class="w-64 px-3 h-7 md:w-full md:px-5 md:h-10 text-right text-xs border-transparent rounded-l-md" placeholder="Buscar usuarios...">
            <button type="submit" class="px-1 md:px-3 main-color-blue-bg main-color-yellow-text rounded-r-md">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.6837 11.6116H12.1191L11.919 11.4187C12.6194 10.6039 13.041 9.54617 13.041 8.39551C13.041 5.82976 10.9613 3.75 8.39551 3.75C5.82976 3.75 3.75 5.82976 3.75 8.39551C3.75 10.9613 5.82976 13.041 8.39551 13.041C9.54617 13.041 10.6039 12.6194 11.4187 11.919L11.6116 12.1191V12.6837L15.1851 16.25L16.25 15.1851L12.6837 11.6116ZM8.39551 11.6116C6.61592 11.6116 5.17939 10.1751 5.17939 8.39551C5.17939 6.61592 6.61592 5.17939 8.39551 5.17939C10.1751 5.17939 11.6116 6.61592 11.6116 8.39551C11.6116 10.1751 10.1751 11.6116 8.39551 11.6116Z" fill="#FFC000"/>
                </svg>
            </button>
        </div>
        <div class="flex justify-between py-2 w-5/6 md:w-96">
            <select name="role" id="role" class="w-20 h-7 p-0 md:w-28 md:h-9 text-3xs text-center main-color-blue-bg main-color-yellow-text border-transparent rounded-md">
                @foreach(trans('users.roles') as $value => $text)
                    <option value="{{ $value }}" {{ request('role') === $value ? 'selected' : '' }}>{{ $text }}</option>
                @endforeach
            </select>
            <select name="order" id="order" class="w-28 h-7 p-0 md:w-36 md:h-9 text-3xs text-center main-color-blue-bg main-color-yellow-text border-transparent rounded-md">
                @foreach(trans('users.orderBy') as $value => $text)
                    <option value="{{ $value }}" {{ request('order') === $value ? 'selected' : '' }}>{{ $text }}</option>
                @endforeach
            </select>
            <div class="grid justify-items-end inline-block">
                <div class="flex items-center">
                    <a href="{{ route('users.trashed') }}" class="px-1 py-1 md:px-2 md:py-2 bg-red-700 main-color-yellow-text rounded-l-md">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.9844 3.1328H13.6758L12.7305 2.18749H8.00391L7.05859 3.1328H3.75V5.02343H16.9844V3.1328ZM4.69531 5.96874V17.3125C4.69531 18.3523 5.54609 19.2031 6.58594 19.2031H14.1484C15.1883 19.2031 16.0391 18.3523 16.0391 17.3125V5.96874H4.69531ZM12.2578 12.5859V16.3672H8.47656V12.5859H6.58594L10.3672 8.80468L14.1484 12.5859H12.2578Z" fill="white"/>
                            <defs>
                                <clipPath id="clip0_229_5">
                                    <rect width="20" height="20" rx="3" fill="white"/>
                                </clipPath>
                            </defs>
                        </svg>
                    </a>
                    <a href="{{route('users.createEmployee')}}" class="px-1 py-1 md:px-2 md:py-2 main-color-blue-bg main-color-yellow-text rounded-r-md">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.8333 10.8333H10.8333V15.8333H9.16663V10.8333H4.16663V9.16666H9.16663V4.16666H10.8333V9.16666H15.8333V10.8333Z" fill="#FFC000"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
