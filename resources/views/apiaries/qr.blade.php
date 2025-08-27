<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-dark-text-dark">
            {{ __('Código QR para el Apiario') }}: {{ $apiary->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-dark-surface overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-dark-text-light">
                    <div class="flex flex-col items-center justify-center space-y-6">
                        <div class="text-center">
                            <h3 class="text-2xl font-bold">{{ $apiary->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $apiary->slug }}</p>
                        </div>

                        <div class="p-4 bg-white rounded-lg shadow-md">
                            {!! QrCode::size(300)->generate(route('apiaries.show', $apiary)) !!}
                        </div>

                        <div class="text-center space-y-2">
                            <p><strong>Ubicación:</strong> {{ $apiary->location }}</p>
                            <p><strong>Número de colmenas:</strong> {{ $apiary->hives->count() }}</p>
                        </div>

                        <div class="flex space-x-4 mt-4">
                             <a href="{{ route('apiaries.show', $apiary) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Volver al Apiario') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
