<x-app-layout> <!-- Esta etiqueta es necesaria pporqe es lo que envuelve la aplicacion el envoltorio es /layouts/app.blade.php -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Conocimiento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Próximamente") }}

                    <p class="text-gray-600 mt-4">
                        {{ __("Aquí podrás encontrar artículos, guías y recursos sobre apicultura.") }}
                    </p>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
