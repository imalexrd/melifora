<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Colmenas') }}
            </h2>
            <button type="button" class="open-create-hive-modal-button inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 active:bg-opacity-95 focus:outline-none focus:border-primary focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Añadir Colmena') }}
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and per-page form -->
            <div class="mb-4">
                <form action="{{ route('hives.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-grow">
                        <input type="text" name="search" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary-light focus:ring-opacity-50" placeholder="Buscar colmenas por nombre o apiario..." value="{{ request('search') }}">
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
                        <button type="button" id="scan-qr-button" class="inline-flex items-center px-4 py-2 bg-teal-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-600 active:bg-teal-700 focus:outline-none focus:border-teal-700 focus:ring ring-teal-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v4m0 0h-4m4 0l-5-5" />
                            </svg>
                            Escanear
                        </button>
                    </div>
                </form>
            </div>

            <div id="bulk-actions" class="hidden mb-4 flex space-x-2">
                <button id="edit-button" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">{{ __('Editar') }}</button>
                <button id="move-button" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">{{ __('Mover') }}</button>
                <button id="delete-button" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">{{ __('Borrar') }}</button>
                <button id="print-qr-button" class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800">{{ __('Imprimir QR') }}</button>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-primary text-text-dark dark:bg-dark-primary dark:text-gray-800">
                            <tr>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">
                                    {{ __('Estado') }}
                                </th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">
                                    <a class="hover:text-primary-dark" href="{{ route('hives.index', array_merge(request()->query(), ['sort' => 'name', 'direction' => $sort === 'name' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                        {{ __('Nombre') }}
                                        @if ($sort === 'name')
                                            <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">
                                    <a class="hover:text-primary-dark" href="{{ route('hives.index', array_merge(request()->query(), ['sort' => 'apiary', 'direction' => $sort === 'apiary' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                        {{ __('Apiario') }}
                                        @if ($sort === 'apiary')
                                            <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">
                                    <a class="hover:text-primary-dark" href="{{ route('hives.index', array_merge(request()->query(), ['sort' => 'updated_at', 'direction' => $sort === 'updated_at' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                        {{ __('Ultima Modificacion') }}
                                        @if ($sort === 'updated_at')
                                            <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">
                                    <a class="hover:text-primary-dark" href="{{ route('hives.index', array_merge(request()->query(), ['sort' => 'birth_date', 'direction' => $sort === 'birth_date' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                        {{ __('Fecha de nacimiento') }}
                                        @if ($sort === 'birth_date')
                                            <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">
                                    <a class="hover:text-primary-dark" href="{{ route('hives.index', array_merge(request()->query(), ['sort' => 'rating', 'direction' => $sort === 'rating' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                        {{ __('Rating') }}
                                        @if ($sort === 'rating')
                                            <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">
                                    <a class="hover:text-primary-dark" href="{{ route('hives.index', array_merge(request()->query(), ['sort' => 'type', 'direction' => $sort === 'type' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                        {{ __('Tipo') }}
                                        @if ($sort === 'type')
                                            <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">
                                    {{ __('Acciones') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 dark:text-dark-text-light">
                            @forelse ($hives as $hive)
                                <tr class="border-b hover:bg-background dark:hover:bg-dark-background dark:border-gray-700">
                                    <td class="py-3 px-4">
                                        <input type="checkbox" class="hive-checkbox" value="{{ $hive->id }}" data-slug="{{ $hive->slug }}">
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex flex-wrap gap-1">
                                            @forelse ($hive->states as $state)
                                                <span class="px-2 py-1 text-xs font-semibold text-white rounded-full {{
                                                    match($state->type) {
                                                        'good' => 'bg-green-500',
                                                        'bad' => 'bg-red-500',
                                                        'neutral' => 'bg-yellow-500',
                                                        default => 'bg-gray-500',
                                                    }
                                                }}" title="{{ $state->description }}">
                                                    {{ $state->name }}
                                                </span>
                                            @empty
                                                <span class="px-2 py-1 text-xs font-semibold text-white rounded-full bg-gray-500">
                                                    N/A
                                                </span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('hives.show', $hive) }}" class="text-sm text-green-600 hover:text-green-900 font-semibold dark:text-green-400 dark:hover:text-green-300">{{ $hive->name }}</a>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if ($hive->apiary)
                                            <a href="{{ route('apiaries.show', $hive->apiary) }}" class="text-sm text-blue-600 hover:text-blue-900 font-semibold dark:text-blue-400 dark:hover:text-blue-300">{{ $hive->apiary->name }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">{{ $hive->updated_at->format('d/m/Y H:i') }}</td>
                                    <td class="py-3 px-4">{{ $hive->birth_date ? $hive->birth_date->format('d/m/Y') : 'N/A' }}</td>
                                    <td class="py-3 px-4">{{ $hive->rating ?? 'N/A' }}</td>
                                    <td class="py-3 px-4">{{ $hive->type }}</td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('hives.show', $hive) }}" class="text-sm text-green-600 hover:text-green-900 font-semibold dark:text-green-400 dark:hover:text-green-300">Ver</a>
                                            <a href="{{ route('hives.edit', $hive) }}" class="text-sm text-blue-600 hover:text-blue-900 font-semibold dark:text-blue-400 dark:hover:text-blue-300">Editar</a>
                                            <form action="{{ route('hives.destroy', $hive) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-600 hover:text-red-900 font-semibold dark:text-red-400 dark:hover:text-red-300">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-12">
                                        <p class="text-gray-500 text-lg dark:text-gray-400">{{ __('No se encontraron colmenas.') }}</p>
                                        @if(request('search'))
                                            <p class="text-gray-400 mt-2 dark:text-gray-500">{{ __('Intenta con otra búsqueda.') }}</p>
                                        @else
                                            <p class="text-gray-400 mt-2 dark:text-gray-500">{{ __('¡Crea tu primera colmena para empezar a gestionar tus abejas!') }}</p>
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 bg-white dark:bg-dark-surface">
                    {{ $hives->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- QR Scanner Modal -->
    <div id="qr-scanner-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-md bg-white dark:bg-dark-surface">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-dark-text-dark">Escanear Código QR</h3>
                <div class="mt-4 px-7 py-3">
                    <div id="qr-reader" style="width: 100%;"></div>
                    <p id="qr-scan-result" class="mt-4 text-sm text-gray-500 dark:text-dark-text-light">Apunte la cámara al código QR...</p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="close-qr-scanner-modal" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-auto shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 dark:bg-gray-600 dark:text-white dark:hover:bg-gray-500">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <x-create-hive-modal :apiaries="$apiaries" :types="$types" />

    <!-- Bulk Edit Modal -->
    <div id="edit-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 text-center">{{ __('Editar Colmenas en Lote') }}</h3>
                <div class="mt-4 px-7 py-3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Type -->
                        <div>
                            <label for="bulk-type" class="block font-medium text-sm text-gray-700">{{ __('Tipo') }}</label>
                            <select id="bulk-type" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary-light focus:ring-opacity-50">
                                @foreach ($types as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="mt-6">
                        <label for="bulk-location" class="block font-medium text-sm text-gray-700">{{ __('Nombre de la Ubicación (Opcional)') }}</label>
                        <input id="bulk-location" type="text" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary-light focus:ring-opacity-50" autocomplete="off">
                    </div>

                    <!-- Location GPS -->
                    <div class="mt-4">
                        <label for="bulk-location-gps" class="block font-medium text-sm text-gray-700">{{ __('Coordenadas GPS (Opcional)') }}</label>
                        <div class="flex items-center gap-2 mt-1">
                            <input id="bulk-location-gps" type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary-light focus:ring-opacity-50" autocomplete="off">
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
                        @foreach ($apiaries as $apiaryOption)
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

    <x-google-maps-modal />

    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script>
        window.initMap = function () {};
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('select-all');
            const hiveCheckboxes = document.querySelectorAll('.hive-checkbox');
            const bulkActionsDiv = document.getElementById('bulk-actions');
            const editButton = document.getElementById('edit-button');
            const moveButton = document.getElementById('move-button');
            const deleteButton = document.getElementById('delete-button');
            const printQrButton = document.getElementById('print-qr-button');

            const editModal = document.getElementById('edit-modal');
            const moveModal = document.getElementById('move-modal');
            const deleteModal = document.getElementById('delete-modal');

            const cancelEditButton = document.getElementById('cancel-edit-button');
            const cancelMoveButton = document.getElementById('cancel-move-button');
            const cancelDeleteButton = document.getElementById('cancel-delete-button');

            const confirmEditButton = document.getElementById('confirm-edit-button');
            const confirmMoveButton = document.getElementById('confirm-move-button');
            const confirmDeleteButton = document.getElementById('confirm-delete-button');

            const moveApiarySelect = document.getElementById('move-apiary-select');

            function getSelectedHiveIds() {
                return Array.from(hiveCheckboxes)
                           .filter(checkbox => checkbox.checked)
                           .map(checkbox => checkbox.value);
            }

            function getSelectedHiveSlugs() {
                return Array.from(hiveCheckboxes)
                           .filter(checkbox => checkbox.checked)
                           .map(checkbox => checkbox.dataset.slug);
            }

            function updateBulkActionsVisibility() {
                const selectedIds = getSelectedHiveIds();
                bulkActionsDiv.classList.toggle('hidden', selectedIds.length === 0);
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

            editButton.addEventListener('click', () => editModal.classList.remove('hidden'));
            moveButton.addEventListener('click', () => moveModal.classList.remove('hidden'));
            deleteButton.addEventListener('click', () => deleteModal.classList.remove('hidden'));
            printQrButton.addEventListener('click', () => {
                const hiveSlugs = getSelectedHiveSlugs();
                if (hiveSlugs.length > 0) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("hives.printQrs") }}';
                    form.target = '_blank'; // Open in a new tab

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    form.appendChild(csrfInput);

                    const slugsInput = document.createElement('input');
                    slugsInput.type = 'hidden';
                    slugsInput.name = 'hive_slugs';
                    slugsInput.value = hiveSlugs.join(',');
                    form.appendChild(slugsInput);

                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);
                } else {
                    alert('Por favor, selecciona al menos una colmena.');
                }
            });

            cancelEditButton.addEventListener('click', () => editModal.classList.add('hidden'));
            cancelMoveButton.addEventListener('click', () => moveModal.classList.add('hidden'));
            cancelDeleteButton.addEventListener('click', () => deleteModal.classList.add('hidden'));

            confirmMoveButton.addEventListener('click', function () {
                const hiveIds = getSelectedHiveIds();
                const apiaryId = moveApiarySelect.value;
                performBulkAction('move', hiveIds, { apiary_id: apiaryId });
            });

            confirmDeleteButton.addEventListener('click', function () {
                const hiveIds = getSelectedHiveIds();
                performBulkAction('delete', hiveIds);
            });

            confirmEditButton.addEventListener('click', () => {
                const hiveIds = getSelectedHiveIds();
                const type = document.getElementById('bulk-type').value;
                const location = document.getElementById('bulk-location').value;
                const location_gps = document.getElementById('bulk-location-gps').value;

                const data = {
                    type,
                    location,
                    location_gps
                };

                performBulkAction('edit', hiveIds, data);
            });

            function performBulkAction(action, hiveIds, data = {}) {
                if (hiveIds.length === 0) {
                    alert('Por favor, selecciona al menos una colmena.');
                    return;
                }

                fetch('{{ route("hives.bulkActions") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        action: action,
                        hive_ids: hiveIds,
                        ...data
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'Ocurrió un error.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al procesar la solicitud.');
                });
            }
        });

        // QR Scanner Logic
        const qrScannerModal = document.getElementById('qr-scanner-modal');
        const openQrScannerButton = document.getElementById('scan-qr-button');
        const closeQrScannerButton = document.getElementById('close-qr-scanner-modal');
        const qrScanResult = document.getElementById('qr-scan-result');

        let html5QrCode;

        function onScanSuccess(decodedText, decodedResult) {
            try {
                const url = new URL(decodedText);
                const pathSegments = url.pathname.split('/');
                const hiveId = pathSegments.pop() || pathSegments.pop();

                if (hiveId && !isNaN(hiveId)) {
                    const checkbox = document.querySelector(`.hive-checkbox[value="${hiveId}"]`);
                    if (checkbox) {
                        if (!checkbox.checked) {
                            checkbox.checked = true;
                            updateBulkActionsVisibility();
                            qrScanResult.textContent = `Colmena #${hiveId} seleccionada. ¡Listo para el siguiente!`;
                        } else {
                            qrScanResult.textContent = `Colmena #${hiveId} ya estaba seleccionada.`;
                        }
                    } else {
                        qrScanResult.textContent = `Colmena #${hiveId} no encontrada en esta página.`;
                    }
                } else {
                    qrScanResult.textContent = `Código QR no contiene un ID de colmena válido.`;
                }
            } catch (e) {
                console.error("Error al procesar el código QR:", e);
                qrScanResult.textContent = 'Error al procesar el código QR. Intente de nuevo.';
            }
        }

        function onScanFailure(error) {
            // console.warn(`Code scan error = ${error}`);
        }

        const startScanner = () => {
            if (typeof Html5Qrcode !== 'undefined') {
                html5QrCode = new Html5Qrcode("qr-reader");
                const config = {
                    fps: 10,
                    qrbox: { width: 250, height: 250 },
                    rememberLastUsedCamera: true
                };
                html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess, onScanFailure)
                    .catch(err => {
                        console.error("Unable to start scanning.", err);
                        qrScanResult.textContent = "No se pudo iniciar el escáner. Verifique los permisos de la cámara.";
                    });
            } else {
                console.error("Html5Qrcode library not loaded.");
                qrScanResult.textContent = "La librería de escaneo no se cargó correctamente.";
            }
        };

        const stopScanner = () => {
            if (html5QrCode && html5QrCode.isScanning) {
                html5QrCode.stop()
                    .then(() => console.log("QR Code scanning stopped."))
                    .catch(err => console.warn("Error stopping the scanner.", err));
            }
        };

        openQrScannerButton.addEventListener('click', () => {
            qrScannerModal.classList.remove('hidden');
            qrScanResult.textContent = "Apunte la cámara al código QR...";
            setTimeout(startScanner, 100);
        });

        closeQrScannerButton.addEventListener('click', () => {
            stopScanner();
            qrScannerModal.classList.add('hidden');
        });
    </script>
</x-app-layout>
