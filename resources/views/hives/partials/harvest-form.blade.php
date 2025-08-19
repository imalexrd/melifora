<div class="bg-white rounded-lg shadow-md p-6 dark:bg-dark-surface">
    <h3 class="text-xl font-semibold text-gray-800 mb-4 dark:text-dark-text-dark">Registrar Nueva Cosecha</h3>
    <form action="{{ route('hives.harvests.store', $hive) }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Harvest Date -->
            <div>
                <x-input-label for="harvest_date" :value="__('Fecha de Cosecha')" class="dark:text-dark-text-light" />
                <x-text-input id="harvest_date" class="block mt-1 w-full dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" type="date" name="harvest_date" :value="old('harvest_date', date('Y-m-d'))" required />
                <x-input-error :messages="$errors->get('harvest_date')" class="mt-2" />
            </div>

            <!-- Origin -->
            <div>
                <x-input-label for="origin" :value="__('Origen de la Miel')" class="dark:text-dark-text-light" />
                <select id="origin" name="origin" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" required>
                    <option value="Flores silvestres" @if(old('origin') == 'Flores silvestres') selected @endif>Flores silvestres</option>
                    <option value="Cultivos" @if(old('origin') == 'Cultivos') selected @endif>Cultivos</option>
                    <option value="Alimentación artificial" @if(old('origin') == 'Alimentación artificial') selected @endif>Alimentación artificial</option>
                    <option value="Otro" @if(old('origin') == 'Otro') selected @endif>Otro</option>
                </select>
                <x-input-error :messages="$errors->get('origin')" class="mt-2" />
            </div>

            <!-- Quantity KG -->
            <div>
                <x-input-label for="quantity_kg" :value="__('Cantidad (kg)')" class="dark:text-dark-text-light" />
                <x-text-input id="quantity_kg" class="block mt-1 w-full dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" type="number" step="0.01" name="quantity_kg" :value="old('quantity_kg')" />
                <x-input-error :messages="$errors->get('quantity_kg')" class="mt-2" />
            </div>

            <!-- Quantity Liters -->
            <div>
                <x-input-label for="quantity_liters" :value="__('Cantidad (litros)')" class="dark:text-dark-text-light" />
                <x-text-input id="quantity_liters" class="block mt-1 w-full dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" type="number" step="0.01" name="quantity_liters" :value="old('quantity_liters')" />
                <x-input-error :messages="$errors->get('quantity_liters')" class="mt-2" />
            </div>

            <!-- Density -->
            <div>
                <x-input-label for="density" :value="__('Densidad (kg/l)')" class="dark:text-dark-text-light" />
                <x-text-input id="density" class="block mt-1 w-full dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" type="number" step="0.01" name="density" :value="old('density', '1.42')" required />
                <x-input-error :messages="$errors->get('density')" class="mt-2" />
            </div>

            <!-- Color Tone -->
            <div>
                <x-input-label for="color_tone" :value="__('Tono de Color')" class="dark:text-dark-text-light" />
                <input id="color_tone" name="color_tone" type="range" min="0" max="100" value="{{ old('color_tone', '50') }}" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                <div class="flex justify-between text-xs text-gray-500 dark:text-dark-text-light">
                    <span>Claro</span>
                    <span>Oscuro</span>
                </div>
                <x-input-error :messages="$errors->get('color_tone')" class="mt-2" />
            </div>

            <!-- Notes -->
            <div class="md:col-span-2">
                <x-input-label for="notes" :value="__('Notas Adicionales')" class="dark:text-dark-text-light" />
                <textarea id="notes" name="notes" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary-light dark:bg-dark-surface dark:border-gray-600 dark:text-dark-text-dark">{{ old('notes') }}</textarea>
                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button>
                {{ __('Registrar Cosecha') }}
            </x-primary-button>
        </div>
    </form>
</div>
