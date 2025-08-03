<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Apiario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 bg-gradient-to-br from-yellow-300 to-orange-400">
                    <h3 class="text-2xl font-bold text-white mb-4">{{ __('Nuevo Apiario') }}</h3>
                    <form action="{{ route('apiaries.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-white text-sm font-bold mb-2">{{ __('Nombre') }}</label>
                            <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                        <div class="mb-4">
                            <label for="location" class="block text-white text-sm font-bold mb-2">{{ __('Ubicación') }}</label>
                            <input type="text" name="location" id="location" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                {{ __('Guardar') }}
                            </button>
                            <a href="{{ route('apiaries.index') }}" class="inline-block align-baseline font-bold text-sm text-white hover:text-gray-200">
                                {{ __('Cancelar') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
