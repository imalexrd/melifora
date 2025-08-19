<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-dark-text-dark">
                {{ __('Apiarios') }}
            </h2>
            <a href="{{ route('apiaries.create') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-400 active:bg-yellow-600 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Crear Apiario') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($apiaries as $apiary)
                    <a href="{{ route('apiaries.show', $apiary) }}" class="block bg-white rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300 ease-in-out dark:bg-dark-surface dark:hover:bg-gray-700">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <h3 class="text-lg font-bold text-gray-900 mb-2 dark:text-dark-text-dark">{{ $apiary->name }}</h3>
                                <span class="px-2 py-1 text-xs font-semibold text-white rounded-full {{ \App\Models\Apiary::getStatusColorMap()[$apiary->status] ?? 'bg-gray-400' }}">
                                    {{ $apiary->status }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-4 flex items-center dark:text-dark-text-light">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                {{ $apiary->location }}
                            </p>
                            <div class="flex justify-between items-center text-sm text-gray-500 dark:text-dark-text-light">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v1H2V6zM2 9v7a2 2 0 002 2h12a2 2 0 002-2V9H2zm4-4a1 1 0 100-2 1 1 0 000 2zM14 5a1 1 0 100-2 1 1 0 000 2z"/>
                                    </svg>
                                    <span>{{ $apiary->hives_count }} {{ trans_choice('Colmena|Colmenas', $apiary->hives_count) }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $apiary->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12">
                        <p class="text-gray-500 text-lg dark:text-dark-text-light">{{ __('No tienes apiarios todavía.') }}</p>
                        <p class="text-gray-400 mt-2 dark:text-gray-500">{{ __('¡Crea tu primer apiario para empezar a gestionar tus colmenas!') }}</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $apiaries->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
