<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $apiary->name }}
            </h2>
            <a href="{{ route('apiaries.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Volver a Apiarios') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center mb-4">
                        <img src="https://placehold.co/100x100/FBBF24/333333?text=Apiario" alt="Apiary Image" class="w-24 h-24 rounded-lg mr-6">
                        <div>
                            <p class="text-2xl font-bold text-gray-900">{{ $apiary->name }}</p>
                            <p class="text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                {{ $apiary->location }}
                            </p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                        <p><strong>{{ __('Creado el') }}:</strong> {{ $apiary->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>{{ __('Actualizado el') }}:</strong> {{ $apiary->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Colmenas en este Apiario</h3>

                <!-- Search form -->
                <form action="{{ route('apiaries.show', $apiary) }}" method="GET" class="mb-4">
                    <div class="flex items-center">
                        <input type="text" name="search" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Buscar colmenas..." value="{{ request('search') }}">
                        <button type="submit" class="ml-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Buscar
                        </button>
                    </div>
                </form>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">
                                    <a href="{{ route('apiaries.show', ['apiary' => $apiary, 'sort' => 'name', 'direction' => $sort === 'name' && $direction === 'asc' ? 'desc' : 'asc']) }}">
                                        Nombre
                                        @if ($sort === 'name')
                                            <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">
                                    <a href="{{ route('apiaries.show', ['apiary' => $apiary, 'sort' => 'type', 'direction' => $sort === 'type' && $direction === 'asc' ? 'desc' : 'asc']) }}">
                                        Tipo
                                        @if ($sort === 'type')
                                            <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">
                                    <a href="{{ route('apiaries.show', ['apiary' => $apiary, 'sort' => 'status', 'direction' => $sort === 'status' && $direction === 'asc' ? 'desc' : 'asc']) }}">
                                        Estado
                                        @if ($sort === 'status')
                                            <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">
                                    <a href="{{ route('apiaries.show', ['apiary' => $apiary, 'sort' => 'birth_date', 'direction' => $sort === 'birth_date' && $direction === 'asc' ? 'desc' : 'asc']) }}">
                                        Fecha de nacimiento
                                        @if ($sort === 'birth_date')
                                            <span>{{ $direction === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="py-3 px-4 uppercase font-semibold text-sm">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($hives as $hive)
                                <tr class="border-b">
                                    <td class="py-3 px-4">{{ $hive->name }}</td>
                                    <td class="py-3 px-4">{{ $hive->type }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 text-xs font-semibold text-white rounded-full {{
                                            match($hive->status) {
                                                'Activa' => 'bg-green-500',
                                                'Invernando' => 'bg-blue-500',
                                                'Enjambrazon' => 'bg-yellow-500',
                                                'Despoblada' => 'bg-red-500',
                                                'Huerfana' => 'bg-purple-500',
                                                'Zanganera' => 'bg-orange-500',
                                                default => 'bg-gray-500',
                                            }
                                        }}">{{ $hive->status }}</span>
                                    </td>
                                    <td class="py-3 px-4">{{ $hive->birth_date ? $hive->birth_date->format('d/m/Y') : 'N/A' }}</td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('hives.show', $hive) }}" class="text-sm text-green-600 hover:text-green-900 font-semibold">Ver Colmena</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-12">
                                        <p class="text-gray-500 text-lg">{{ __('No hay colmenas que coincidan con la búsqueda.') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="p-4">
                        {{ $hives->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
