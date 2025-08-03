<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Apiario') }}: {{ $apiary->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('apiaries.update', $apiary) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Name -->
                        <div>
                            <label for="name">{{ __('Nombre') }}</label>
                            <input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $apiary->name) }}" required autofocus />
                        </div>

                        <!-- Location -->
                        <div class="mt-4">
                            <label for="location">{{ __('Ubicación') }}</label>
                            <input id="location" class="block mt-1 w-full" type="text" name="location" value="{{ old('location', $apiary->location) }}" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4">
                                {{ __('Actualizar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
