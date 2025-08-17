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

            <!-- Supers Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-primary text-text-dark">
                            <tr>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">{{ __('Código de Rastreo') }}</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">{{ __('Colmena Asignada') }}</th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">{{ __('Fecha de Creación') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($hiveSupers as $super)
                                <tr class="border-b hover:bg-background">
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
                                    <td colspan="3" class="text-center py-12">
                                        <p class="text-gray-500 text-lg">{{ __('No se encontraron alzas.') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
