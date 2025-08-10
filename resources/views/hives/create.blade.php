<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nueva Colmena') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('hives.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Number of Hives -->
                            <div>
                                <x-input-label for="number_of_hives" :value="__('Número de Colmenas')" />
                                <x-text-input id="number_of_hives" class="block mt-1 w-full" type="number" name="number_of_hives" :value="old('number_of_hives', 1)" required min="1" max="250" />
                                <x-input-error :messages="$errors->get('number_of_hives')" class="mt-2" />
                            </div>

                            <!-- Apiary -->
                            <div>
                                <x-input-label for="apiary_id" :value="__('Apiario')" />
                                <select id="apiary_id" name="apiary_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Selecciona un apiario</option>
                                    @foreach ($apiaries as $apiary)
                                        <option value="{{ $apiary->id }}" {{ old('apiary_id') == $apiary->id ? 'selected' : '' }}>{{ $apiary->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('apiary_id')" class="mt-2" />
                            </div>

                            <!-- Type -->
                            <div>
                                <x-input-label for="type" :value="__('Tipo de Colmena')" />
                                <select id="type" name="type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @foreach (['Langstroth', 'Dadant', 'Layens', 'Top-Bar', 'Warre', 'Flow'] as $type)
                                        <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('hives.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button>
                                {{ __('Crear Colmenas') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
