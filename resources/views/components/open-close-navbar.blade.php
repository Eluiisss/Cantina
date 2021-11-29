<div class="px-1 mt-16 absolute z-20 main-color-blue-bg dark:main-color-yellow-bg transition duration-500 rounded-r-xl shadow-lg">
    <button class="focus:outline-none focus:shadow-outline" :class="open ? 'hidden md:block' : ''" x-on:click="open = ! open">
        <div class="dark:main-color-blue-text transition duration-500" x-cloak x-show="!open" x-transition>
            <svg width="35" height="56" viewBox="0 0 35 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M34.3536 28.3536C34.5488 28.1583 34.5488 27.8417 34.3536 27.6464L31.1716 24.4645C30.9763 24.2692 30.6597 24.2692 30.4645 24.4645C30.2692 24.6597 30.2692 24.9763 30.4645 25.1716L33.2929 28L30.4645 30.8284C30.2692 31.0237 30.2692 31.3403 30.4645 31.5355C30.6597 31.7308 30.9763 31.7308 31.1716 31.5355L34.3536 28.3536ZM20 28.5L34 28.5V27.5L20 27.5V28.5Z" fill="#FFC000"/>
                <path d="M8.07 37.072C8.65 37.072 9.13333 37.272 9.52 37.672C9.9 38.0653 10.09 38.6686 10.09 39.482V40.822L13 40.822V41.732H6.03V39.482C6.03 38.6953 6.22 38.0986 6.6 37.692C6.98 37.2786 7.47 37.072 8.07 37.072ZM9.34 39.482C9.34 38.9753 9.23 38.602 9.01 38.362C8.79 38.122 8.47667 38.002 8.07 38.002C7.21 38.002 6.78 38.4953 6.78 39.482V40.822H9.34V39.482ZM11.45 31.8209V34.8609L13 35.4209V36.3809L6.07 33.8609V32.8109L13 30.3009V31.2609L11.45 31.8209ZM10.71 32.0809L7.19 33.3409L10.71 34.6009V32.0809ZM13 23.7227V24.6327L7.45 28.2927H13V29.2027H6.02V28.2927L11.56 24.6327H6.02V23.7227H13ZM6.77 21.2614H9.1V18.7214H9.85V21.2614H12.25V18.4214H13V22.1714H6.02V18.4214H6.77V21.2614ZM12.26 16.1345L12.26 13.6945H13L13 17.0445H6.03V16.1345H12.26Z" fill="#FFC000"/>
            </svg>
        </div>
        <div class="py-5 px-3 dark:main-color-blue-text transition duration-500" x-cloak x-show="open">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <line x1="0.646447" y1="14.7886" x2="14.7886" y2="0.646461" stroke="#FFC000"/>
                <line x1="1.35355" y1="0.646447" x2="15.4957" y2="14.7886" stroke="#FFC000"/>
            </svg>
        </div>
    </button>
</div>
