<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Apiarios') }}
            </h2>
            <a href="{{ route('apiaries.create') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-400 active:bg-yellow-600 focus:outline-none focus:border-yellow-600 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Crear Apiario') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($apiaries as $apiary)
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg transform hover:scale-105 transition-transform duration-300">
                        <div class="p-6 bg-gradient-to-br from-yellow-300 to-orange-400">
                            <h3 class="text-2xl font-bold text-white mb-2">{{ $apiary->name }}</h3>
                            <p class="text-white opacity-90">{{ $apiary->location }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 flex justify-end space-x-2">
                            <a href="{{ route('apiaries.show', $apiary) }}" class="text-blue-500 hover:text-blue-700 font-semibold">Ver</a>
                            <a href="{{ route('apiaries.edit', $apiary) }}" class="text-green-500 hover:text-green-700 font-semibold">Editar</a>
                            <form action="{{ route('apiaries.destroy', $apiary) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Eliminar</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $apiaries->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
