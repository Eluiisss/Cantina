<div :class="open ? 'hidden md:block' : ''" class="px-1 py-2 margintop absolute z-20 main-color-blue-bg dark:main-color-yellow-bg transition duration-500 rounded-r-xl shadow-lg">
    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md main-color-yellow-text dark:main-color-blue-text focus:outline-none transition duration-500 ease-in-out">
        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
