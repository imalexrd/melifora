<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-dark-text-dark">
            {{ __('Crear Nuevo Apiario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg dark:bg-dark-surface">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200 dark:bg-dark-surface dark:border-gray-700">
                    <form method="POST" action="{{ route('apiaries.store') }}">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Nombre del Apiario')" class="dark:text-dark-text-light" />
                            <x-text-input id="name" class="block mt-1 w-full dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Location -->
                        <div class="mt-4">
                            <x-input-label for="location" :value="__('Ubicación')" class="dark:text-dark-text-light" />
                            <x-text-input id="location" class="block mt-1 w-full dark:bg-dark-surface dark:text-dark-text-dark dark:border-gray-600" type="text" name="location" :value="old('location')" required autocomplete="location" />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('apiaries.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4 dark:text-dark-text-light dark:hover:text-white">
                                {{ __('Cancelar') }}
                            </a>

                            <x-primary-button>
                                {{ __('Crear Apiario') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
