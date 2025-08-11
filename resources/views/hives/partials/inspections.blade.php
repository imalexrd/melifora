<div id="inspections-content" class="tab-content hidden">
    <!-- Create Inspection Form -->
    <div class="mb-6 bg-white rounded-lg shadow-md p-6">
        <h4 class="text-xl font-semibold mb-4">Añadir Nueva Inspección</h4>
        <form action="{{ route('hives.inspections.store', $hive) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Inspection Date -->
                <div>
                    <x-input-label for="inspection_date" :value="__('Fecha de Inspección')" />
                    <x-text-input id="inspection_date" class="block mt-1 w-full" type="date" name="inspection_date" :value="old('inspection_date', now()->format('Y-m-d'))" required />
                    <x-input-error :messages="$errors->get('inspection_date')" class="mt-2" />
                </div>

                <!-- Queen Status -->
                <div>
                    <x-input-label for="queen_status" :value="__('Estado de la Reina')" />
                    <select id="queen_status" name="queen_status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        @foreach (App\Models\Inspection::getQueenStatusOptions() as $status)
                            <option value="{{ $status }}" @if (old('queen_status') == $status) selected @endif>{{ $status }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('queen_status')" class="mt-2" />
                </div>

                <!-- Population -->
                <div>
                    <x-input-label for="population" :value="__('Población (0-100)')" />
                    <input type="range" id="population" name="population" min="0" max="100" value="{{ old('population', 50) }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    <span id="population_value" class="text-sm text-gray-600">50</span>
                    <x-input-error :messages="$errors->get('population')" class="mt-2" />
                </div>

                <!-- Honey Stores -->
                <div>
                    <x-input-label for="honey_stores" :value="__('Reservas de Miel (0-100)')" />
                    <input type="range" id="honey_stores" name="honey_stores" min="0" max="100" value="{{ old('honey_stores', 50) }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    <span id="honey_stores_value" class="text-sm text-gray-600">50</span>
                    <x-input-error :messages="$errors->get('honey_stores')" class="mt-2" />
                </div>

                <!-- Pollen Stores -->
                <div>
                    <x-input-label for="pollen_stores" :value="__('Reservas de Polen (0-100)')" />
                    <input type="range" id="pollen_stores" name="pollen_stores" min="0" max="100" value="{{ old('pollen_stores', 50) }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    <span id="pollen_stores_value" class="text-sm text-gray-600">50</span>
                    <x-input-error :messages="$errors->get('pollen_stores')" class="mt-2" />
                </div>

                <!-- Brood Pattern -->
                <div>
                    <x-input-label for="brood_pattern" :value="__('Patrón de Cría (0-100)')" />
                    <input type="range" id="brood_pattern" name="brood_pattern" min="0" max="100" value="{{ old('brood_pattern', 50) }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    <span id="brood_pattern_value" class="text-sm text-gray-600">50</span>
                    <x-input-error :messages="$errors->get('brood_pattern')" class="mt-2" />
                </div>

                <!-- Behavior -->
                <div>
                    <x-input-label for="behavior" :value="__('Agresividad (0-100)')" />
                    <input type="range" id="behavior" name="behavior" min="0" max="100" value="{{ old('behavior', 50) }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                    <span id="behavior_value" class="text-sm text-gray-600">50</span>
                    <x-input-error :messages="$errors->get('behavior')" class="mt-2" />
                </div>

                <!-- Pests and Diseases -->
                <div>
                    <x-input-label for="pests_diseases" :value="__('Plagas y Enfermedades')" />
                    <select id="pests_diseases" name="pests_diseases" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        @foreach (App\Models\Inspection::getPestsAndDiseasesOptions() as $option)
                            <option value="{{ $option }}" @if (old('pests_diseases') == $option) selected @endif>{{ $option }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('pests_diseases')" class="mt-2" />
                </div>

                <!-- Treatments -->
                <div>
                    <x-input-label for="treatments" :value="__('Tratamientos Aplicados')" />
                    <select id="treatments" name="treatments" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        @foreach (App\Models\Inspection::getTreatmentsOptions() as $option)
                            <option value="{{ $option }}" @if (old('treatments') == $option) selected @endif>{{ $option }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('treatments')" class="mt-2" />
                </div>

                <!-- Notes -->
                <div class="md:col-span-2 lg:col-span-3">
                    <x-input-label for="notes" :value="__('Notas Adicionales')" />
                    <textarea id="notes" name="notes" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('notes') }}</textarea>
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
    <h4 class="text-xl font-semibold mb-4">Historial de Inspecciones</h4>
    <div class="space-y-4">
        @forelse ($hive->inspections->sortByDesc('inspection_date') as $inspection)
            <div class="border-l-4 border-blue-400 pl-4">
                 <p><strong>Fecha:</strong> {{ $inspection->inspection_date->format('d/m/Y') }}</p>
                 <p><strong>Estado Reina:</strong> {{ $inspection->queen_status }}</p>
                 <p><strong>Población:</strong> {{ $inspection->population }}%</p>
                 <p><strong>Miel:</strong> {{ $inspection->honey_stores }}%</p>
                 <p><strong>Polen:</strong> {{ $inspection->pollen_stores }}%</p>
                 <p><strong>Cría:</strong> {{ $inspection->brood_pattern }}%</p>
                 <p><strong>Agresividad:</strong> {{ $inspection->behavior }}%</p>
                 <p><strong>Plagas/Enfermedades:</strong> {{ $inspection->pests_diseases }}</p>
                 <p><strong>Tratamientos:</strong> {{ $inspection->treatments }}</p>
                 <p><strong>Notas:</strong> {{ $inspection->notes ?? 'N/A' }}</p>
            </div>
        @empty
            <p>No hay inspecciones registradas.</p>
        @endforelse
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
