<x-app-layout>
    <div class="container px-5 py-6 mx-auto">
        <div class="flex flex-col w-full h-auto rounded-3xl">
            <section class="backdrop-filter flex flex-col shadow-lg pt-3 w-full bg-transparent rounded-3xl">
                @livewire('order-manage-side-bar')
            </section>
            <section class="backdrop-filter w-full px-4 flex flex-col shadow-lg bg-transparent rounded-3xl mt-4">
                @livewire('order-manage-detail-view')
            </section>
        </div>
    </div>
</x-app-layout>
