<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Colmena') }}: {{ $hive->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('hives.update', $hive) }}">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Nombre de la Colmena')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $hive->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Slug -->
                            <div>
                                <x-input-label for="slug" :value="__('Slug')" />
                                <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug', $hive->slug)" required />
                                <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                            </div>

                            <!-- Apiary -->
                            <div>
                                <x-input-label for="apiary_id" :value="__('Apiario')" />
                                <select id="apiary_id" name="apiary_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @foreach ($apiaries as $apiary)
                                        <option value="{{ $apiary->id }}" @if (old('apiary_id', $hive->apiary_id) == $apiary->id) selected @endif>{{ $apiary->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('apiary_id')" class="mt-2" />
                            </div>

                            <!-- Type -->
                            <div>
                                <x-input-label for="type" :value="__('Tipo')" />
                                <select id="type" name="type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @foreach (['Langstroth', 'Dadant', 'Layens', 'Top-Bar', 'Warre', 'Flow'] as $type)
                                        <option value="{{ $type }}" @if (old('type', $hive->type) == $type) selected @endif>{{ $type }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Estado')" />
                                <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @foreach (['Desconocido', 'Activa', 'Invernando', 'Enjambrazon', 'Despoblada', 'Huerfana', 'Zanganera', 'En formacion', 'Revision', 'Mantenimiento', 'Alimentacion Artificial', 'Crianza de reinas', 'Pillaje', 'Pillera', 'Union', 'Sin uso'] as $status)
                                        <option value="{{ $status }}" @if (old('status', $hive->status) == $status) selected @endif>{{ $status }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Birth Date -->
                            <div>
                                <x-input-label for="birth_date" :value="__('Fecha de Nacimiento')" />
                                <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" :value="old('birth_date', $hive->birth_date ? $hive->birth_date->format('Y-m-d') : '')" />
                                <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                            </div>

                            <!-- Rating -->
                            <div>
                                <x-input-label for="rating" :value="__('Rating (0-100)')" />
                                <x-text-input id="rating" class="block mt-1 w-full" type="number" name="rating" :value="old('rating', $hive->rating)" min="0" max="100" />
                                <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                            </div>

                            <!-- QR Code -->
                            <div>
                                <x-input-label for="qr_code" :value="__('QR Code')" />
                                <x-text-input id="qr_code" class="block mt-1 w-full" type="text" name="qr_code" :value="old('qr_code', $hive->qr_code)" />
                                <x-input-error :messages="$errors->get('qr_code')" class="mt-2" />
                            </div>

                            <!-- Location -->
                            <div class="md:col-span-2">
                                <x-input-label for="location" :value="__('Ubicación Específica')" />
                                <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location', $hive->location)" />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <x-input-label for="notes" :value="__('Notas')" />
                                <textarea id="notes" name="notes" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes', $hive->notes) }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('hives.show', $hive) }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button>
                                {{ __('Actualizar Colmena') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
