<div class="flex flex-col h-full justify-center items-center bg-transparent transition duration-500">
    <div>
        {{ $logo }}
    </div>

    <div class="backdrop-filter w-full sm:max-w-md mt-6 px-6 py-4 bg-transparent transition duration-500 shadow-xl overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
