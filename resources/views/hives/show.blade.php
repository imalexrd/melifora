<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hive Header Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6 dark:bg-dark-surface">
                <div class="p-6 flex items-center">
                    <div class="w-28 text-center mr-6 flex-shrink-0">
                        <div id="qr-code-container" class="relative inline-block bg-white p-2 rounded-lg">
                            {!! QrCode::size(90)->generate(route('hives.show', $hive)) !!}
                        </div>
                        <div class="flex items-center justify-center mt-2 space-x-2">
                            <a href="{{ route('hives.qr', $hive) }}" target="_blank" class="text-primary hover:text-primary-dark" title="Ver QR">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v4m0 0h-4m4 0l-5-5" />
                                </svg>
                            </a>
                            <a href="#" id="download-qr" class="text-primary hover:text-primary-dark" title="Descargar SVG">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-dark-text-dark">{{ $hive->name }}</h3>
                                    <button id="toggle-edit-form" class="text-secondary hover:text-secondary-dark" title="Editar Colmena">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button id="toggle-states-form" class="text-info hover:text-info-dark" title="Gestionar Estados">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-dark-text-light mt-1">{{ $hive->slug }}</p>
                                <p class="text-gray-600 dark:text-dark-text-light">{{ $hive->type }}</p>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @forelse ($hive->states as $state)
                                    <span class="px-3 py-1 text-sm font-semibold text-white rounded-full {{
                                        match($state->type) {
                                            'good' => 'bg-green-500',
                                            'bad' => 'bg-red-500',
                                            'neutral' => 'bg-yellow-500',
                                            default => 'bg-gray-500',
                                        }
                                    }}" title="{{ $state->description }} - Causa: {{ $state->pivot->cause }}">
                                        {{ $state->name }}
                                    </span>
                                @empty
                                    <span class="px-3 py-1 text-sm font-semibold text-white rounded-full bg-gray-500">
                                        Estado desconocido
                                    </span>
                                @endforelse
                            </div>
                        </div>
                        <div class="mt-2 text-sm text-gray-500 dark:text-dark-text-light">
                            <p><strong>Apiario:</strong> {{ $hive->apiary->name }}</p>
                            <p><strong>Nacimiento:</strong> {{ $hive->birth_date ? $hive->birth_date->format('d/m/Y') : 'N/A' }}</p>
                        </div>
                        <div class="mt-4 flex items-center space-x-4">
                            <div class="flex items-center space-x-1">
                                <svg class="h-6 w-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                <span class="font-bold text-lg text-gray-800 dark:text-dark-text-dark">{{ $hive->rating ?? 'N/A' }}</span>
                                <span class="text-gray-600 dark:text-dark-text-light">/ 100</span>
                            </div>
                            @if($hive->latestHarvest)
                                <div class="flex items-center space-x-1">
                                    <svg class="h-6 w-6 text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10s5 2 5 2l-2.646 2.646a.5.5 0 00.708.708L15 12.5V15a1 1 0 001 1h.5a1 1 0 001-1v-2.5l2.121-2.121a.5.5 0 00-.353-.854H18a1 1 0 00-1 1v1.5l-2.646 2.646a.5.5 0 00.708.708L17.5 15V12a1 1 0 00-1-1h-1.5a1 1 0 00-1 1v1.5l-2.646 2.646a.5.5 0 00.708.708L15 15.5V18a1 1 0 001 1h.5a1 1 0 001-1v-2.5l2.121-2.121a.5.5 0 00-.353-.854H18a1 1 0 00-1 1v1.5l-2.646 2.646a.5.5 0 00.708.708L17.5 18H19a1 1 0 001-1v-1.5l-2.121-2.121a.5.5 0 00-.854.353V15a1 1 0 001 1h.5a1 1 0 001-1v-1.5l-2.121-2.121a.5.5 0 00-.854.353V12a1 1 0 001 1h1.5a1 1 0 001-1V9.5a1 1 0 00-1-1h-1.5a1 1 0 00-1 1V12l-2.646 2.646a.5.5 0 00.708.708L12.5 12H15a1 1 0 001-1V9.5a1 1 0 00-1-1h-1.5a1 1 0 00-1 1V12l-2.646 2.646a.5.5 0 00.708.708L10 12h2.5a1 1 0 001-1V9.5a1 1 0 00-1-1H12a1 1 0 00-1 1v2.5L8.879 9.379a.5.5 0 00-.854.353V12a1 1 0 001 1h1.5a1 1 0 001-1V9.5a1 1 0 00-1-1H9a1 1 0 00-1 1v2.5L5.879 9.379a.5.5 0 00-.854.353V12a1 1 0 001 1h1.5a1 1 0 001-1V9.5a1 1 0 00-1-1H6a1 1 0 00-1 1v2.5L2.879 9.379a.5.5 0 00-.854.353V12a1 1 0 001 1h1.5a1 1 0 001-1V9.5a1 1 0 00-1-1H3a1 1 0 00-1 1v2.5a8 8 0 0115.657 5.157z"/>
                                    </svg>
                                    <span class="font-bold text-lg text-gray-800 dark:text-dark-text-dark">{{ $hive->latestHarvest->quantity_kg }} kg</span>
                                    <span class="text-gray-600 dark:text-dark-text-light">({{ $hive->latestHarvest->harvest_date->format('d/m/Y') }})</span>
                                </div>
                            @endif
                            @if($hive->location_gps)
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $hive->location_gps }}" target="_blank" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('Ver en Mapa') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div id="edit-hive-form" class="hidden bg-white rounded-lg shadow-md overflow-hidden p-6 mb-8 dark:bg-dark-surface">
                <form method="POST" action="{{ route('hives.update', $hive) }}">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Nombre de la Colmena')" class="dark:text-dark-text-light" />
                            <x-text-input id="name" class="block mt-1 w-full dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" type="text" name="name" :value="old('name', $hive->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Apiary -->
                        <div>
                            <x-input-label for="apiary_id" :value="__('Apiario')" class="dark:text-dark-text-light" />
                            <select id="apiary_id" name="apiary_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" required>
                                @foreach ($apiaries as $apiary)
                                    <option value="{{ $apiary->id }}" @if (old('apiary_id', $hive->apiary_id) == $apiary->id) selected @endif>{{ $apiary->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('apiary_id')" class="mt-2" />
                        </div>

                        <!-- Type -->
                        <div>
                            <x-input-label for="type" :value="__('Tipo')" class="dark:text-dark-text-light" />
                            <select id="type" name="type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" required>
                                @foreach ($types as $type)
                                    <option value="{{ $type }}" @if (old('type', $hive->type) == $type) selected @endif>{{ $type }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Birth Date -->
                        <div>
                            <x-input-label for="birth_date" :value="__('Fecha de Nacimiento')" class="dark:text-dark-text-light" />
                            <x-text-input id="birth_date" class="block mt-1 w-full dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" type="date" name="birth_date" :value="old('birth_date', $hive->birth_date ? $hive->birth_date->format('Y-m-d') : '')" />
                            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                        </div>

                        <!-- QR Code -->
                        <div>
                            <x-input-label for="qr_code" :value="__('QR Code')" class="dark:text-dark-text-light" />
                            <x-text-input id="qr_code" class="block mt-1 w-full dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" type="text" name="qr_code" :value="old('qr_code', $hive->qr_code)" />
                            <x-input-error :messages="$errors->get('qr_code')" class="mt-2" />
                        </div>

                        <!-- Location -->
                        <div>
                            <x-input-label for="location" :value="__('Ubicación Específica')" class="dark:text-dark-text-light" />
                            <x-text-input id="location" class="block mt-1 w-full dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" type="text" name="location" :value="old('location', $hive->location)" />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <!-- Location GPS -->
                        <div>
                            <x-input-label for="location_gps" :value="__('Coordenadas GPS')" class="dark:text-dark-text-light" />
                            <div class="flex items-center gap-2">
                                <x-text-input id="location_gps" class="block mt-1 w-full dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" type="text" name="location_gps" :value="old('location_gps', $hive->location_gps)" autocomplete="off" />
                                <button type="button" id="open-map-modal" class="whitespace-nowrap inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="hidden md:inline">{{ $hive->location_gps ? __('Ver/Editar') : __('Seleccionar') }}</span>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('location_gps')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            {{ __('Actualizar Colmena') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- States Form -->
            <div id="states-hive-form" class="hidden bg-white rounded-lg shadow-md overflow-hidden p-6 mb-8 dark:bg-dark-surface">
                <form method="POST" action="{{ route('hives.states.update', $hive) }}">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($states as $category => $statesInCategory)
                            @if($category && !Str::contains($category, 'Inspección'))
                            <div class="p-4 border rounded-lg dark:border-gray-700">
                                <h4 class="font-semibold text-lg mb-2 dark:text-dark-text-dark">{{ $category }}</h4>
                                <div class="space-y-2">
                                    @foreach ($statesInCategory as $state)
                                        <label for="state-{{ $state->id }}" class="flex items-center">
                                            <input type="checkbox" id="state-{{ $state->id }}" name="states[]" value="{{ $state->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:focus:ring-indigo-400" @if ($hive->states->where('pivot.cause', 'Manual')->contains($state->id)) checked @endif>
                                            <span class="ml-2 text-sm text-gray-600 dark:text-dark-text-light">{{ $state->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('states')" class="mt-2" />


                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            {{ __('Actualizar Estados') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Tab Navigation -->
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-primary text-primary dark:border-dark-primary dark:text-dark-primary" data-tab="inspections">
                        {{ __('Inspecciones') }}
                    </button>
                    <button class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-500" data-tab="harvest">
                        {{ __('Cosecha') }}
                    </button>
                    <button class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-500" data-tab="supers">
                        {{ __('Alzas') }}
                    </button>
                    <button class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-500" data-tab="queen">
                        {{ __('Reina') }}
                    </button>
                    <button class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-500" data-tab="general">
                        {{ __('General') }}
                    </button>
                    <button class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-500" data-tab="notes">
                        {{ __('Notas') }}
                    </button>
                    <button class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:border-gray-500" data-tab="activity">
                        {{ __('Actividad') }}
                    </button>
                </nav>
            </div>

            <!-- Tab Content -->
            <div class="bg-white rounded-b-lg shadow-md p-6 dark:bg-dark-surface">
                <!-- Queen Tab -->
                <div id="queen-content" class="tab-content hidden">
                    <h4 class="text-xl font-semibold mb-4 dark:text-dark-text-dark">Reina Actual e Historial</h4>
                    <!-- Current Queen -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center border-b pb-2 mb-4 dark:border-gray-700">
                            <h5 class="text-lg font-semibold text-gray-800 dark:text-dark-text-dark">Reina Actual</h5>
                            <div>
                                @if ($hive->queen)
                                    <button id="toggle-edit-queen-form" class="text-sm text-blue-600 hover:underline dark:text-blue-400 dark:hover:text-blue-300">Editar</button>
                                    <button id="toggle-replace-queen-form" class="ml-4 text-sm text-green-600 hover:underline dark:text-green-400 dark:hover:text-green-300">Reemplazar</button>
                                    <form action="{{ route('queen.destroy', $hive->queen) }}" method="POST" class="inline ml-4" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta reina? Esto la marcará como eliminada y creará un registro en el historial.');">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="reason" value="Eliminada">
                                        <button type="submit" class="text-sm text-red-600 hover:underline dark:text-red-400 dark:hover:text-red-300">Marcar como Eliminada</button>
                                    </form>
                                @else
                                    <button id="toggle-add-queen-form" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">Añadir Reina</button>
                                @endif
                            </div>
                        </div>

                        @if ($hive->queen)
                            <div id="queen-details" class="dark:text-dark-text-light">
                                <p><strong>Raza:</strong> {{ $hive->queen->breed ?? 'N/A' }}</p>
                                <p><strong>Introducida:</strong> {{ $hive->queen->introduction_date ? $hive->queen->introduction_date->format('d/m/Y') : 'N/A' }}</p>
                                <p><strong>Edad (meses):</strong> {{ $hive->queen->age ?? 'N/A' }}</p>
                                <p><strong>Estado:</strong> <span class="capitalize">{{ $hive->queen->status }}</span></p>
                            </div>

                            <!-- Edit Queen Form -->
                            <div id="edit-queen-form" class="hidden mt-4 p-4 bg-gray-50 rounded-lg border dark:bg-gray-700 dark:border-gray-600">
                                <h6 class="text-md font-semibold text-gray-700 mb-3 dark:text-dark-text-dark">Editar Reina Actual</h6>
                                <form action="{{ route('queen.update', $hive->queen) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <x-input-label for="edit_breed" :value="__('Raza')" class="dark:text-dark-text-light" />
                                            <x-text-input id="edit_breed" class="block mt-1 w-full dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" type="text" name="breed" :value="old('breed', $hive->queen->breed)" />
                                        </div>
                                        <div>
                                            <x-input-label for="edit_introduction_date" :value="__('Fecha de Introducción')" class="dark:text-dark-text-light" />
                                            <x-text-input id="edit_introduction_date" class="block mt-1 w-full dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" type="date" name="introduction_date" :value="old('introduction_date', $hive->queen->introduction_date ? $hive->queen->introduction_date->format('Y-m-d') : '')" />
                                        </div>
                                        <div>
                                            <x-input-label for="edit_age" :value="__('Edad (meses)')" class="dark:text-dark-text-light" />
                                            <x-text-input id="edit_age" class="block mt-1 w-full dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" type="number" name="age" :value="old('age', $hive->queen->age)" />
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-end mt-4">
                                        <x-secondary-button type="button" id="cancel-edit-queen">Cancelar</x-secondary-button>
                                        <x-primary-button class="ml-3">Actualizar Reina</x-primary-button>
                                    </div>
                                </form>
                            </div>

                            <!-- Replace Queen Form -->
                            <div id="replace-queen-form" class="hidden mt-4 p-4 bg-gray-50 rounded-lg border dark:bg-gray-700 dark:border-gray-600">
                                 <h6 class="text-md font-semibold text-gray-700 mb-3 dark:text-dark-text-dark">Registrar Nueva Reina (Reemplazo)</h6>
                                <form action="{{ route('queen.replace', $hive->queen) }}" method="POST">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <x-input-label for="replace_breed" :value="__('Raza de la Nueva Reina')" class="dark:text-dark-text-light" />
                                            <x-text-input id="replace_breed" class="block mt-1 w-full dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" type="text" name="breed" required />
                                        </div>
                                        <div>
                                            <x-input-label for="replace_introduction_date" :value="__('Fecha de Introducción')" class="dark:text-dark-text-light" />
                                            <x-text-input id="replace_introduction_date" class="block mt-1 w-full dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" type="date" name="introduction_date" required />
                                        </div>
                                        <div>
                                            <x-input-label for="replace_age" :value="__('Edad (meses)')" class="dark:text-dark-text-light" />
                                            <x-text-input id="replace_age" class="block mt-1 w-full dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" type="number" name="age" />
                                        </div>
                                         <div class="md:col-span-2">
                                            <x-input-label for="replace_notes" :value="__('Notas del Reemplazo')" class="dark:text-dark-text-light" />
                                            <textarea id="replace_notes" name="notes" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary-light dark:bg-dark-surface dark:border-gray-600 dark:text-dark-text-dark"></textarea>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-end mt-4">
                                        <x-secondary-button type="button" id="cancel-replace-queen">Cancelar</x-secondary-button>
                                        <x-primary-button class="ml-3">Reemplazar Reina</x-primary-button>
                                    </div>
                                </form>
                            </div>

                        @else
                            <div class="text-center py-4 dark:text-dark-text-light">
                                <p>No hay información de la reina actual.</p>
                            </div>
                            <!-- Add Queen Form -->
                            <div id="add-queen-form" class="hidden mt-4 p-4 bg-gray-50 rounded-lg border dark:bg-gray-700 dark:border-gray-600">
                                <h6 class="text-md font-semibold text-gray-700 mb-3 dark:text-dark-text-dark">Añadir Nueva Reina</h6>
                                <form action="{{ route('hives.queen.store', $hive) }}" method="POST">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <x-input-label for="breed" :value="__('Raza')" class="dark:text-dark-text-light" />
                                            <x-text-input id="breed" class="block mt-1 w-full dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" type="text" name="breed" :value="old('breed')" required />
                                        </div>
                                        <div>
                                            <x-input-label for="introduction_date" :value="__('Fecha de Introducción')" class="dark:text-dark-text-light" />
                                            <x-text-input id="introduction_date" class="block mt-1 w-full dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" type="date" name="introduction_date" :value="old('introduction_date')" required />
                                        </div>
                                        <div>
                                            <x-input-label for="age" :value="__('Edad (meses)')" class="dark:text-dark-text-light" />
                                            <x-text-input id="age" class="block mt-1 w-full dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" type="number" name="age" :value="old('age')" />
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-end mt-4">
                                         <x-secondary-button type="button" id="cancel-add-queen">Cancelar</x-secondary-button>
                                        <x-primary-button class="ml-3">Añadir Reina</x-primary-button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                    <!-- Queen History -->
                    <div>
                        <h5 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-2 dark:text-dark-text-dark dark:border-gray-700">Historial de Reinas</h5>
                        @forelse ($hive->queenHistories->sortByDesc('change_date') as $history)
                            <div class="border-l-4 border-yellow-400 pl-4 mb-4 dark:border-yellow-500 dark:text-dark-text-light">
                                <p class="font-semibold">Fecha de cambio: {{ $history->change_date->format('d/m/Y') }}</p>
                                <p><strong>Razón:</strong> {{ $history->reason }}</p>
                                @if($history->queen_breed)
                                    <div class="text-sm text-gray-600 mt-2 dark:text-dark-text-light">
                                        <p class="font-medium">Detalles de la reina en ese momento:</p>
                                        <ul class="list-disc list-inside ml-4">
                                            <li>Raza: {{ $history->queen_breed }}</li>
                                            <li>Introducida: {{ $history->queen_introduction_date ? $history->queen_introduction_date->format('d/m/Y') : 'N/A' }}</li>
                                            <li>Edad: {{ $history->queen_age }} meses</li>
                                        </ul>
                                    </div>
                                @endif
                                <p><strong>Notas:</strong> {{ $history->notes ?? 'Sin notas.' }}</p>
                            </div>
                        @empty
                            <p class="dark:text-dark-text-light">No hay historial de reinas.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Inspections Tab -->
                @include('hives.partials.inspections', ['hive' => $hive])

                <!-- Harvest Tab -->
                <div id="harvest-content" class="tab-content hidden">
                    @include('hives.partials.harvest-form', ['hive' => $hive])
                    @include('hives.partials.harvest-history', ['hive' => $hive])
                </div>

                <!-- Supers Tab -->
                <div id="supers-content" class="tab-content hidden">
                    <h4 class="text-xl font-semibold mb-4 dark:text-dark-text-dark">Alzas Asignadas</h4>
                    <div class="mb-6">
                        @if ($hive->hiveSupers->count() > 0)
                            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($hive->hiveSupers as $super)
                                    <li class="py-2 flex items-center justify-between dark:text-dark-text-light">
                                        <span>{{ $super->tracking_code }}</span>
                                        <form action="{{ route('hive_supers.unassign', $super) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-sm text-red-600 hover:underline dark:text-red-400 dark:hover:text-red-300">Desasignar</button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="dark:text-dark-text-light">No hay alzas asignadas a esta colmena.</p>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-xl font-semibold mb-4 dark:text-dark-text-dark">Asignar Alza Específica</h4>
                            <div class="mb-4">
                                <input type="text" id="super-search" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary-light focus:ring-opacity-50 dark:bg-dark-surface dark:border-gray-600 dark:text-dark-text-dark" placeholder="Buscar alza por código...">
                            </div>
                            <form action="{{ route('hive_supers.assign', $hive) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="flex items-center space-x-4">
                                    <select name="hive_super_id" id="hive-super-select" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:bg-dark-surface dark:border-gray-600 dark:text-dark-text-dark">
                                        <option value="">Selecciona un alza</option>
                                        @foreach ($unassignedSupers as $super)
                                            <option value="{{ $super->id }}">{{ $super->tracking_code }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 active:bg-opacity-95 focus:outline-none focus:border-primary focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Asignar
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div>
                            <h4 class="text-xl font-semibold mb-4 dark:text-dark-text-dark">Asignar Alzas al Azar</h4>
                            <form action="{{ route('hive_supers.assignRandom', $hive) }}" method="POST">
                                @csrf
                                <div class="flex items-center space-x-4">
                                    <input type="number" name="number_to_assign" value="1" min="1" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:bg-dark-surface dark:border-gray-600 dark:text-dark-text-dark">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-secondary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 active:bg-opacity-95 focus:outline-none focus:border-secondary focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Asignar al Azar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- General Tab -->
                <div id="general-content" class="tab-content hidden">
                    <h4 class="text-xl font-semibold mb-4 dark:text-dark-text-dark">Información General</h4>
                    <p class="dark:text-dark-text-light">Aquí se mostrará información general de la colmena.</p>
                </div>

                <!-- Notes Tab -->
                <div id="notes-content" class="tab-content hidden py-6">
                    <div class="bg-white rounded-lg shadow-md dark:bg-dark-surface">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 dark:text-dark-text-dark">Añadir Nota o Tarea</h3>
                            <form id="add-note-form">
                                <div class="flex items-center space-x-4 mb-4">
                                    <label class="flex items-center">
                                        <input type="radio" name="type" value="note" class="text-primary focus:ring-primary-light" checked>
                                        <span class="ml-2 text-gray-700 dark:text-dark-text-light">Nota</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="type" value="task" class="text-primary focus:ring-primary-light">
                                        <span class="ml-2 text-gray-700 dark:text-dark-text-light">Tarea</span>
                                    </label>
                                </div>
                                <textarea id="note-content" name="content" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary-light focus:ring-opacity-50 dark:bg-dark-surface dark:border-gray-600 dark:text-dark-text-dark" placeholder="Escribe tu nota o la descripción de la tarea aquí..."></textarea>
                                <div id="due-date-container" class="hidden mt-4">
                                    <label for="due-date" class="block text-sm font-medium text-gray-700 dark:text-dark-text-light">Fecha de Vencimiento</label>
                                    <input type="datetime-local" id="due-date" name="due_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary-light focus:ring-opacity-50 dark:bg-dark-surface dark:border-gray-600 dark:text-dark-text-dark">
                                </div>
                                <div class="flex justify-end mt-4">
                                    <x-primary-button type="submit" id="save-note-button">
                                        {{ __('Guardar') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 dark:text-dark-text-dark">Historial de Notas</h3>
                        <div id="notes-list" class="space-y-6">
                            @forelse ($hive->notes as $note)
                                @include('hives.partials.note', ['note' => $note])
                            @empty
                                <div id="no-notes-message" class="text-center py-12">
                                    <p class="text-gray-500 text-lg dark:text-dark-text-light">{{ __('No hay notas para esta colmena.') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Activity Tab -->
                <div id="activity-content" class="tab-content hidden py-6">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden dark:bg-dark-surface">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 dark:text-dark-text-dark">Historial de Actividad</h3>
                        </div>
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($hive->activities as $activity)
                                <li class="p-4 sm:p-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-gray-200 rounded-full p-2 dark:bg-gray-700">
                                             <svg class="h-6 w-6 text-gray-600 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4 flex-grow">
                                            <p class="text-sm text-gray-800 dark:text-dark-text-dark">{{ $activity->description }}</p>
                                            <p class="text-xs text-gray-500 dark:text-dark-text-light">
                                                {{ $activity->created_at->diffForHumans() }}
                                                @if ($activity->user)
                                                    por {{ $activity->user->name }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="p-6 text-center">
                                    <p class="text-gray-500 dark:text-dark-text-light">{{ __('No hay actividad registrada para esta colmena.') }}</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-google-maps-modal />

    @push('scripts')
    <script>
        window.initMap = function() {};

        document.addEventListener('DOMContentLoaded', function () {
            // QR Code Download
            const downloadQrButton = document.getElementById('download-qr');
            if(downloadQrButton) {
                downloadQrButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    const svgElement = document.querySelector('#qr-code-container svg');
                    if (svgElement) {
                        const svgData = new XMLSerializer().serializeToString(svgElement);
                        const blob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
                        const url = URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = 'qr-hive-{{ $hive->slug }}.svg';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        URL.revokeObjectURL(url);
                    }
                });
            }

            // Super search filter
            const superSearchInput = document.getElementById('super-search');
            const superSelect = document.getElementById('hive-super-select');
            const superOptions = Array.from(superSelect.options);

            if (superSearchInput) {
                superSearchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();

                    superSelect.innerHTML = '';

                    superOptions.forEach(option => {
                        if (option.value === '' || option.text.toLowerCase().includes(searchTerm)) {
                            superSelect.add(option);
                        }
                    });
                });
            }

            // Edit form toggle
            const toggleButton = document.getElementById('toggle-edit-form');
            const editForm = document.getElementById('edit-hive-form');
            const toggleStatesButton = document.getElementById('toggle-states-form');
            const statesForm = document.getElementById('states-hive-form');

            toggleButton.addEventListener('click', function () {
                const isHidden = editForm.classList.contains('hidden');
                editForm.classList.toggle('hidden');
            });

            toggleStatesButton.addEventListener('click', function () {
                const isHidden = statesForm.classList.contains('hidden');
                statesForm.classList.toggle('hidden');
            });

            // Auto-open form if there are validation errors
            @if ($errors->any())
                editForm.classList.remove('hidden');
                toggleButton.textContent = '{{ __('Ocultar Formulario') }}';
            @endif

            // Tab switching logic
            const tabs = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const target = document.getElementById(tab.dataset.tab + '-content');

                    tabContents.forEach(c => c.classList.add('hidden'));
                    target.classList.remove('hidden');

                    tabs.forEach(t => {
                        t.classList.remove('border-primary', 'text-primary');
                        t.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                    });
                    tab.classList.add('border-primary', 'text-primary');
                    tab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                });
            });

            // Google Maps Modal
            const locationGpsInput = document.getElementById('location_gps');
            const openMapModalButton = document.getElementById('open-map-modal');
            const mapModal = document.getElementById('google-maps-modal');
            const closeMapModalButton = document.getElementById('close-map-modal');
            const confirmLocationButton = document.getElementById('confirm-location-button');
            const pacInput = document.getElementById('pac-input');
            const mapElement = document.getElementById('map');

            let map, marker, searchBox;
            let selectedPosition = null;

            function parseLatLng(str) {
                if (!str) return null;
                const parts = str.split(',');
                if (parts.length !== 2) return null;
                const lat = parseFloat(parts[0].trim());
                const lng = parseFloat(parts[1].trim());
                if (isNaN(lat) || isNaN(lng)) return null;
                return { lat, lng };
            }

            function openMapForInput(inputElement) {
                activeLocationInput = inputElement;
                mapModal.classList.remove('hidden');
                const initialPos = parseLatLng(inputElement.value) || { lat: 19.4326, lng: -99.1332 }; // Default to Mexico City
                selectedPosition = initialPos;

                if (!map) {
                    map = new google.maps.Map(mapElement, {
                        center: initialPos,
                        zoom: inputElement.value ? 15 : 8,
                    });

                    marker = new google.maps.Marker({
                        position: initialPos,
                        map: map,
                        draggable: true,
                    });

                    searchBox = new google.maps.places.SearchBox(pacInput);
                    map.controls[google.maps.ControlPosition.TOP_LEFT].push(pacInput);

                    map.addListener('bounds_changed', () => searchBox.setBounds(map.getBounds()));

                    searchBox.addListener('places_changed', () => {
                        const places = searchBox.getPlaces();
                        if (places.length > 0 && places[0].geometry) {
                            const place = places[0];
                            map.setCenter(place.geometry.location);
                            map.setZoom(15);
                            marker.setPosition(place.geometry.location);
                            selectedPosition = place.geometry.location.toJSON();
                        }
                    });

                    map.addListener('click', (e) => {
                        marker.setPosition(e.latLng);
                        selectedPosition = e.latLng.toJSON();
                    });

                    marker.addListener('dragend', (e) => {
                        selectedPosition = e.latLng.toJSON();
                    });
                } else {
                    map.setCenter(initialPos);
                    marker.setPosition(initialPos);
                    map.setZoom(inputElement.value ? 15 : 8);
                }
            }

            openMapModalButton.addEventListener('click', () => openMapForInput(locationGpsInput));
            closeMapModalButton.addEventListener('click', () => mapModal.classList.add('hidden'));

            confirmLocationButton.addEventListener('click', () => {
                if (selectedPosition && activeLocationInput) {
                    activeLocationInput.value = `${selectedPosition.lat}, ${selectedPosition.lng}`;
                }
                mapModal.classList.add('hidden');
            });

            // Notes CRUD
            const notesList = document.getElementById('notes-list');
            const noNotesMessage = document.getElementById('no-notes-message');

            // Queen section forms toggle
            const addQueenForm = document.getElementById('add-queen-form');
            const toggleAddQueenButton = document.getElementById('toggle-add-queen-form');
            const cancelAddQueenButton = document.getElementById('cancel-add-queen');

            const editQueenForm = document.getElementById('edit-queen-form');
            const toggleEditQueenButton = document.getElementById('toggle-edit-queen-form');
            const cancelEditQueenButton = document.getElementById('cancel-edit-queen');
            const queenDetails = document.getElementById('queen-details');

            const replaceQueenForm = document.getElementById('replace-queen-form');
            const toggleReplaceQueenButton = document.getElementById('toggle-replace-queen-form');
            const cancelReplaceQueenButton = document.getElementById('cancel-replace-queen');

            if (toggleAddQueenButton) {
                toggleAddQueenButton.addEventListener('click', () => {
                    addQueenForm.classList.remove('hidden');
                    toggleAddQueenButton.classList.add('hidden');
                });
            }

            if (cancelAddQueenButton) {
                cancelAddQueenButton.addEventListener('click', () => {
                    addQueenForm.classList.add('hidden');
                    if (toggleAddQueenButton) toggleAddQueenButton.classList.remove('hidden');
                });
            }

            if (toggleEditQueenButton) {
                toggleEditQueenButton.addEventListener('click', () => {
                    editQueenForm.classList.remove('hidden');
                    queenDetails.classList.add('hidden');
                    toggleEditQueenButton.classList.add('hidden');
                    toggleReplaceQueenButton.classList.add('hidden');
                });
            }

            if (cancelEditQueenButton) {
                cancelEditQueenButton.addEventListener('click', () => {
                    editQueenForm.classList.add('hidden');
                    queenDetails.classList.remove('hidden');
                    toggleEditQueenButton.classList.remove('hidden');
                    toggleReplaceQueenButton.classList.remove('hidden');
                });
            }

            if (toggleReplaceQueenButton) {
                toggleReplaceQueenButton.addEventListener('click', () => {
                    replaceQueenForm.classList.remove('hidden');
                    toggleEditQueenButton.classList.add('hidden');
                    toggleReplaceQueenButton.classList.add('hidden');
                });
            }

            if (cancelReplaceQueenButton) {
                cancelReplaceQueenButton.addEventListener('click', () => {
                    replaceQueenForm.classList.add('hidden');
                    toggleEditQueenButton.classList.remove('hidden');
                    toggleReplaceQueenButton.classList.remove('hidden');
                });
            }

            const addNoteForm = document.getElementById('add-note-form');
            if (addNoteForm) {
                const dueDateContainer = document.getElementById('due-date-container');
                const noteTypeRadios = addNoteForm.querySelectorAll('input[name="type"]');
                const saveNoteButton = document.getElementById('save-note-button');

                noteTypeRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        if (this.value === 'task') {
                            dueDateContainer.classList.remove('hidden');
                            saveNoteButton.textContent = 'Guardar Tarea';
                        } else {
                            dueDateContainer.classList.add('hidden');
                            saveNoteButton.textContent = 'Guardar Nota';
                        }
                    });
                });

                addNoteForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const content = document.getElementById('note-content').value;
                    const type = addNoteForm.querySelector('input[name="type"]:checked').value;
                    const dueDate = document.getElementById('due-date').value;

                    const payload = {
                        content: content,
                        type: type,
                    };

                    if (type === 'task') {
                        payload.due_date = dueDate;
                    }

                    fetch('{{ route('hives.notes.store', $hive) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.id) {
                            // This part will be updated to use the new partial
                            // For now, let's just reload the page to see the changes
                            location.reload();
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
            }

            if (notesList) {
                notesList.addEventListener('click', function(e) {
                const noteId = e.target.dataset.noteId;
                if (!noteId) return;

                const noteElement = document.getElementById(`note-${noteId}`);

                if (e.target.classList.contains('edit-note-button')) {
                    document.getElementById(`edit-note-form-${noteId}`).classList.remove('hidden');
                }

                if (e.target.classList.contains('cancel-edit-button')) {
                    document.getElementById(`edit-note-form-${noteId}`).classList.add('hidden');
                }

                if (e.target.classList.contains('delete-note-button')) {
                    if (confirm('¿Estás seguro de que quieres eliminar esta nota?')) {
                        const url = '{{ route("hives.notes.destroy", ["hive" => $hive, "note" => ":noteId"]) }}'.replace(':noteId', noteId);
                        fetch(url, {
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                noteElement.remove();
                                if (notesList.children.length === 0 && noNotesMessage) {
                                    noNotesMessage.classList.remove('hidden');
                                }
                            }
                        });
                    }
                }

                if (e.target.classList.contains('task-checkbox')) {
                    const isChecked = e.target.checked;
                    const url = '{{ route("hives.notes.update", ["hive" => $hive, "note" => ":noteId"]) }}'.replace(':noteId', noteId);
                    fetch(url, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ completed: isChecked, content: noteElement.querySelector('.note-content').textContent, type: 'task' })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.id) {
                            // Just reload for now to see the style changes
                            location.reload();
                        }
                    });
                }

                if (e.target.classList.contains('confirm-edit-button')) {
                    const newContent = document.querySelector(`#edit-note-form-${noteId} textarea`).value;
                    const url = '{{ route("hives.notes.update", ["hive" => $hive, "note" => ":noteId"]) }}'.replace(':noteId', noteId);

                    const payload = {
                        content: newContent,
                        type: noteElement.querySelector('.task-checkbox') ? 'task' : 'note',
                    };

                    if (payload.type === 'task') {
                        payload.due_date = document.getElementById(`edit-due-date-${noteId}`).value;
                    }

                    fetch(url, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.id) {
                            // Just reload for now
                            location.reload();
                        }
                    });
                }
            });
        }

        // Harvest form logic
        const quantityKgInput = document.getElementById('quantity_kg');
        const quantityLitersInput = document.getElementById('quantity_liters');
        const densityInput = document.getElementById('density');

        if (quantityKgInput && quantityLitersInput && densityInput) {
            quantityKgInput.addEventListener('input', () => {
                if (document.activeElement === quantityKgInput) {
                    const kg = parseFloat(quantityKgInput.value);
                    const density = parseFloat(densityInput.value);
                    if (!isNaN(kg) && !isNaN(density) && density > 0) {
                        quantityLitersInput.value = (kg / density).toFixed(2);
                    }
                }
            });

            quantityLitersInput.addEventListener('input', () => {
                if (document.activeElement === quantityLitersInput) {
                    const liters = parseFloat(quantityLitersInput.value);
                    const density = parseFloat(densityInput.value);
                    if (!isNaN(liters) && !isNaN(density)) {
                        quantityKgInput.value = (liters * density).toFixed(2);
                    }
                }
            });
        }

        const colorSlider = document.getElementById('color_tone');
        if(colorSlider){
            const colorDisplay = document.createElement('div');
            colorDisplay.className = 'w-full h-4 mt-2 rounded-full';
            const updateColor = () => {
                const value = colorSlider.value; // 0-100
                const lightColor = [255, 235, 59]; // Yellow
                const darkColor = [183, 28, 28]; // Dark Red
                const r = Math.round(lightColor[0] + (darkColor[0] - lightColor[0]) * (value / 100));
                const g = Math.round(lightColor[1] + (darkColor[1] - lightColor[1]) * (value / 100));
                const b = Math.round(lightColor[2] + (darkColor[2] - lightColor[2]) * (value / 100));
                colorDisplay.style.backgroundColor = `rgb(${r}, ${g}, ${b})`;
            };
            updateColor();
            colorSlider.parentNode.insertBefore(colorDisplay, colorSlider.nextSibling.nextSibling);
            colorSlider.addEventListener('input', updateColor);
        }
        });
    </script>
    @endpush
</x-app-layout>
