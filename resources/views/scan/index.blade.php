<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Escanear y Acciones en Lote') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Columna del Escáner -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Escáner QR</h3>
                        <div id="qr-reader" style="width:100%;"></div>
                        <p id="qr-scan-result" class="mt-4 text-sm text-gray-500">Haga clic en "Iniciar Escáner" para empezar.</p>
                        <div class="mt-4">
                            <button id="start-scan-btn" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Iniciar Escáner
                            </button>
                            <button id="stop-scan-btn" class="hidden inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                                Detener Escáner
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Columna de Colmenas Escaneadas y Acciones -->
                <div class="space-y-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Colmenas Escaneadas</h3>
                            <ul id="scanned-hives-list" class="space-y-2">
                                <!-- Las colmenas escaneadas se añadirán aquí -->
                            </ul>
                            <p id="no-hives-message" class="text-gray-500">Aún no se han escaneado colmenas.</p>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Acciones en Lote</h3>
                            <div id="bulk-actions-container" class="hidden space-x-2">
                                <button id="bulk-inspect-btn" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Inspeccionar</button>
                                <button id="bulk-move-btn" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Mover</button>
                                <button id="bulk-delete-btn" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Borrar</button>
                                <button id="bulk-print-qr-btn" class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800">Imprimir QR</button>
                            </div>
                            <p id="no-actions-message" class="text-gray-500">Escanee al menos una colmena para ver las acciones.</p>
                        </div>
                    </div>
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

    <!-- Bulk Inspect Modal -->
    <div id="inspect-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-3xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 text-center">{{ __('Inspección en Lote') }}</h3>
                <div class="mt-4 px-7 py-3">
                    <form id="bulk-inspect-form" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Inspection Date -->
                            <div>
                                <label for="inspection_date" class="block font-medium text-sm text-gray-700">{{ __('Fecha de Inspección') }}</label>
                                <input id="inspection_date" type="date" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <!-- Queen Status -->
                            <div>
                                <label for="queen_status" class="block font-medium text-sm text-gray-700">{{ __('Estado de la Reina') }}</label>
                                <select id="queen_status" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                                    @foreach ($queenStatusOptions as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Population -->
                            <div>
                                <label for="population" class="block font-medium text-sm text-gray-700">{{ __('Población (%)') }}</label>
                                <input id="population" type="number" min="0" max="100" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <!-- Honey Stores -->
                            <div>
                                <label for="honey_stores" class="block font-medium text-sm text-gray-700">{{ __('Reservas de Miel (%)') }}</label>
                                <input id="honey_stores" type="number" min="0" max="100" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <!-- Pollen Stores -->
                            <div>
                                <label for="pollen_stores" class="block font-medium text-sm text-gray-700">{{ __('Reservas de Polen (%)') }}</label>
                                <input id="pollen_stores" type="number" min="0" max="100" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <!-- Brood Pattern -->
                            <div>
                                <label for="brood_pattern" class="block font-medium text-sm text-gray-700">{{ __('Patrón de Cría (%)') }}</label>
                                <input id="brood_pattern" type="number" min="0" max="100" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <!-- Behavior -->
                            <div>
                                <label for="behavior" class="block font-medium text-sm text-gray-700">{{ __('Comportamiento (%)') }}</label>
                                <input id="behavior" type="number" min="0" max="100" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>

                            <!-- Pests & Diseases -->
                            <div>
                                <label for="pests_diseases" class="block font-medium text-sm text-gray-700">{{ __('Plagas y Enfermedades') }}</label>
                                <select id="pests_diseases" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                                     @foreach ($pestsAndDiseasesOptions as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Treatments -->
                            <div>
                                <label for="treatments" class="block font-medium text-sm text-gray-700">{{ __('Tratamientos') }}</label>
                                <select id="treatments" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                                     @foreach ($treatmentsOptions as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Anomalies -->
                            <div>
                                <label for="anomalies" class="block font-medium text-sm text-gray-700">{{ __('Anomalías') }}</label>
                                <select id="anomalies" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                                     @foreach ($anomaliesOptions as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Social States -->
                            <div>
                                <label for="social_states" class="block font-medium text-sm text-gray-700">{{ __('Estados Sociales') }}</label>
                                <select id="social_states" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                                     @foreach ($socialStatesOptions as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Season States -->
                            <div>
                                <label for="season_states" class="block font-medium text-sm text-gray-700">{{ __('Estados de Temporada') }}</label>
                                <select id="season_states" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                                     @foreach ($seasonStatesOptions as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Admin States -->
                            <div>
                                <label for="admin_states" class="block font-medium text-sm text-gray-700">{{ __('Estados Administrativos') }}</label>
                                <select id="admin_states" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                                     @foreach ($adminStatesOptions as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="col-span-1 md:col-span-2">
                            <label for="notes" class="block font-medium text-sm text-gray-700">{{ __('Notas') }}</label>
                            <textarea id="notes" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm"></textarea>
                        </div>
                    </form>
                </div>
                <div class="items-center px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button id="confirm-inspect-button" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Confirmar Inspección') }}
                    </button>
                    <button id="cancel-inspect-button" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        {{ __('Cancelar') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
