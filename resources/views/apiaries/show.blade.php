<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('apiaries.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            Apiarios
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $apiary->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex items-center space-x-2">
                 <button type="button" class="open-create-hive-modal-button inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-400 active:bg-yellow-600 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Añadir Colmena') }}
                </button>
                <button id="toggle-edit-form" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Editar') }}
                </button>
                <button id="open-delete-apiary-modal-button" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('Borrar') }}
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:justify-between">
                        <!-- Left Side: Image, Name, Location -->
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="mr-6 flex-shrink-0">
                                <svg class="h-24 w-24 text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex-grow">
                                <div class="flex items-center gap-4">
                                    <h2 class="text-3xl font-bold text-gray-900">{{ $apiary->name }}</h2>
                                    <span class="px-3 py-1 text-sm font-semibold text-white rounded-full {{ $apiaryStatusColors[$apiary->status] ?? 'bg-gray-400' }}">
                                        {{ $apiary->status }}
                                    </span>
                                </div>
                                <p class="text-gray-600 flex items-center mt-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $apiary->location }}
                                </p>
                                @if($apiary->location_gps)
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $apiary->location_gps }}" target="_blank" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 mt-1">
                                        {{ $apiary->location_gps }}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                          <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <!-- Right Side: Stats -->
                        <div class="flex items-center space-x-4">
                            <div class="p-4 bg-yellow-50 rounded-lg text-center shadow">
                                <p class="text-sm font-bold text-yellow-800">{{ __('Colmenas') }}</p>
                                <p class="text-3xl font-extrabold text-yellow-900">{{ $hives->total() }}</p>
                            </div>
                            <div class="p-4 bg-green-50 rounded-lg text-center shadow">
                                <p class="text-sm font-bold text-green-800">{{ __('Rating Promedio') }}</p>
                                @if($averageRating)
                                    <p class="text-3xl font-extrabold text-green-900 flex items-center justify-center">
                                        {{ number_format($averageRating, 1) }}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-1 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </p>
                                @else
                                    <p class="text-2xl font-bold text-green-800">N/A</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-gray-600 mt-6 border-t pt-6">
                        <div>
                            <p class="text-gray-500 font-semibold">{{ __('Creado el') }}</p>
                            <p class="font-medium">{{ $apiary->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 font-semibold">{{ __('Actualizado el') }}</p>
                            <p class="font-medium">{{ $apiary->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <div id="edit-apiary-form" class="hidden bg-white rounded-lg shadow-md overflow-hidden p-6 mb-8">
                    <form method="POST" action="{{ route('apiaries.update', $apiary) }}">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Nombre del Apiario')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $apiary->name)" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Estado')" />
                                <select name="status" id="status" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                                    @foreach ($apiaryStatuses as $status)
                                        <option value="{{ $status }}" @if(old('status', $apiary->status) == $status) selected @endif>{{ $status }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Location -->
                            <div>
                                <x-input-label for="location" :value="__('Ubicación')" />
                                <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location', $apiary->location)" required autocomplete="location" />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>

                            <!-- Location GPS -->
                            <div>
                                <x-input-label for="location_gps" :value="__('Coordenadas GPS')" />
                                <div class="flex items-center gap-2">
                                    <x-text-input id="location_gps" class="block mt-1 w-full" type="text" name="location_gps" :value="old('location_gps', $apiary->location_gps)" autocomplete="off" />
                                    <button type="button" id="open-map-modal" class="whitespace-nowrap inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="hidden md:inline">{{ $apiary->location_gps ? __('Ver/Editar') : __('Seleccionar') }}</span>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('location_gps')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Actualizar Apiario') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                <!-- Tab Navigation -->
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-yellow-500 text-yellow-600" data-tab="hives">
                            Colmenas
                        </button>
                        <button class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="notes">
                            Notas
                        </button>
                        <button class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="activity">
                            Actividad
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div id="hives-content" class="tab-content mt-6">
                    <!-- Search and per-page form -->
                    <div class="mb-4">
                    <form action="{{ route('apiaries.show', $apiary) }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-grow">
                            <input type="text" name="search" class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-200" placeholder="Buscar colmenas..." value="{{ request('search') }}">
                        </div>
                        <div class="flex items-center gap-2">
                            <select name="per_page" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-200">
                                <option value="10" @if($perPage == 10) selected @endif>10 por página</option>
                                <option value="25" @if($perPage == 25) selected @endif>25 por página</option>
                                <option value="50" @if($perPage == 50) selected @endif>50 por página</option>
                                <option value="100" @if($perPage == 100) selected @endif>100 por página</option>
                                <option value="250" @if($perPage == 250) selected @endif>250 por página</option>
                            </select>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-800 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Buscar
                            </button>
                        </div>
                    </form>
                </div>


                <div id="bulk-actions" class="hidden mb-4 flex space-x-2">
                    <button id="edit-button" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">{{ __('Editar') }}</button>
                    <button id="move-button" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">{{ __('Mover') }}</button>
                    <button id="delete-button" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">{{ __('Borrar') }}</button>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-yellow-500 text-white">
                                <tr>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">
                                        <input type="checkbox" id="select-all" class="rounded border-gray-300 text-yellow-600 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">
                                        <a class="hover:text-yellow-200" href="{{ route('apiaries.show', array_merge(request()->query(), ['apiary' => $apiary, 'sort' => 'status', 'direction' => $sort === 'status' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                            {{ __('Estado') }}
                                            @if ($sort === 'status')
                                                <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">
                                        <a class="hover:text-yellow-200" href="{{ route('apiaries.show', array_merge(request()->query(), ['apiary' => $apiary, 'sort' => 'name', 'direction' => $sort === 'name' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                            {{ __('Nombre') }}
                                            @if ($sort === 'name')
                                                <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">
                                        <a class="hover:text-yellow-200" href="{{ route('apiaries.show', array_merge(request()->query(), ['apiary' => $apiary, 'sort' => 'updated_at', 'direction' => $sort === 'updated_at' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                            {{ __('Ultima Modificacion') }}
                                            @if ($sort === 'updated_at')
                                                <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">
                                        <a class="hover:text-yellow-200" href="{{ route('apiaries.show', array_merge(request()->query(), ['apiary' => $apiary, 'sort' => 'birth_date', 'direction' => $sort === 'birth_date' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                            {{ __('Fecha de nacimiento') }}
                                            @if ($sort === 'birth_date')
                                                <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">
                                        <a class="hover:text-yellow-200" href="{{ route('apiaries.show', array_merge(request()->query(), ['apiary' => $apiary, 'sort' => 'rating', 'direction' => $sort === 'rating' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                            {{ __('Rating') }}
                                            @if ($sort === 'rating')
                                                <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">
                                        <a class="hover:text-yellow-200" href="{{ route('apiaries.show', array_merge(request()->query(), ['apiary' => $apiary, 'sort' => 'type', 'direction' => $sort === 'type' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                            {{ __('Tipo') }}
                                            @if ($sort === 'type')
                                                <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">
                                        <a class="hover:text-yellow-200" href="{{ route('apiaries.show', array_merge(request()->query(), ['apiary' => $apiary, 'sort' => 'location', 'direction' => $sort === 'location' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                            {{ __('Ubicación') }}
                                            @if ($sort === 'location')
                                                <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @forelse ($hives as $hive)
                                    <tr class="border-b hover:bg-yellow-50">
                                        <td class="py-3 px-4">
                                            <input type="checkbox" class="hive-checkbox rounded border-gray-300 text-yellow-600 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" value="{{ $hive->id }}">
                                        </td>
                                        <td class="py-3 px-4">
                                            <span class="px-2 py-1 text-xs font-semibold text-white rounded-full {{
                                                match($hive->status) {
                                                    'Activa' => 'bg-green-500',
                                                    'Invernando' => 'bg-blue-500',
                                                    'Enjambrazon' => 'bg-yellow-500',
                                                    'Despoblada' => 'bg-red-500',
                                                    'Huerfana' => 'bg-purple-500',
                                                    'Zanganera' => 'bg-orange-500',
                                                    'En formacion' => 'bg-teal-500',
                                                    'Revision' => 'bg-cyan-500',
                                                    'Mantenimiento' => 'bg-sky-500',
                                                    'Alimentacion Artificial' => 'bg-indigo-500',
                                                    'Crianza de reinas' => 'bg-pink-500',
                                                    'Pillaje' => 'bg-rose-500',
                                                    'Pillera' => 'bg-fuchsia-500',
                                                    'Union' => 'bg-violet-500',
                                                    'Sin uso' => 'bg-gray-400',
                                                    default => 'bg-gray-500',
                                                }
                                            }}">{{ $hive->status }}</span>
                                        </td>
                                        <td class="py-3 px-4">
                                            <a href="{{ route('hives.show', $hive) }}" class="text-sm text-green-600 hover:text-green-900 font-semibold">{{ $hive->name }}</a>
                                        </td>
                                        <td class="py-3 px-4">{{ $hive->updated_at->format('d/m/Y H:i') }}</td>
                                        <td class="py-3 px-4">{{ $hive->birth_date ? $hive->birth_date->format('d/m/Y') : 'N/A' }}</td>
                                        <td class="py-3 px-4">{{ $hive->rating ?? 'N/A' }}</td>
                                        <td class="py-3 px-4">{{ $hive->type }}</td>
                                        <td class="py-3 px-4">
                                            {{ $hive->location }}
                                            @if($hive->location_gps)
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ $hive->location_gps }}" target="_blank" class="text-blue-500 hover:text-blue-700 ml-1">
                                                (Ver mapa)
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-12">
                                            <p class="text-gray-500 text-lg">{{ __('No hay colmenas que coincidan con la búsqueda.') }}</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 bg-white">
                        {{ $hives->links() }}
                    </div>
                </div>
                </div>
                <!-- Notes Tab -->
                <div id="notes-content" class="tab-content hidden py-6">
                    <div class="bg-white rounded-lg shadow-md">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Añadir una Nota</h3>
                            <form id="add-note-form">
                                <textarea id="note-content" name="content" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-200" placeholder="Escribe tu nota aquí..."></textarea>
                                <div class="flex justify-end mt-4">
                                    <x-primary-button type="submit">
                                        {{ __('Guardar Nota') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Historial de Notas</h3>
                        <div id="notes-list" class="space-y-6">
                            @forelse ($apiary->notes as $note)
                                @include('apiaries.partials.note', ['note' => $note])
                            @empty
                                <div id="no-notes-message" class="text-center py-12">
                                    <p class="text-gray-500 text-lg">{{ __('No hay notas para este apiario.') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Activity Tab -->
                <div id="activity-content" class="tab-content hidden py-6">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Historial de Actividad</h3>
                        </div>
                        <ul class="divide-y divide-gray-200">
                            @forelse ($apiary->activities as $activity)
                                <li class="p-4 sm:p-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-gray-200 rounded-full p-2">
                                             <svg class="h-6 w-6 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4 flex-grow">
                                            <p class="text-sm text-gray-800">{{ $activity->description }}</p>
                                            <p class="text-xs text-gray-500">
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
                                    <p class="text-gray-500">{{ __('No hay actividad registrada para este apiario.') }}</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-create-hive-modal :apiaries="$allUserApiaries" :statuses="$statuses" :types="$types" />

    <!-- Bulk Edit Modal -->
    <div id="edit-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 text-center">{{ __('Editar Colmenas en Lote') }}</h3>
                <div class="mt-4 px-7 py-3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Status -->
                        <div>
                            <label for="bulk-status" class="block font-medium text-sm text-gray-700">{{ __('Estado') }}</label>
                            <select id="bulk-status" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-200">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Type -->
                        <div>
                            <label for="bulk-type" class="block font-medium text-sm text-gray-700">{{ __('Tipo') }}</label>
                            <select id="bulk-type" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-200">
                                @foreach ($types as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="mt-6">
                        <label for="bulk-location" class="block font-medium text-sm text-gray-700">{{ __('Nombre de la Ubicación (Opcional)') }}</label>
                        <input id="bulk-location" type="text" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-200" autocomplete="off">
                    </div>

                    <!-- Location GPS -->
                    <div class="mt-4">
                        <label for="bulk-location-gps" class="block font-medium text-sm text-gray-700">{{ __('Coordenadas GPS (Opcional)') }}</label>
                        <div class="flex items-center gap-2 mt-1">
                            <input id="bulk-location-gps" type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-200" autocomplete="off">
                            <button type="button" id="open-bulk-map-modal" class="whitespace-nowrap inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <span class="hidden md:inline">{{ __('Seleccionar en Mapa') }}</span>
                            </button>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Dejar los campos de ubicación en blanco para no modificarlos.</p>
                    </div>
                </div>
                <div class="items-center px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button id="confirm-edit-button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Confirmar Cambios') }}
                    </button>
                    <button id="cancel-edit-button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        {{ __('Cancelar') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Move Modal -->
    <div id="move-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('Mover Colmenas') }}</h3>
                <div class="mt-2 px-7 py-3">
                    <select id="move-apiary-select" class="w-full rounded-md border-gray-300 shadow-sm">
                        @foreach ($allApiariesForMoving as $apiaryOption)
                            <option value="{{ $apiaryOption->id }}">{{ $apiaryOption->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirm-move-button" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-auto shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        {{ __('Confirmar') }}
                    </button>
                    <button id="cancel-move-button" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-auto shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        {{ __('Cancelar') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="delete-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('Borrar Colmenas') }}</h3>
                <div class="mt-2 px-7 py-3">
                    <p>{{ __('¿Estás seguro de que quieres borrar las colmenas seleccionadas?') }}</p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirm-delete-button" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-auto shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        {{ __('Confirmar') }}
                    </button>
                    <button id="cancel-delete-button" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-auto shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        {{ __('Cancelar') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
window.initMap = function() {};

document.addEventListener('DOMContentLoaded', function () {
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

    function openModal() {
        mapModal.classList.remove('hidden');
        const initialPos = parseLatLng(locationGpsInput.value) || { lat: 19.4326, lng: -99.1332 }; // Default to Mexico City
        selectedPosition = initialPos;

        map = new google.maps.Map(mapElement, {
            center: initialPos,
            zoom: locationGpsInput.value ? 15 : 8,
        });

        marker = new google.maps.Marker({
            position: initialPos,
            map: map,
            draggable: true,
        });

        searchBox = new google.maps.places.SearchBox(pacInput);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(pacInput);

        map.addListener('bounds_changed', () => {
            searchBox.setBounds(map.getBounds());
        });

        searchBox.addListener('places_changed', () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            const place = places[0];
            if (!place.geometry || !place.geometry.location) {
                return;
            }

            map.setCenter(place.geometry.location);
            map.setZoom(15);
            marker.setPosition(place.geometry.location);
            selectedPosition = place.geometry.location.toJSON();
        });

        map.addListener('click', (e) => {
            marker.setPosition(e.latLng);
            selectedPosition = e.latLng.toJSON();
        });

        marker.addListener('dragend', (e) => {
            selectedPosition = e.latLng.toJSON();
        });
    }

    function closeModal() {
        mapModal.classList.add('hidden');
    }

    let activeLocationInput = null;

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
    closeMapModalButton.addEventListener('click', closeModal);

    confirmLocationButton.addEventListener('click', () => {
        if (selectedPosition && activeLocationInput) {
            activeLocationInput.value = `${selectedPosition.lat}, ${selectedPosition.lng}`;
        }
        closeModal();
    });

    const toggleButton = document.getElementById('toggle-edit-form');
            const editForm = document.getElementById('edit-apiary-form');

            toggleButton.addEventListener('click', function () {
                const isHidden = editForm.classList.contains('hidden');
                editForm.classList.toggle('hidden');
                toggleButton.textContent = isHidden ? '{{ __('Ocultar') }}' : '{{ __('Editar') }}';
            });

            // Auto-open form if there are validation errors
            @if ($errors->any())
                editForm.classList.remove('hidden');
                toggleButton.textContent = '{{ __('Ocultar Formulario') }}';
            @endif

            const selectAllCheckbox = document.getElementById('select-all');
            const hiveCheckboxes = document.querySelectorAll('.hive-checkbox');
            const bulkActionsDiv = document.getElementById('bulk-actions');
            const moveButton = document.getElementById('move-button');
            const deleteButton = document.getElementById('delete-button');
            const moveModal = document.getElementById('move-modal');
            const deleteModal = document.getElementById('delete-modal');
            const confirmMoveButton = document.getElementById('confirm-move-button');
            const cancelMoveButton = document.getElementById('cancel-move-button');
            const confirmDeleteButton = document.getElementById('confirm-delete-button');
            const cancelDeleteButton = document.getElementById('cancel-delete-button');
            const moveApiarySelect = document.getElementById('move-apiary-select');

            function getSelectedHiveIds() {
                const selectedIds = [];
                hiveCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedIds.push(checkbox.value);
                    }
                });
                return selectedIds;
            }

            function updateBulkActionsVisibility() {
                const selectedIds = getSelectedHiveIds();
                if (selectedIds.length > 0) {
                    bulkActionsDiv.classList.remove('hidden');
                } else {
                    bulkActionsDiv.classList.add('hidden');
                }
            }

            selectAllCheckbox.addEventListener('change', function () {
                hiveCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateBulkActionsVisibility();
            });

            hiveCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkActionsVisibility);
            });

            moveButton.addEventListener('click', function () {
                moveModal.classList.remove('hidden');
            });

            deleteButton.addEventListener('click', function () {
                deleteModal.classList.remove('hidden');
            });

            cancelMoveButton.addEventListener('click', function () {
                moveModal.classList.add('hidden');
            });

            cancelDeleteButton.addEventListener('click', function () {
                deleteModal.classList.add('hidden');
            });

            confirmMoveButton.addEventListener('click', function () {
                const hiveIds = getSelectedHiveIds();
                const apiaryId = moveApiarySelect.value;
                performBulkAction('move', hiveIds, { apiary_id: apiaryId });
            });

            confirmDeleteButton.addEventListener('click', function () {
                const hiveIds = getSelectedHiveIds();
                performBulkAction('delete', hiveIds);
            });

            function performBulkAction(action, hiveIds, data = {}) {
                const payload = {
                    action: action,
                    hive_ids: hiveIds,
                    _token: '{{ csrf_token() }}',
                    ...data
                };

                fetch('{{ route("hives.bulkActions") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(payload)
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        // This part might not be reached if server throws validation error
                        alert(data.message || 'An error occurred.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    let errorMessage = 'An error occurred.';
                    if (error.errors) {
                        errorMessage = Object.values(error.errors).flat().join('\n');
                    } else if (error.message) {
                        errorMessage = error.message;
                    }
                    alert(errorMessage);
                });
            }

            // Bulk Edit Modal Logic
            const editButton = document.getElementById('edit-button');
            const editModal = document.getElementById('edit-modal');
            const cancelEditButton = document.getElementById('cancel-edit-button');
            const confirmEditButton = document.getElementById('confirm-edit-button');
            const openBulkMapModalButton = document.getElementById('open-bulk-map-modal');
            const bulkLocationGpsInput = document.getElementById('bulk-location-gps');

            editButton.addEventListener('click', () => editModal.classList.remove('hidden'));
            cancelEditButton.addEventListener('click', () => editModal.classList.add('hidden'));
            openBulkMapModalButton.addEventListener('click', () => openMapForInput(bulkLocationGpsInput));

            confirmEditButton.addEventListener('click', () => {
                const hiveIds = getSelectedHiveIds();
                const status = document.getElementById('bulk-status').value;
                const type = document.getElementById('bulk-type').value;
                const location = document.getElementById('bulk-location').value;
                const location_gps = bulkLocationGpsInput.value;

                const data = {
                    status,
                    type,
                    location,
                    location_gps
                };

                performBulkAction('edit', hiveIds, data);
            });

        });
    </script>

    <x-google-maps-modal />

    <!-- Delete Apiary Modal -->
<div id="delete-apiary-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">{{ __('Borrar Apiario') }}</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    {{ __('¿Estás seguro de que quieres borrar este apiario?') }}
                </p>
                @if($apiary->hives()->count() > 0)
                    <div class="mt-4 text-left">
                        <p class="text-sm font-semibold text-gray-700">{{ __('Este apiario contiene') }} {{ $apiary->hives()->count() }} {{ __('colmena(s).') }}</p>
                        <p class="text-sm text-gray-600 mt-2">{{ __('¿Qué te gustaría hacer con estas colmenas?') }}</p>
                        <div class="mt-3 space-y-2">
                            <label for="delete_hives" class="flex items-center">
                                <input type="radio" id="delete_hives" name="hives_action" value="delete" class="text-red-600 focus:ring-red-500" checked>
                                <span class="ml-2 text-sm text-gray-700">{{ __('Borrar todas las colmenas de este apiario') }}</span>
                            </label>
                            @if($allApiariesForMoving->count() > 0)
                            <label for="move_hives" class="flex items-center">
                                <input type="radio" id="move_hives" name="hives_action" value="move" class="text-yellow-600 focus:ring-yellow-500">
                                <span class="ml-2 text-sm text-gray-700">{{ __('Mover las colmenas a otro apiario') }}</span>
                            </label>
                            <div id="move_hives_to_apiary_selector" class="hidden ml-6 mt-2">
                                <select id="move_to_apiary_id" name="move_to_apiary_id" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-200">
                                    @foreach($allApiariesForMoving as $targetApiary)
                                        <option value="{{ $targetApiary->id }}">{{ $targetApiary->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @else
                            <label for="move_hives_disabled" class="flex items-center cursor-not-allowed">
                                <input type="radio" id="move_hives_disabled" name="hives_action" value="move" disabled class="text-gray-400">
                                <span class="ml-2 text-sm text-gray-500">{{ __('Mover las colmenas a otro apiario (No hay otros apiarios disponibles)') }}</span>
                            </label>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
            <div class="items-center px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form id="delete-apiary-form" method="POST" action="{{ route('apiaries.destroy', $apiary) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="hives_action" id="hives_action_input">
                    <input type="hidden" name="move_to_apiary_id" id="move_to_apiary_id_input">
                    <button type="submit" id="confirm-delete-apiary-button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Confirmar Borrado') }}
                    </button>
                </form>
                <button id="cancel-delete-apiary-button" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                    {{ __('Cancelar') }}
                </button>
            </div>
        </div>
    </div>
</div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Delete Apiary Modal Logic
            const openDeleteModalButton = document.getElementById('open-delete-apiary-modal-button');
            const deleteApiaryModal = document.getElementById('delete-apiary-modal');
            const cancelDeleteApiaryButton = document.getElementById('cancel-delete-apiary-button');
            const deleteApiaryForm = document.getElementById('delete-apiary-form');
            const hivesActionRadios = document.querySelectorAll('input[name="hives_action"]');
            const moveHivesSelector = document.getElementById('move_hives_to_apiary_selector');
            const hivesActionInput = document.getElementById('hives_action_input');
            const moveToApiaryIdInput = document.getElementById('move_to_apiary_id_input');
            const moveToApiarySelect = document.getElementById('move_to_apiary_id');

            if (openDeleteModalButton) {
                openDeleteModalButton.addEventListener('click', () => {
                    deleteApiaryModal.classList.remove('hidden');
                });
            }

            if (cancelDeleteApiaryButton) {
                cancelDeleteApiaryButton.addEventListener('click', () => {
                    deleteApiaryModal.classList.add('hidden');
                });
            }

            hivesActionRadios.forEach(radio => {
                radio.addEventListener('change', (e) => {
                    if (e.target.value === 'move') {
                        moveHivesSelector.classList.remove('hidden');
                    } else {
                        moveHivesSelector.classList.add('hidden');
                    }
                });
            });

            if (deleteApiaryForm) {
                deleteApiaryForm.addEventListener('submit', (e) => {
                    const selectedAction = document.querySelector('input[name="hives_action"]:checked');
                    if (selectedAction) {
                        hivesActionInput.value = selectedAction.value;
                        if (selectedAction.value === 'move') {
                            moveToApiaryIdInput.value = moveToApiarySelect.value;
                        }
                    } else {
                         // If there are no hives, this won't be set, which is fine.
                        hivesActionInput.value = 'delete'; // Default action
                    }
                });
            }

            // Tab switching logic
            const tabs = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const target = document.getElementById(tab.dataset.tab + '-content');

                    tabContents.forEach(c => c.classList.add('hidden'));
                    target.classList.remove('hidden');

                    tabs.forEach(t => {
                        t.classList.remove('border-yellow-500', 'text-yellow-600');
                        t.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                    });
                    tab.classList.add('border-yellow-500', 'text-yellow-600');
                    tab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                });
            });

            const notesList = document.getElementById('notes-list');
            const noNotesMessage = document.getElementById('no-notes-message');

            // Handle Add Note form submission
            document.getElementById('add-note-form').addEventListener('submit', function (e) {
                e.preventDefault();
                const content = document.getElementById('note-content').value;

                fetch('{{ route('apiaries.notes.store', $apiary) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ content: content })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.id) {
                        const newNoteHtml = `
                            <div class="flex items-start space-x-4" id="note-${data.id}">
                                <img class="w-10 h-10 rounded-full" src="${data.user.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(data.user.name) + '&color=7F9CF5&background=EBF4FF'}" alt="${data.user.name}">
                                <div class="flex-1">
                                    <div class="bg-gray-100 rounded-lg p-4">
                                        <div class="flex items-center justify-between">
                                            <p class="font-semibold text-gray-900">${data.user.name}</p>
                                            <div class="text-xs text-gray-500">just now</div>
                                        </div>
                                        <p class="text-gray-700 mt-2 note-content">${data.content}</p>
                                    </div>
                                    <div class="flex items-center space-x-4 mt-1 text-xs">
                                        <button class="font-medium text-blue-600 hover:text-blue-800 edit-note-button" data-note-id="${data.id}">Editar</button>
                                        <button class="font-medium text-red-600 hover:text-red-800 delete-note-button" data-note-id="${data.id}">Eliminar</button>
                                    </div>
                                    <div id="edit-note-form-${data.id}" class="hidden mt-2">
                                        <textarea class="w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-200" rows="3">${data.content}</textarea>
                                        <div class="flex justify-end space-x-2 mt-2">
                                            <button class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 cancel-edit-button" data-note-id="${data.id}">Cancelar</button>
                                            <button class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 confirm-edit-button" data-note-id="${data.id}">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        notesList.insertAdjacentHTML('afterbegin', newNoteHtml);
                        document.getElementById('note-content').value = '';
                        if(noNotesMessage) noNotesMessage.classList.add('hidden');
                    }
                })
                .catch(error => console.error('Error:', error));
            });

            // Event delegation for edit, delete, cancel, and confirm buttons
            notesList.addEventListener('click', function(e) {
                const noteId = e.target.dataset.noteId;
                if (!noteId) return;

                const noteElement = document.getElementById(`note-${noteId}`);

                // Edit button
                if (e.target.classList.contains('edit-note-button')) {
                    document.getElementById(`edit-note-form-${noteId}`).classList.remove('hidden');
                }

                // Cancel edit button
                if (e.target.classList.contains('cancel-edit-button')) {
                    document.getElementById(`edit-note-form-${noteId}`).classList.add('hidden');
                }

                // Delete button
                if (e.target.classList.contains('delete-note-button')) {
                    if (confirm('¿Estás seguro de que quieres eliminar esta nota?')) {
                        const url = '{{ route("apiaries.notes.destroy", ["apiary" => $apiary, "note" => ":noteId"]) }}'.replace(':noteId', noteId);
                        fetch(url, {
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                noteElement.remove();
                                if (notesList.children.length === 0) {
                                    if(noNotesMessage) noNotesMessage.classList.remove('hidden');
                                }
                            }
                        });
                    }
                }

                // Confirm edit button
                if (e.target.classList.contains('confirm-edit-button')) {
                    const newContent = document.querySelector(`#edit-note-form-${noteId} textarea`).value;
                    const url = '{{ route("apiaries.notes.update", ["apiary" => $apiary, "note" => ":noteId"]) }}'.replace(':noteId', noteId);
                    fetch(url, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ content: newContent })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.id) {
                            noteElement.querySelector('.note-content').textContent = data.content;
                            document.getElementById(`edit-note-form-${noteId}`).classList.add('hidden');
                        }
                    });
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
