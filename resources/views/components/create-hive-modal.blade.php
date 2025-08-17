@props(['apiaries', 'types'])

<div id="create-hive-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('Crear Nueva Colmena') }}</h3>
            <div class="mt-2 px-7 py-3">
                <form id="create-hive-form" method="POST" action="{{ route('hives.store') }}">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Number of Hives -->
                        <div>
                            <x-input-label for="number_of_hives" :value="__('Número de Colmenas')" />
                            <x-text-input id="number_of_hives" class="block mt-1 w-full" type="number" name="number_of_hives" :value="old('number_of_hives', 1)" required min="1" max="250" />
                            <x-input-error :messages="$errors->get('number_of_hives')" class="mt-2" />
                        </div>

                        <!-- Apiary -->
                        <div>
                            <x-input-label for="apiary_id" :value="__('Apiario')" />
                            <select id="apiary_id" name="apiary_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Selecciona un apiario</option>
                                @foreach ($apiaries as $apiary)
                                    <option value="{{ $apiary->id }}" {{ old('apiary_id') == $apiary->id ? 'selected' : '' }}>{{ $apiary->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('apiary_id')" class="mt-2" />
                        </div>

                        <!-- Type -->
                        <div>
                            <x-input-label for="type" :value="__('Tipo de Colmena')" />
                            <select id="type" name="type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                @foreach ($types as $type)
                                    <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Birth Date -->
                        <div>
                            <x-input-label for="birth_date" :value="__('Fecha de Nacimiento (Opcional)')" />
                            <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" :value="old('birth_date')" />
                            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                        </div>
                    </div>

                    <div class="items-center px-4 py-3">
                        <button id="confirm-create-button" type="submit" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-auto shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                            {{ __('Crear Colmenas') }}
                        </button>
                        <button id="cancel-create-button" type="button" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-auto shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            {{ __('Cancelar') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const createHiveModal = document.getElementById('create-hive-modal');
        const cancelCreateButton = document.getElementById('cancel-create-button');

        function openCreateHiveModal() {
            createHiveModal.classList.remove('hidden');
        }

        function closeCreateHiveModal() {
            createHiveModal.classList.add('hidden');
        }

        document.querySelectorAll('.open-create-hive-modal-button').forEach(button => {
            button.addEventListener('click', openCreateHiveModal);
        });

        cancelCreateButton.addEventListener('click', closeCreateHiveModal);
    });
</script>
