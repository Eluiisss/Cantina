<div class="overflow-x-hidden bg-gray-100 dark:bg-gray-800 border-r-4 border-gray-300 dark:main-color-yellow-border transition duration-500 z-50">
    <div class="flex flex-col w-screen h-screen md:w-96" x-cloak x-show="open"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-100 transform -translate-x-full"
         x-transition:enter-end="opacity-100 transform translate-x-0"
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-100 transform translate-x-0"
         x-transition:leave-end="opacity-100 transform -translate-x-full">
        <div class="flex flex-col flex-grow pt-4">
            <div class="flex justify-between px-6">
                <button x-data onclick="toggleDarkMode()" class="focus:outline-none focus:shadow-outline dark:main-color-yellow-text transition duration-500">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 15.31L23.31 12L20 8.69V4H15.31L12 0.690002L8.69 4H4V8.69L0.690002 12L4 15.31V20H8.69L12 23.31L15.31 20H20V15.31ZM12 18V6C15.31 6 18 8.69 18 12C18 15.31 15.31 18 12 18Z" fill="#004467"/>
                    </svg>
                </button>
                <button class="md:hidden focus:outline-none focus:shadow-outline text-right font-light text-xs main-color-blue-text uppercase dark:main-color-yellow-text transition duration-500" x-on:click="open = ! open">
                    Volver
                    <svg width="57" height="8" viewBox="0 0 57 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.646492 3.83288C0.451229 4.02814 0.451229 4.34472 0.646492 4.53999L3.82847 7.72197C4.02374 7.91723 4.34032 7.91723 4.53558 7.72197C4.73084 7.5267 4.73084 7.21012 4.53558 7.01486L1.70715 4.18643L4.53558 1.358C4.73084 1.16274 4.73084 0.84616 4.53558 0.650898C4.34032 0.455636 4.02374 0.455636 3.82847 0.650898L0.646492 3.83288ZM56.9323 3.68643L1.00005 3.68643V4.68643L56.9323 4.68643V3.68643Z" fill="#004467"/>
                    </svg>
                </button>
            </div>
            <div class="py-8 flex flex-col items-center flex-shrink-0 px-4">
                <a href="/" class="px-8 focus:outline-none text-center ">
                    <img class="shadow-lg" src="{{ URL::asset('img/IdlC.png') }}" alt="Logo Ingeniero de la Cierva" width="200" height="56">
                </a>
                <span class="mt-3 font-light text-sm text-center main-color-blue-text dark:main-color-yellow-text transition duration-500">
                    @if(Auth::user() && (Auth::user())->isAn('administrator|employee'))
                        Panel de administración
                    @else
                        {{ trans('users.greetings')[array_rand(trans('users.greetings'))] }}
                    @endif
                </span>
            </div>
            <div class="flex flex-col items-center flex-grow px-4 mt-5">
                <nav class="flex-1 space-y-1 bg-neutral-800">
                    @if(Auth::user() && (Auth::user())->isAn('administrator|employee'))
                        <ul>
                            <li>
                                <a class="{{ (request()->routeIs('orders.manage')) | (request()->is('manageOrders/*')) ? 'currentActive transform translate-x-3 transition duration-500' : 'transform hover:translate-x-3 transition-transform ease-in duration-200 bg-white dark:main-color-yellow-text dark:main-color-blue-bg' }} inline-flex items-center w-full px-4 py-2 mt-1 text-base rounded-lg focus:shadow-outline" white="" 70="" href="{{ route('orders.manage') }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20 6H17V4C17 2.89 16.11 2 15 2H9C7.89 2 7 2.89 7 4V6H4C2.89 6 2 6.89 2 8V19C2 20.11 2.89 21 4 21H20C21.11 21 22 20.11 22 19V8C22 6.89 21.11 6 20 6ZM9 4H15V6H9V4ZM20 19H4V17H20V19ZM20 14H4V8H7V10H9V8H15V10H17V8H20V14Z" fill="#004467"/>
                                    </svg>
                                    <span class="ml-4 font-light text-xs main-color-blue-text uppercase dark:main-color-yellow-text transition duration-500"> Administrar Pedidos</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ (request()->routeIs('users.index')) | (request()->is('users/*')) ? 'currentActive transform translate-x-3 transition duration-500' : 'transform hover:translate-x-3 transition-transform ease-in duration-200 bg-white dark:main-color-yellow-text dark:main-color-blue-bg' }} inline-flex items-center w-full px-4 py-2 mt-1 text-base rounded-lg focus:shadow-outline" white="" 70="" href="{{ route('users.index') }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19 3H14.82C14.4 1.84 13.3 1 12 1C10.7 1 9.6 1.84 9.18 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3ZM12 3C12.55 3 13 3.45 13 4C13 4.55 12.55 5 12 5C11.45 5 11 4.55 11 4C11 3.45 11.45 3 12 3ZM12 7C13.66 7 15 8.34 15 10C15 11.66 13.66 13 12 13C10.34 13 9 11.66 9 10C9 8.34 10.34 7 12 7ZM18 19H6V17.6C6 15.6 10 14.5 12 14.5C14 14.5 18 15.6 18 17.6V19Z" fill="#004467"/>
                                    </svg>
                                    <span class="ml-4 font-light text-xs main-color-blue-text uppercase dark:main-color-yellow-text transition duration-500"> Usuarios</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ (request()->routeIs('articles.index')) | (request()->is('food/*')) ? 'currentActive transform translate-x-3 transition duration-500' : 'transform hover:translate-x-3 transition-transform ease-in duration-200 bg-white dark:main-color-yellow-text dark:main-color-blue-bg' }} inline-flex items-center w-full px-4 py-2 mt-1 text-base rounded-lg focus:shadow-outline" white="" 70="" href="{{ route('articles.index') }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18.06 22.99H19.72C20.56 22.99 21.25 22.35 21.35 21.53L23 5.05H18V1H16.03V5.05H11.06L11.36 7.39C13.07 7.86 14.67 8.71 15.63 9.65C17.07 11.07 18.06 12.54 18.06 14.94V22.99ZM1 21.99V21H16.03V21.99C16.03 22.54 15.58 22.99 15.02 22.99H2.01C1.45 22.99 1 22.54 1 21.99ZM16.03 14.99C16.03 6.99 1 6.99 1 14.99H16.03ZM1.02 17H16.02V19H1.02V17Z" fill="#004467"/>
                                    </svg>
                                    <span class="ml-4 font-light text-xs main-color-blue-text uppercase dark:main-color-yellow-text transition duration-500"> Artículos</span>
                                </a>
                            </li>
                        </ul>
                    @else
                        <ul>
                            <li>
                                <a class="{{ (request()->routeIs('shop.index')) | (request()->is('shop/*')) | (request()->is('/')) ? 'currentActive transform translate-x-3 transition duration-500' : 'transform hover:translate-x-3 transition-transform ease-in duration-200 bg-white dark:main-color-yellow-text dark:main-color-blue-bg' }} inline-flex items-center w-full px-4 py-2 mt-1 text-base rounded-lg focus:shadow-outline" white="" 70="" href="{{ route('shop.index') }}">
                                    <svg class="dark:main-color-yellow-text transition-all duration-500" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 20V14H14V20H19V12H22L12 3L2 12H5V20H10Z" fill="#004467" />
                                    </svg>
                                    <span class="ml-4 font-light text-xs main-color-blue-text uppercase dark:main-color-yellow-text transition duration-500">
                                        {{ (request()->routeIs('shop.index')) ? 'Vamos... ¡pide algo!' : '¡A la cantina!' }}
                                    </span>
                                </a>
                            </li>
                            @role('user')
                            <li>
                                <a class="{{ (request()->routeIs('shop.cart')) | (request()->is('cart/*')) ? 'currentActive transform translate-x-3 transition duration-500' : 'transform hover:translate-x-3 transition-transform ease-in duration-200 bg-white dark:main-color-yellow-text dark:main-color-blue-bg' }} inline-flex items-center w-full px-4 py-2 mt-1 text-base rounded-lg focus:shadow-outline" white="" 70="" href="{{route('shop.cart')}}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7 18C5.9 18 5.01 18.9 5.01 20C5.01 21.1 5.9 22 7 22C8.1 22 9 21.1 9 20C9 18.9 8.1 18 7 18ZM1 2V4H3L6.6 11.59L5.25 14.04C5.09 14.32 5 14.65 5 15C5 16.1 5.9 17 7 17H19V15H7.42C7.28 15 7.17 14.89 7.17 14.75L7.2 14.63L8.1 13H15.55C16.3 13 16.96 12.59 17.3 11.97L20.88 5.48C20.96 5.34 21 5.17 21 5C21 4.45 20.55 4 20 4H5.21L4.27 2H1ZM17 18C15.9 18 15.01 18.9 15.01 20C15.01 21.1 15.9 22 17 22C18.1 22 19 21.1 19 20C19 18.9 18.1 18 17 18Z" fill="#004467"/>
                                    </svg>
                                    <div class="flex w-full justify-between">
                                        <span class="ml-4 font-light text-xs main-color-blue-text uppercase dark:main-color-yellow-text transition duration-500"> Tu carrito</span>
                                        <span class="font-light text-xs main-color-blue-text dark:main-color-yellow-text transition duration-500">{{ Cart::count() }}</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="{{ (request()->routeIs('orders.history')) | (request()->is('pedidos/*')) ? 'currentActive transform translate-x-3 transition duration-500' : 'transform hover:translate-x-3 transition-transform ease-in duration-200 bg-white dark:main-color-yellow-text dark:main-color-blue-bg' }} inline-flex items-center w-full px-4 py-2 mt-1 text-base rounded-lg focus:shadow-outline" white="" 70="" href="{{route('orders.history')}}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20 6H17V4C17 2.89 16.11 2 15 2H9C7.89 2 7 2.89 7 4V6H4C2.89 6 2 6.89 2 8V19C2 20.11 2.89 21 4 21H20C21.11 21 22 20.11 22 19V8C22 6.89 21.11 6 20 6ZM9 4H15V6H9V4ZM20 19H4V17H20V19ZM20 14H4V8H7V10H9V8H15V10H17V8H20V14Z" fill="#004467"/>
                                    </svg>
                                    <div class="flex w-full justify-between">
                                        <span class="ml-4 font-light text-xs main-color-blue-text uppercase dark:main-color-yellow-text transition duration-500"> Tus pedidos</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="inline-flex items-center w-full px-4 py-2 mt-1 text-base transform hover:translate-x-2 transition-transform ease-in duration-200 rounded-lg bg-white focus:shadow-outline dark:main-color-blue-bg" white="" 70="" href="{{ route('users.edit', ['user' => Auth::user()]) }}">
                                    <svg class="dark:main-color-yellow-text transition duration-500" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19 3H14.82C14.4 1.84 13.3 1 12 1C10.7 1 9.6 1.84 9.18 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3ZM12 3C12.55 3 13 3.45 13 4C13 4.55 12.55 5 12 5C11.45 5 11 4.55 11 4C11 3.45 11.45 3 12 3ZM12 7C13.66 7 15 8.34 15 10C15 11.66 13.66 13 12 13C10.34 13 9 11.66 9 10C9 8.34 10.34 7 12 7ZM18 19H6V17.6C6 15.6 10 14.5 12 14.5C14 14.5 18 15.6 18 17.6V19Z" fill="#004467"/>
                                    </svg>
                                    <div class="flex w-full justify-between">
                                        <span class="ml-4 font-light text-xs main-color-blue-text uppercase dark:main-color-yellow-text transition duration-500"> Tu perfil</span>
                                        @if((Auth::user())->banned == 1)
                                            <svg class="justify-end" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.00004 1.33331C4.31337 1.33331 1.33337 4.31331 1.33337 7.99998C1.33337 11.6866 4.31337 14.6666 8.00004 14.6666C11.6867 14.6666 14.6667 11.6866 14.6667 7.99998C14.6667 4.31331 11.6867 1.33331 8.00004 1.33331ZM11.3334 10.3933L10.3934 11.3333L8.00004 8.93998L5.60671 11.3333L4.66671 10.3933L7.06004 7.99998L4.66671 5.60665L5.60671 4.66665L8.00004 7.05998L10.3934 4.66665L11.3334 5.60665L8.94004 7.99998L11.3334 10.3933Z" fill="#E20000"/>
                                            </svg>
                                        @else
                                            <svg class="justify-end" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M8.00004 1.33331C4.32004 1.33331 1.33337 4.31998 1.33337 7.99998C1.33337 11.68 4.32004 14.6666 8.00004 14.6666C11.68 14.6666 14.6667 11.68 14.6667 7.99998C14.6667 4.31998 11.68 1.33331 8.00004 1.33331ZM6.66671 11.3333L3.33337 7.99998L4.27337 7.05998L6.66671 9.44665L11.7267 4.38665L12.6667 5.33331L6.66671 11.3333Z" fill="#60A06C"/>
                                            </svg>
                                        @endif
                                    </div>
                                </a>
                            </li>
                            @endrole
                        </ul>
                    @endif

                    @role('administrator|employee')
                    <div class="pt-16 pb-1 flex flex-col items-center">
                        <span class="font-light text-sm main-color-blue-text dark:main-color-yellow-text transition duration-500">Enlaces directos</span>
                    </div>
                    <ul class="flex space-x-3">
                        <li>
                            <a class="{{ (request()->routeIs('shop.index')) | (request()->is('shop/*')) | (request()->is('/')) ? 'currentActive transform translate-y-2 transition duration-500' : 'transform hover:translate-y-2 transition-transform ease-in duration-200 bg-white dark:main-color-yellow-text dark:main-color-blue-bg' }} inline-flex items-center w-full p-2 mt-1 text-base rounded-lg focus:shadow-outline" white="" 70="" href="/">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 20V14H14V20H19V12H22L12 3L2 12H5V20H10Z" fill="#004467"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a class="{{ (request()->routeIs('orders.index')) | (request()->is('orders/*')) ? 'currentActive transform translate-y-2 transition duration-500' : 'transform hover:translate-y-2 transition-transform ease-in duration-200 bg-white dark:main-color-yellow-text dark:main-color-blue-bg' }} inline-flex items-center w-full p-2 mt-1 text-base rounded-lg focus:shadow-outline" white="" 70="" href="{{route('orders.index')}}">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 18.5C12.49 18.5 10.32 17.08 9.24 15H15V13H8.58C8.53 12.67 8.5 12.34 8.5 12C8.5 11.66 8.53 11.33 8.58 11H15V9H9.24C10.32 6.92 12.5 5.5 15 5.5C16.61 5.5 18.09 6.09 19.23 7.07L21 5.3C19.41 3.87 17.3 3 15 3C11.08 3 7.76 5.51 6.52 9H3V11H6.06C6.02 11.33 6 11.66 6 12C6 12.34 6.02 12.67 6.06 13H3V15H6.52C7.76 18.49 11.08 21 15 21C17.31 21 19.41 20.13 21 18.7L19.22 16.93C18.09 17.91 16.62 18.5 15 18.5Z" fill="#004467"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a class="{{ (request()->routeIs('categories.index')) | (request()->is('categories/*')) ? 'currentActive transform translate-y-2 transition duration-500' : 'transform hover:translate-y-2 transition-transform ease-in duration-200 bg-white dark:main-color-yellow-text dark:main-color-blue-bg' }} inline-flex items-center w-full p-2 mt-1 text-base rounded-lg focus:shadow-outline" white="" 70="" href="{{route('categories.index')}}">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 13H4C3.45 13 3 13.45 3 14V20C3 20.55 3.45 21 4 21H20C20.55 21 21 20.55 21 20V14C21 13.45 20.55 13 20 13ZM7 19C5.9 19 5 18.1 5 17C5 15.9 5.9 15 7 15C8.1 15 9 15.9 9 17C9 18.1 8.1 19 7 19ZM20 3H4C3.45 3 3 3.45 3 4V10C3 10.55 3.45 11 4 11H20C20.55 11 21 10.55 21 10V4C21 3.45 20.55 3 20 3ZM7 9C5.9 9 5 8.1 5 7C5 5.9 5.9 5 7 5C8.1 5 9 5.9 9 7C9 8.1 8.1 9 7 9Z" fill="#004467"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a class="transform hover:translate-y-2 transition-transform ease-in duration-200 bg-white dark:main-color-yellow-text dark:main-color-blue-bg inline-flex items-center w-full p-2 mt-1 text-base rounded-lg focus:shadow-outline" white="" 70="" href="#">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.6999 19L13.5999 9.9C14.4999 7.6 13.9999 4.9 12.0999 3C10.0999 0.999997 7.09994 0.599997 4.69994 1.7L8.99994 6L5.99994 9L1.59994 4.7C0.399939 7.1 0.899939 10.1 2.89994 12.1C4.79994 14 7.49994 14.5 9.79994 13.6L18.8999 22.7C19.2999 23.1 19.8999 23.1 20.2999 22.7L22.5999 20.4C23.0999 20 23.0999 19.3 22.6999 19Z" fill="#004467"/>
                                </svg>
                            </a>
                        </li>
                    </ul>
                    @endrole

                    @role('user')
                    <div class="{{ (Auth::user())->banned ? 'user-banned' : '' }} pt-16 pb-1 flex flex-col items-center transition-all duration-500">
                        <img class="h-12 w-12 rounded-full" src="{{ (Auth::user())->image ? asset('storage/img/users/'. (Auth::user())->image): URL::asset('img/no_picture.jpg') }}" alt="User image">
                        <span class="font-light py-1 text-sm main-color-blue-text font-bold dark:main-color-yellow-text transition duration-500">{{ (Auth::user())->name }}</span>
                        <span class="font-light py-1 text-2xs main-color-blue-text dark:main-color-yellow-text transition duration-500">Strikes: {{ (Auth::user())->ban_strikes }}</span>
                        <span class="font-light py-1 text-2xs main-color-blue-text dark:main-color-yellow-text transition duration-500">
                            @switch((Auth::user())->ban_strikes)
                                @case(0)
                                    ¡Sigue portándote así de bien!
                                    @break
                                @case(1)
                                    ¡Sigue portándote así de bien!
                                    @break
                                @case(2)
                                    ¡Cuidado! No queremos que te vayas...
                                    @break
                                @case(3)
                                    No has dado la taya...
                                    @break
                            @endswitch
                        </span>
                        <div class="pt-1 w-full">
                            <meter class="rounded-lg w-full main-color-yellow-text" min="0" max="3" value="{{ (Auth::user())->ban_strikes }}" low="1" high="2" optimum="0"></meter>
                        </div>
                    </div>
                    @endrole

                </nav>
            </div>
        </div>

        @if(Auth::user())
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <div class="pt-10 pb-10 flex flex-col items-center" x-data="{ show: false }">
                    <div class="flex flex-col px-2 py-2 mb-4 items-center rounded-lg bg-white dark:main-color-blue-bg transition duration-500 shadow-lg" x-cloak x-show="show">
                        <span class="font-light text-sm main-color-blue-text dark:main-color-yellow-text transition duration-500">¿Deseas cerrar sesión?</span>
                        <div class="flex flex-auto py-2 justify-between">
                            <button type="button" class="main-color-blue-bg main-color-yellow-text dark:main-color-yellow-bg dark:main-color-blue-text transition duration-500 text-xs uppercase w-1/2 mx-2 p-2 rounded-lg" x-on:click="show = ! show">Cancelar</button>
                            <button type="submit" class="bg-red-700 text-white text-xs uppercase w-1/2 p-2 mx-2 rounded-lg">Aceptar</button>
                        </div>
                    </div>
                    <button type="button" class="block inline-flex items-center p-2 mt-1 text-base transition duration-500 ease-in-out transform rounded-lg bg-red-700 focus:shadow-outline" white="" 70="" x-on:click="show = ! show">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13 3H11V13H13V3ZM17.83 5.17L16.41 6.59C17.99 7.86 19 9.81 19 12C19 15.87 15.87 19 12 19C8.13 19 5 15.87 5 12C5 9.81 6.01 7.86 7.58 6.58L6.17 5.17C4.23 6.82 3 9.26 3 12C3 16.97 7.03 21 12 21C16.97 21 21 16.97 21 12C21 9.26 19.77 6.82 17.83 5.17Z" fill="white"/>
                        </svg>
                    </button>
                    <span class="pt-2 font-light text-sm text-red-700">Cerrar sesión</span>
                </div>
            </form>
        @else
            <div class="flex flex-col py-5 items-center">
                <a href="{{ route('login') }}" class="main-color-blue-bg main-color-yellow-text text-xs text-center uppercase w-1/2 my-2 p-2 rounded-lg">Iniciar Sesión</a>
                <a href="{{ route('register') }}" class="main-color-yellow-bg main-color-blue-text text-xs text-center uppercase w-1/2 mb-3 p-2 rounded-lg">Registrarse</a>
            </div>
        @endif

    </div>
</div>
