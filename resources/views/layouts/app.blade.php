<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cantina | {{Auth::user() && (Auth::user())->isAn('administrator|employee') ? 'Administración' : '¡Bienvenido a la cantina!'}}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/extra-styles.css') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        //On page load or when changing themes, best to add inline in `head` to avoid FOUC
        window.onload = function() {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            }
        };
        const toggleDarkMode = function() {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                localStorage.theme = 'light'
                document.documentElement.classList.remove('dark')
                // Whenever the user explicitly chooses light mode
            } else {
                localStorage.theme = 'dark'
                document.documentElement.classList.add('dark')
                // Whenever the user explicitly chooses dark mode
            }
        }

        $(window).on("load", function() {
            $(".loading-screen").fadeOut("slow");
        });

    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-800 transition duration-500">
    <div class="loading-screen flex w-screen h-screen mx-auto items-center justify-center absolute z-50 overflow-hidden bg-gray-100 dark:bg-gray-800 transition duration-500">
        <img src="{{ URL::asset('img/Loading.png') }}" alt="Loading..." width="200" height="auto">
    </div>
    <div class="flex h-screen bg-white" x-data="{ open: false }">

        <x-sidenav />

        <div class="flex flex-col flex-1 w-0 overflow-hidden">
            <x-open-close-navbar />
            <main class="ieslogo relative flex-1 overflow-y-auto overflow-x-hidden focus:outline-none bg-gray-100 dark:bg-gray-800 transition duration-500 z-10">
                {{ $slot }}
            </main>
        </div>
    </div>
    @livewireScripts
</body>
</html>
