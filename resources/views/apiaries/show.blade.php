<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $apiary->name }}
            </h2>
            <a href="{{ route('apiaries.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Volver a Apiarios') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center mb-4">
                        <img src="https://placehold.co/100x100/FBBF24/333333?text=Apiario" alt="Apiary Image" class="w-24 h-24 rounded-lg mr-6">
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ $apiary->name }}</p>
                            <p class="text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                {{ $apiary->location }}
                            </p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                        <p><strong>{{ __('Creado el') }}:</strong> {{ $apiary->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>{{ __('Actualizado el') }}:</strong> {{ $apiary->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-2xl font-semibold text-gray-800">Editar Apiario</h3>
                    <button id="toggle-edit-form" class="inline-flex items-center px-4 py-2 bg-secondary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 active:bg-opacity-95 focus:outline-none focus:border-secondary focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        {{ __('Mostrar Formulario') }}
                    </button>
                </div>

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
                                <select name="status" id="status" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary-light focus:ring-opacity-50">
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

                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Colmenas en este Apiario</h3>

                <!-- Search and per-page form -->
                <div class="mb-4">
                    <form action="{{ route('apiaries.show', $apiary) }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-grow">
                            <input type="text" name="search" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary-light focus:ring-opacity-50" placeholder="Buscar colmenas..." value="{{ request('search') }}">
                        </div>
                        <div class="flex items-center gap-2">
                            <select name="per_page" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary-light focus:ring-opacity-50">
                                <option value="10" @if($perPage == 10) selected @endif>10 por página</option>
                                <option value="25" @if($perPage == 25) selected @endif>25 por página</option>
                                <option value="50" @if($perPage == 50) selected @endif>50 por página</option>
                                <option value="100" @if($perPage == 100) selected @endif>100 por página</option>
                                <option value="250" @if($perPage == 250) selected @endif>250 por página</option>
                            </select>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-secondary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 active:bg-opacity-95 focus:outline-none focus:border-secondary focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Buscar
                            </button>
                            <button type="button" class="open-create-hive-modal-button inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 active:bg-opacity-95 focus:outline-none focus:border-primary focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Añadir Colmena') }}
                            </button>
                        </div>
                    </form>
                </div>


                <div id="bulk-actions" class="hidden mb-4">
                    <button id="move-button" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">{{ __('Mover') }}</button>
                    <button id="delete-button" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">{{ __('Borrar') }}</button>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-primary text-text-dark">
                                <tr>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">
                                        <input type="checkbox" id="select-all">
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">
                                        <a class="hover:text-primary-dark" href="{{ route('apiaries.show', array_merge(request()->query(), ['apiary' => $apiary, 'sort' => 'status', 'direction' => $sort === 'status' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                            {{ __('Estado') }}
                                            @if ($sort === 'status')
                                                <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">
                                        <a class="hover:text-primary-dark" href="{{ route('apiaries.show', array_merge(request()->query(), ['apiary' => $apiary, 'sort' => 'name', 'direction' => $sort === 'name' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                            {{ __('Nombre') }}
                                            @if ($sort === 'name')
                                                <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">
                                        <a class="hover:text-primary-dark" href="{{ route('apiaries.show', array_merge(request()->query(), ['apiary' => $apiary, 'sort' => 'updated_at', 'direction' => $sort === 'updated_at' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                            {{ __('Ultima Modificacion') }}
                                            @if ($sort === 'updated_at')
                                                <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">
                                        <a class="hover:text-primary-dark" href="{{ route('apiaries.show', array_merge(request()->query(), ['apiary' => $apiary, 'sort' => 'birth_date', 'direction' => $sort === 'birth_date' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                            {{ __('Fecha de nacimiento') }}
                                            @if ($sort === 'birth_date')
                                                <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">
                                        <a class="hover:text-primary-dark" href="{{ route('apiaries.show', array_merge(request()->query(), ['apiary' => $apiary, 'sort' => 'rating', 'direction' => $sort === 'rating' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                            {{ __('Rating') }}
                                            @if ($sort === 'rating')
                                                <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm">
                                        <a class="hover:text-primary-dark" href="{{ route('apiaries.show', array_merge(request()->query(), ['apiary' => $apiary, 'sort' => 'type', 'direction' => $sort === 'type' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                            {{ __('Tipo') }}
                                            @if ($sort === 'type')
                                                <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                            @endif
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @forelse ($hives as $hive)
                                    <tr class="border-b hover:bg-background">
                                        <td class="py-3 px-4">
                                            <input type="checkbox" class="hive-checkbox" value="{{ $hive->id }}">
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
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-12">
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
        </div>
    </div>

    <x-create-hive-modal :apiaries="$allUserApiaries" :statuses="$statuses" :types="$types" />

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
        const initialPos = parseLatLng(locationGpsInput.value) || { lat: -34.397, lng: 150.644 }; // Default to Sydney
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

    openMapModalButton.addEventListener('click', openModal);
    closeMapModalButton.addEventListener('click', closeModal);

    confirmLocationButton.addEventListener('click', () => {
        if (selectedPosition) {
            locationGpsInput.value = `${selectedPosition.lat}, ${selectedPosition.lng}`;
        }
        closeModal();
    });

    const toggleButton = document.getElementById('toggle-edit-form');
            const editForm = document.getElementById('edit-apiary-form');

            toggleButton.addEventListener('click', function () {
                const isHidden = editForm.classList.contains('hidden');
                editForm.classList.toggle('hidden');
                toggleButton.textContent = isHidden ? '{{ __('Ocultar Formulario') }}' : '{{ __('Mostrar Formulario') }}';
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
                performBulkAction('move', hiveIds, apiaryId);
            });

            confirmDeleteButton.addEventListener('click', function () {
                const hiveIds = getSelectedHiveIds();
                performBulkAction('delete', hiveIds);
            });

            function performBulkAction(action, hiveIds, apiaryId = null) {
                const data = {
                    action: action,
                    hive_ids: hiveIds,
                    _token: '{{ csrf_token() }}'
                };

                if (apiaryId) {
                    data.apiary_id = apiaryId;
                }

                fetch('{{ route("hives.bulkActions") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'An error occurred.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred.');
                });
            }
        });
    </script>

    <x-google-maps-modal />
</x-app-layout>
