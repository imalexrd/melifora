<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventario de Alzas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold">{{ __('Total de Alzas') }}</h3>
                        <p class="text-3xl font-bold">{{ $total }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold">{{ __('Alzas Asignadas') }}</h3>
                        <p class="text-3xl font-bold">{{ $assigned }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold">{{ __('Alzas Libres') }}</h3>
                        <p class="text-3xl font-bold">{{ $unassigned }}</p>
                    </div>
                </div>
            </div>

            <!-- Add Super Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Añadir Nuevas Alzas') }}</h3>
                    <form action="{{ route('hive_supers.store') }}" method="POST" class="flex items-center space-x-4">
                        @csrf
                        <div>
                            <label for="number_of_supers" class="sr-only">{{ __('Número de Alzas') }}</label>
                            <input type="number" name="number_of_supers" id="number_of_supers" value="1" min="1" max="100" class="rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary-light focus:ring-opacity-50">
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 active:bg-opacity-95 focus:outline-none focus:border-primary focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Añadir') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Search and per-page form -->
            <div class="mb-4 flex justify-between items-center">
                <form action="{{ route('hive_supers.index') }}" method="GET" class="flex-grow flex flex-col sm:flex-row gap-4">
                    <div class="flex-grow">
                        <input type="text" name="search" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary-light focus:ring-opacity-50" placeholder="Buscar por código o colmena..." value="{{ request('search') }}">
                    </div>
                    <div class="flex items-center gap-2">
                        <select name="per_page" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary-light focus:ring-opacity-50">
                            <option value="10" @if($perPage == 10) selected @endif>10 por página</option>
                            <option value="25" @if($perPage == 25) selected @endif>25 por página</option>
                            <option value="50" @if($perPage == 50) selected @endif>50 por página</option>
                            <option value="100" @if($perPage == 100) selected @endif>100 por página</option>
                        </select>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-secondary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 active:bg-opacity-95 focus:outline-none focus:border-secondary focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Buscar
                        </button>
                    </div>
                </form>
            </div>

            <div id="bulk-actions-bar" class="hidden mb-4 flex space-x-2">
                <button id="assign-button" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">{{ __('Asignar') }}</button>
                <button id="unassign-button" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">{{ __('Desasignar') }}</button>
                <button id="delete-button" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">{{ __('Borrar') }}</button>
            </div>

            <!-- Supers Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-primary text-text-dark">
                            <tr>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">
                                    <a class="hover:text-primary-dark" href="{{ route('hive_supers.index', array_merge(request()->query(), ['sort' => 'tracking_code', 'direction' => $sort === 'tracking_code' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                        {{ __('Código de Rastreo') }}
                                        @if ($sort === 'tracking_code')
                                            <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">
                                    <a class="hover:text-primary-dark" href="{{ route('hive_supers.index', array_merge(request()->query(), ['sort' => 'hive', 'direction' => $sort === 'hive' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                        {{ __('Colmena Asignada') }}
                                        @if ($sort === 'hive')
                                            <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">
                                    <a class="hover:text-primary-dark" href="{{ route('hive_supers.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => $sort === 'created_at' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                                        {{ __('Fecha de Creación') }}
                                        @if ($sort === 'created_at')
                                            <span class="ml-1">{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($hiveSupers as $super)
                                <tr class="border-b hover:bg-background">
                                    <td class="py-3 px-4">
                                        <input type="checkbox" class="hive-super-checkbox" value="{{ $super->id }}">
                                    </td>
                                    <td class="py-3 px-4">{{ $super->tracking_code }}</td>
                                    <td class="py-3 px-4">
                                        @if ($super->hive)
                                            <a href="{{ route('hives.show', $super->hive) }}" class="text-sm text-blue-600 hover:text-blue-900 font-semibold">{{ $super->hive->name }}</a>
                                        @else
                                            <span class="text-sm text-gray-500">{{ __('No asignada') }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">{{ $super->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-12">
                                        <p class="text-gray-500 text-lg">{{ __('No se encontraron alzas.') }}</p>
                                        @if(request('search'))
                                            <p class="text-gray-400 mt-2">{{ __('Intenta con otra búsqueda.') }}</p>
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 bg-white">
                    {{ $hiveSupers->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div id="delete-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('Borrar Alzas') }}</h3>
                <div class="mt-2 px-7 py-3">
                    <p>{{ __('¿Estás seguro de que quieres borrar las alzas seleccionadas?') }}</p>
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

    <div id="assign-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('Asignar Alzas a Colmena') }}</h3>
                <div class="mt-2 px-7 py-3">
                    <select id="assign-hive-select" class="w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">{{ __('Selecciona una colmena') }}</option>
                        @foreach ($allHives as $hive)
                            <option value="{{ $hive->id }}">{{ $hive->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirm-assign-button" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-auto shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        {{ __('Confirmar') }}
                    </button>
                    <button id="cancel-assign-button" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-auto shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        {{ __('Cancelar') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('select-all');
            const superCheckboxes = document.querySelectorAll('.hive-super-checkbox');
            const bulkActionsBar = document.getElementById('bulk-actions-bar');

            const assignButton = document.getElementById('assign-button');
            const unassignButton = document.getElementById('unassign-button');
            const deleteButton = document.getElementById('delete-button');

            const deleteModal = document.getElementById('delete-modal');
            const assignModal = document.getElementById('assign-modal');

            const confirmDeleteButton = document.getElementById('confirm-delete-button');
            const cancelDeleteButton = document.getElementById('cancel-delete-button');
            const confirmAssignButton = document.getElementById('confirm-assign-button');
            const cancelAssignButton = document.getElementById('cancel-assign-button');

            function getSelectedSuperIds() {
                return Array.from(superCheckboxes)
                           .filter(checkbox => checkbox.checked)
                           .map(checkbox => checkbox.value);
            }

            function updateBulkActionsVisibility() {
                const selectedIds = getSelectedSuperIds();
                bulkActionsBar.classList.toggle('hidden', selectedIds.length === 0);
            }

            selectAllCheckbox.addEventListener('change', function () {
                superCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateBulkActionsVisibility();
            });

            superCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkActionsVisibility);
            });

            deleteButton.addEventListener('click', () => deleteModal.classList.remove('hidden'));
            cancelDeleteButton.addEventListener('click', () => deleteModal.classList.add('hidden'));

            assignButton.addEventListener('click', () => assignModal.classList.remove('hidden'));
            cancelAssignButton.addEventListener('click', () => assignModal.classList.add('hidden'));

            unassignButton.addEventListener('click', () => {
                const superIds = getSelectedSuperIds();
                if (superIds.length > 0) {
                    performBulkAction('unassign', superIds);
                }
            });

            confirmDeleteButton.addEventListener('click', () => {
                const superIds = getSelectedSuperIds();
                performBulkAction('delete', superIds);
            });

            confirmAssignButton.addEventListener('click', () => {
                const superIds = getSelectedSuperIds();
                const hiveId = document.getElementById('assign-hive-select').value;
                if (hiveId) {
                    performBulkAction('assign', superIds, { hive_id: hiveId });
                } else {
                    alert('Por favor, selecciona una colmena.');
                }
            });

            function performBulkAction(action, hiveSuperIds, data = {}) {
                if (hiveSuperIds.length === 0) {
                    alert('Por favor, selecciona al menos un alza.');
                    return;
                }

                fetch('{{ route("hive_supers.bulkActions") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        action: action,
                        hive_super_ids: hiveSuperIds,
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
    </script>
    @endpush
</x-app-layout>
