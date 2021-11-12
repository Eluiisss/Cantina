<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap');
    </style>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/extra-styles.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <div class="flex h-screen bg-white" x-data="{ open: false }">
        <div class="overflow-hidden bg-gray-100" :class="open ? '' : 'hidden'">
            <div class="flex flex-col w-screen md:w-96">
                <div class="flex flex-col flex-grow pt-4 overflow-hidden border-r">
                    <div class="px-6 text-right">
                        <button class="md:hidden focus:outline-none focus:shadow-outline text-right font-light text-xs main-color-blue-text" x-on:click="open = ! open">
                            VOLVER
                            <svg width="57" height="8" viewBox="0 0 57 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.646492 3.83288C0.451229 4.02814 0.451229 4.34472 0.646492 4.53999L3.82847 7.72197C4.02374 7.91723 4.34032 7.91723 4.53558 7.72197C4.73084 7.5267 4.73084 7.21012 4.53558 7.01486L1.70715 4.18643L4.53558 1.358C4.73084 1.16274 4.73084 0.84616 4.53558 0.650898C4.34032 0.455636 4.02374 0.455636 3.82847 0.650898L0.646492 3.83288ZM56.9323 3.68643L1.00005 3.68643V4.68643L56.9323 4.68643V3.68643Z" fill="#004467"/>
                            </svg>
                        </button>
                    </div>
                    <div class="py-8 flex flex-col items-center flex-shrink-0 px-4">
                        <a href="/" class="px-8 focus:outline-none text-center ">
                            <img class="shadow-lg" src="{{ URL::asset('img/IdlC.png') }}" alt="Logo Ingeniero de la Cierva - Administración" width="200" height="56">
                        </a>
                        <span class="mt-3 font-light text-sm main-color-blue-text">Panel de administración</span>
                    </div>
                    <div class="flex flex-col items-center flex-grow px-4 mt-5">
                        <nav class="flex-1 space-y-1 bg-neutral-800">
                            <ul>
                                <li>
                                    <a class="{{ request()->routeIs('dashboard') ? 'currentActive transform translate-x-3' : 'transform hover:translate-x-3 transition-transform ease-in duration-200 bg-white' }} inline-flex items-center w-full px-4 py-2 mt-1 text-base rounded-lg focus:shadow-outline" white="" 70="" href="{{ route('dashboard') }}" style="width: 200px">
                                        <svg class="group-hover:" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path class="group-hover:" d="M3 13H11V3H3V13ZM3 21H11V15H3V21ZM13 21H21V11H13V21ZM13 3V9H21V3H13Z" fill="#004467"/>
                                        </svg>
                                        <span class="ml-4 font-light text-xs main-color-blue-text"> DASHBOARD</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ request()->routeIs('users.index') ? 'currentActive transform translate-x-3' : 'transform hover:translate-x-3 transition-transform ease-in duration-200 bg-white' }} inline-flex items-center w-full px-4 py-2 mt-1 text-base rounded-lg focus:shadow-outline" white="" 70="" href="{{ route('users.index') }}">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19 3H14.82C14.4 1.84 13.3 1 12 1C10.7 1 9.6 1.84 9.18 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3ZM12 3C12.55 3 13 3.45 13 4C13 4.55 12.55 5 12 5C11.45 5 11 4.55 11 4C11 3.45 11.45 3 12 3ZM12 7C13.66 7 15 8.34 15 10C15 11.66 13.66 13 12 13C10.34 13 9 11.66 9 10C9 8.34 10.34 7 12 7ZM18 19H6V17.6C6 15.6 10 14.5 12 14.5C14 14.5 18 15.6 18 17.6V19Z" fill="#004467"/>
                                        </svg>
                                        <span class="ml-4 font-light text-xs main-color-blue-text"> USUARIOS</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ request()->routeIs('articles.index') ? 'currentActive transform translate-x-3' : 'transform hover:translate-x-3 transition-transform ease-in duration-200 bg-white' }} inline-flex items-center w-full px-4 py-2 mt-1 text-base rounded-lg focus:shadow-outline" white="" 70="" href="{{ route('articles.index') }}">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18.06 22.99H19.72C20.56 22.99 21.25 22.35 21.35 21.53L23 5.05H18V1H16.03V5.05H11.06L11.36 7.39C13.07 7.86 14.67 8.71 15.63 9.65C17.07 11.07 18.06 12.54 18.06 14.94V22.99ZM1 21.99V21H16.03V21.99C16.03 22.54 15.58 22.99 15.02 22.99H2.01C1.45 22.99 1 22.54 1 21.99ZM16.03 14.99C16.03 6.99 1 6.99 1 14.99H16.03ZM1.02 17H16.02V19H1.02V17Z" fill="#004467"/>
                                        </svg>
                                        <span class="ml-4 font-light text-xs main-color-blue-text"> ARTICULOS</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="{{ request()->routeIs('categories.index') ? 'currentActive transform translate-x-3' : 'transform hover:translate-x-3 transition-transform ease-in duration-200 bg-white' }} inline-flex items-center w-full px-4 py-2 mt-1 text-base rounded-lg focus:shadow-outline" white="" 70="" href="{{ route('categories.index') }}">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M20 13H4C3.45 13 3 13.45 3 14V20C3 20.55 3.45 21 4 21H20C20.55 21 21 20.55 21 20V14C21 13.45 20.55 13 20 13ZM7 19C5.9 19 5 18.1 5 17C5 15.9 5.9 15 7 15C8.1 15 9 15.9 9 17C9 18.1 8.1 19 7 19ZM20 3H4C3.45 3 3 3.45 3 4V10C3 10.55 3.45 11 4 11H20C20.55 11 21 10.55 21 10V4C21 3.45 20.55 3 20 3ZM7 9C5.9 9 5 8.1 5 7C5 5.9 5.9 5 7 5C8.1 5 9 5.9 9 7C9 8.1 8.1 9 7 9Z" fill="#004467"/>
                                        </svg>
                                        <span class="ml-4 font-light text-xs main-color-blue-text"> CATEGORÍAS</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="inline-flex items-center w-full px-4 py-2 mt-1 text-base transform hover:translate-x-2 transition-transform ease-in duration-200 rounded-lg bg-white focus:shadow-outline" white="" 70="" href="#">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M22.6999 19L13.5999 9.9C14.4999 7.6 13.9999 4.9 12.0999 3C10.0999 0.999997 7.09994 0.599997 4.69994 1.7L8.99994 6L5.99994 9L1.59994 4.7C0.399939 7.1 0.899939 10.1 2.89994 12.1C4.79994 14 7.49994 14.5 9.79994 13.6L18.8999 22.7C19.2999 23.1 19.8999 23.1 20.2999 22.7L22.5999 20.4C23.0999 20 23.0999 19.3 22.6999 19Z" fill="#004467"/>
                                        </svg>
                                        <span class="ml-4 font-light text-xs main-color-blue-text"> AJUSTES</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="pt-16 pb-1 flex flex-col items-center">
                                <span class="font-light text-sm main-color-blue-text">Enlaces directos</span>
                            </div>
                            <ul class="flex space-x-3">
                                <li>
                                    <a class="inline-flex items-center w-full p-2 mt-1 text-base transition duration-500 ease-in-out transform rounded-lg bg-white focus:shadow-outline" white="" 70="" href="/">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 20V14H14V20H19V12H22L12 3L2 12H5V20H10Z" fill="#004467"/>
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a class="inline-flex items-center w-full p-2 mt-1 text-base transition duration-500 ease-in-out transform rounded-lg bg-white focus:shadow-outline" white="" 70="" href="#">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.09999 13.34L10.93 10.51L3.90999 3.5C2.34999 5.06 2.34999 7.59 3.90999 9.16L8.09999 13.34ZM14.88 11.53C16.41 12.24 18.56 11.74 20.15 10.15C22.06 8.24 22.43 5.5 20.96 4.03C19.5 2.57 16.76 2.93 14.84 4.84C13.25 6.43 12.75 8.58 13.46 10.11L3.69999 19.87L5.10999 21.28L12 14.41L18.88 21.29L20.29 19.88L13.41 13L14.88 11.53Z" fill="#004467"/>
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a class="inline-flex items-center w-full p-2 mt-1 text-base transition duration-500 ease-in-out transform rounded-lg bg-white focus:shadow-outline" white="" 70="" href="#">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M20 3H4V13C4 15.21 5.79 17 8 17H14C16.21 17 18 15.21 18 13V10H20C21.11 10 22 9.1 22 8V5C22 3.89 21.11 3 20 3ZM20 8H18V5H20V8ZM4 19H20V21H4V19Z" fill="#004467"/>
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a class="inline-flex items-center w-full p-2 mt-1 text-base transition duration-500 ease-in-out transform rounded-lg bg-white focus:shadow-outline" white="" 70="" href="#">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15 18.5C12.49 18.5 10.32 17.08 9.24 15H15V13H8.58C8.53 12.67 8.5 12.34 8.5 12C8.5 11.66 8.53 11.33 8.58 11H15V9H9.24C10.32 6.92 12.5 5.5 15 5.5C16.61 5.5 18.09 6.09 19.23 7.07L21 5.3C19.41 3.87 17.3 3 15 3C11.08 3 7.76 5.51 6.52 9H3V11H6.06C6.02 11.33 6 11.66 6 12C6 12.34 6.02 12.67 6.06 13H3V15H6.52C7.76 18.49 11.08 21 15 21C17.31 21 19.41 20.13 21 18.7L19.22 16.93C18.09 17.91 16.62 18.5 15 18.5Z" fill="#004467"/>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <div class="pt-28 pb-1 flex flex-col items-center">
                                    <button type="submit" class="inline-flex items-center p-2 mt-1 text-base transition duration-500 ease-in-out transform rounded-lg bg-red-700 focus:shadow-outline" white="" 70="">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13 3H11V13H13V3ZM17.83 5.17L16.41 6.59C17.99 7.86 19 9.81 19 12C19 15.87 15.87 19 12 19C8.13 19 5 15.87 5 12C5 9.81 6.01 7.86 7.58 6.58L6.17 5.17C4.23 6.82 3 9.26 3 12C3 16.97 7.03 21 12 21C16.97 21 21 16.97 21 12C21 9.26 19.77 6.82 17.83 5.17Z" fill="white"/>
                                        </svg>
                                    </button>
                                    <span class="pt-2 font-light text-sm text-red-700">Cerrar sesión</span>
                                </div>
                            </form>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col flex-1 w-0 overflow-hidden">
            <div class="px-1 mt-20 absolute z-10 main-color-blue-bg rounded-r-xl shadow-lg">
                <button class="focus:outline-none focus:shadow-outline" :class="open ? 'hidden md:block' : ''" x-on:click="open = ! open">
                    <div x-show="!open">
                        <svg width="35" height="56" viewBox="0 0 35 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M34.3536 28.3536C34.5488 28.1583 34.5488 27.8417 34.3536 27.6464L31.1716 24.4645C30.9763 24.2692 30.6597 24.2692 30.4645 24.4645C30.2692 24.6597 30.2692 24.9763 30.4645 25.1716L33.2929 28L30.4645 30.8284C30.2692 31.0237 30.2692 31.3403 30.4645 31.5355C30.6597 31.7308 30.9763 31.7308 31.1716 31.5355L34.3536 28.3536ZM20 28.5L34 28.5V27.5L20 27.5V28.5Z" fill="#FFC000"/>
                            <path d="M8.07 37.072C8.65 37.072 9.13333 37.272 9.52 37.672C9.9 38.0653 10.09 38.6686 10.09 39.482V40.822L13 40.822V41.732H6.03V39.482C6.03 38.6953 6.22 38.0986 6.6 37.692C6.98 37.2786 7.47 37.072 8.07 37.072ZM9.34 39.482C9.34 38.9753 9.23 38.602 9.01 38.362C8.79 38.122 8.47667 38.002 8.07 38.002C7.21 38.002 6.78 38.4953 6.78 39.482V40.822H9.34V39.482ZM11.45 31.8209V34.8609L13 35.4209V36.3809L6.07 33.8609V32.8109L13 30.3009V31.2609L11.45 31.8209ZM10.71 32.0809L7.19 33.3409L10.71 34.6009V32.0809ZM13 23.7227V24.6327L7.45 28.2927H13V29.2027H6.02V28.2927L11.56 24.6327H6.02V23.7227H13ZM6.77 21.2614H9.1V18.7214H9.85V21.2614H12.25V18.4214H13V22.1714H6.02V18.4214H6.77V21.2614ZM12.26 16.1345L12.26 13.6945H13L13 17.0445H6.03V16.1345H12.26Z" fill="#FFC000"/>
                        </svg>
                    </div>
                    <div class="py-5 px-3" x-show="open">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="0.646447" y1="14.7886" x2="14.7886" y2="0.646461" stroke="#FFC000"/>
                            <line x1="1.35355" y1="0.646447" x2="15.4957" y2="14.7886" stroke="#FFC000"/>
                        </svg>
                    </div>
                </button>
            </div>
            <main class="relative flex-1 overflow-y-auto focus:outline-none bg-gray-100">
                <div class="py-6">
                    <div class="px-4 mx-auto max-w-7xl sm:px-6 md:px-8">
                        <!-- Put your content here -->
                        <div class="px-4 mx-auto max-w-7xl sm:px-6 md:px-8">
                            @yield('content')
                        </div>
                        <!-- Do not cross the closing tag underneath this coment-->
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
