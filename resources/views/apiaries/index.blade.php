<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
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
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300 ease-in-out">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $apiary->name }}</h3>
                            <p class="text-sm text-gray-600 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                {{ $apiary->location }}
                            </p>
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('apiaries.show', $apiary) }}" class="text-sm text-green-600 hover:text-green-900 font-semibold">Ver</a>
                                <a href="{{ route('apiaries.edit', $apiary) }}" class="text-sm text-blue-600 hover:text-blue-900 font-semibold">Editar</a>
                                <form action="{{ route('apiaries.destroy', $apiary) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-900 font-semibold">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12">
                        <p class="text-gray-500 text-lg">{{ __('No tienes apiarios todavía.') }}</p>
                        <p class="text-gray-400 mt-2">{{ __('¡Crea tu primer apiario para empezar a gestionar tus colmenas!') }}</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $apiaries->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
