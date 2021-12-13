<x-app-layout>
    @include('shared._errors')
    <section class="py-1">
        <div class="backdrop-filter w-full md:w-8/12 px-4 mx-auto mt-6 shadow-lg rounded-lg border-0">
            <div class="relative flex flex-col min-w-0 break-words w-full mb-6">
                <div class="rounded-t bg-transparent mb-0 px-6 py-6">
                    <div class="flex justify-end">
                        <h6 class="px-1 main-color-blue-text dark:main-color-yellow-text transition duration-500 font-bold md:text-3xl uppercase">
                            {{ trans('articles.create.title') }}
                        </h6>
                    </div>
                </div>
                <div class="flex-auto px-4 lg:px-10 py-10 pt-0 main-color-blue-text dark:main-color-yellow-text transition duration-500">
                    <form method="post" action="{{ route('articles.store') }}" enctype="multipart/form-data">
                        @include('articles._fields')
                        <div class="flex flex-auto justify-end items-center">
                            <button class="main-color-yellow-text main-color-blue-bg active:bg-green-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-500" type="submit">
                                Crear
                            </button>
                            <a href="{{ route('articles.index') }}" class="bg-red-700 text-white font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-500">
                                Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
