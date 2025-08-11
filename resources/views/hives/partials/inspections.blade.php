<div id="inspections-content" class="tab-content">
    <!-- Create Inspection Form -->
    <div class="mb-6 bg-white rounded-lg shadow-md p-6">
        <h4 class="text-xl font-semibold mb-4">Añadir Nueva Inspección</h4>
        <form action="{{ route('hives.inspections.store', $hive) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Inspection Date -->
                <div>
                    <label for="inspection_date" class="flex items-center text-sm font-medium text-gray-700">
                        <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ __('Fecha de Inspección') }}
                    </label>
                    <x-text-input id="inspection_date" class="block mt-1 w-full" type="date" name="inspection_date" :value="old('inspection_date', now()->format('Y-m-d'))" required />
                    <x-input-error :messages="$errors->get('inspection_date')" class="mt-2" />
                </div>

                <!-- Queen Status -->
                <div>
                    <label for="queen_status" class="flex items-center text-sm font-medium text-gray-700">
                        <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7l9-4 9 4M4 10h16v10H4V10z"></path></svg>
                        {{ __('Estado de la Reina') }}
                    </label>
                    <select id="queen_status" name="queen_status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        @foreach (App\Models\Inspection::getQueenStatusOptions() as $status)
                            <option value="{{ $status }}" @if (old('queen_status', $lastInspection->queen_status ?? '') == $status) selected @endif>{{ $status }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('queen_status')" class="mt-2" />
                </div>

                <!-- Population -->
                <div>
                    <label for="population" class="flex items-center text-sm font-medium text-gray-700">
                        <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.125-1.274-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.125-1.274.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        {{ __('Población') }}
                    </label>
                    <div class="flex items-center space-x-3 mt-1">
                        <input type="range" id="population" name="population" min="0" max="100" value="{{ old('population', $lastInspection->population ?? 50) }}" class="slider-blue w-full">
                        <span id="population_value" class="text-lg font-bold text-blue-600 w-12 text-center">{{ old('population', $lastInspection->population ?? 50) }}%</span>
                    </div>
                    <x-input-error :messages="$errors->get('population')" class="mt-2" />
                </div>

                <!-- Honey Stores -->
                <div>
                    <label for="honey_stores" class="flex items-center text-sm font-medium text-gray-700">
                        <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        {{ __('Reservas de Miel') }}
                    </label>
                    <div class="flex items-center space-x-3 mt-1">
                        <input type="range" id="honey_stores" name="honey_stores" min="0" max="100" value="{{ old('honey_stores', $lastInspection->honey_stores ?? 50) }}" class="slider-yellow w-full">
                        <span id="honey_stores_value" class="text-lg font-bold text-yellow-600 w-12 text-center">{{ old('honey_stores', $lastInspection->honey_stores ?? 50) }}%</span>
                    </div>
                    <x-input-error :messages="$errors->get('honey_stores')" class="mt-2" />
                </div>

                <!-- Pollen Stores -->
                <div>
                    <label for="pollen_stores" class="flex items-center text-sm font-medium text-gray-700">
                        <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        {{ __('Reservas de Polen') }}
                    </label>
                    <div class="flex items-center space-x-3 mt-1">
                        <input type="range" id="pollen_stores" name="pollen_stores" min="0" max="100" value="{{ old('pollen_stores', $lastInspection->pollen_stores ?? 50) }}" class="slider-purple w-full">
                        <span id="pollen_stores_value" class="text-lg font-bold text-purple-600 w-12 text-center">{{ old('pollen_stores', $lastInspection->pollen_stores ?? 50) }}%</span>
                    </div>
                    <x-input-error :messages="$errors->get('pollen_stores')" class="mt-2" />
                </div>

                <!-- Brood Pattern -->
                <div>
                    <label for="brood_pattern" class="flex items-center text-sm font-medium text-gray-700">
                        <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ __('Patrón de Cría') }}
                    </label>
                    <div class="flex items-center space-x-3 mt-1">
                        <input type="range" id="brood_pattern" name="brood_pattern" min="0" max="100" value="{{ old('brood_pattern', $lastInspection->brood_pattern ?? 50) }}" class="slider-pink w-full">
                        <span id="brood_pattern_value" class="text-lg font-bold text-pink-600 w-12 text-center">{{ old('brood_pattern', $lastInspection->brood_pattern ?? 50) }}%</span>
                    </div>
                    <x-input-error :messages="$errors->get('brood_pattern')" class="mt-2" />
                </div>

                <!-- Behavior -->
                <div>
                    <label for="behavior" class="flex items-center text-sm font-medium text-gray-700">
                        <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        {{ __('Agresividad') }}
                    </label>
                    <div class="flex items-center space-x-3 mt-1">
                        <input type="range" id="behavior" name="behavior" min="0" max="100" value="{{ old('behavior', $lastInspection->behavior ?? 50) }}" class="slider-red w-full">
                        <span id="behavior_value" class="text-lg font-bold text-red-600 w-12 text-center">{{ old('behavior', $lastInspection->behavior ?? 50) }}%</span>
                    </div>
                    <x-input-error :messages="$errors->get('behavior')" class="mt-2" />
                </div>

                <!-- Pests and Diseases -->
                <div>
                     <label for="pests_diseases" class="flex items-center text-sm font-medium text-gray-700">
                        <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ __('Plagas y Enfermedades') }}
                    </label>
                    <select id="pests_diseases" name="pests_diseases" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        @foreach (App\Models\Inspection::getPestsAndDiseasesOptions() as $option)
                            <option value="{{ $option }}" @if (old('pests_diseases', $lastInspection->pests_diseases ?? '') == $option) selected @endif>{{ $option }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('pests_diseases')" class="mt-2" />
                </div>

                <!-- Treatments -->
                <div>
                    <label for="treatments" class="flex items-center text-sm font-medium text-gray-700">
                        <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ __('Tratamientos Aplicados') }}
                    </label>
                    <select id="treatments" name="treatments" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        @foreach (App\Models\Inspection::getTreatmentsOptions() as $option)
                            <option value="{{ $option }}" @if (old('treatments', $lastInspection->treatments ?? '') == $option) selected @endif>{{ $option }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('treatments')" class="mt-2" />
                </div>

                <!-- Notes -->
                <div class="md:col-span-2 lg:col-span-3">
                    <label for="notes" class="flex items-center text-sm font-medium text-gray-700">
                        <svg class="h-5 w-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        {{ __('Notas Adicionales') }}
                    </label>
                    <textarea id="notes" name="notes" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes', $lastInspection->notes ?? '') }}</textarea>
                    <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                </div>
            </div>

            <div class="flex items-center justify-end mt-6">
                <x-primary-button>
                    {{ __('Guardar Inspección') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <!-- Inspections History -->
    <div class="mt-8">
        <h4 class="text-xl font-semibold mb-4">Historial de Inspecciones</h4>
        <div class="space-y-6">
            @forelse ($hive->inspections->sortByDesc('inspection_date') as $inspection)
                <div class="bg-gray-50 rounded-lg shadow-md p-6 border border-gray-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold text-lg text-gray-800">{{ $inspection->inspection_date->format('d/m/Y') }}</p>
                            <p class="text-sm text-gray-500">Inspección #{{ $inspection->id }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                             @if ($inspection->queen_status === 'Presente' || $inspection->queen_status === 'Reina Fecundada')
                                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Reina OK</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">{{ $inspection->queen_status }}</span>
                            @endif
                            @if ($inspection->pests_diseases !== 'Sin plagas')
                                <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Alerta Plaga</span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <!-- Population -->
                        <div class="flex items-center space-x-3">
                             <div class="flex-shrink-0 bg-blue-500 rounded-full p-2">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.125-1.274-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.653.125-1.274.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Población</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $inspection->population }}%</p>
                            </div>
                        </div>
                        <!-- Honey -->
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-full p-2">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Miel</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $inspection->honey_stores }}%</p>
                            </div>
                        </div>
                        <!-- Pollen -->
                         <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 bg-purple-500 rounded-full p-2">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Polen</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $inspection->pollen_stores }}%</p>
                            </div>
                        </div>
                        <!-- Brood -->
                        <div class="flex items-center space-x-3">
                             <div class="flex-shrink-0 bg-pink-500 rounded-full p-2">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Cría</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $inspection->brood_pattern }}%</p>
                            </div>
                        </div>
                        <!-- Behavior -->
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 bg-red-500 rounded-full p-2">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Agresividad</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $inspection->behavior }}%</p>
                            </div>
                        </div>
                        <!-- Pests -->
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 bg-gray-500 rounded-full p-2">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Plagas</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $inspection->pests_diseases }}</p>
                            </div>
                        </div>
                         <!-- Treatments -->
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 bg-green-500 rounded-full p-2">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Tratamientos</p>
                                <p class="text-lg font-semibold text-gray-800">{{ $inspection->treatments }}</p>
                            </div>
                        </div>
                    </div>

                    @if($inspection->notes)
                        <div class="mt-6 border-t border-gray-200 pt-4">
                            <h5 class="text-md font-semibold text-gray-700">Notas Adicionales</h5>
                            <p class="mt-2 text-sm text-gray-600">{{ $inspection->notes }}</p>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">No hay inspecciones registradas para esta colmena.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sliders = [
            { id: 'population', valueId: 'population_value' },
            { id: 'honey_stores', valueId: 'honey_stores_value' },
            { id: 'pollen_stores', valueId: 'pollen_stores_value' },
            { id: 'brood_pattern', valueId: 'brood_pattern_value' },
            { id: 'behavior', valueId: 'behavior_value' },
        ];

        sliders.forEach(slider => {
            const sliderElement = document.getElementById(slider.id);
            const valueElement = document.getElementById(slider.valueId);

            if (sliderElement) {
                sliderElement.addEventListener('input', function () {
                    valueElement.textContent = this.value;
                });
            }
        });
    });
</script>
@endpush
