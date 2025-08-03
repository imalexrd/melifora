<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalles de la Colmena: {{ $hive->name }}
            </h2>
            <a href="{{ route('hives.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Volver a Colmenas') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ openTab: 1 }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hive Header Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                <div class="p-6 flex items-center">
                    <img src="https://placehold.co/100x100/FBBF24/333333?text=Colmena" alt="Hive Image" class="w-24 h-24 rounded-lg mr-6">
                    <div class="flex-grow">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $hive->name }}</h3>
                                <p class="text-gray-600">{{ $hive->type }}</p>
                            </div>
                            <span class="px-3 py-1 text-sm font-semibold text-white rounded-full {{
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
                        </div>
                        <div class="mt-2 text-sm text-gray-500">
                            <p><strong>Apiario:</strong> {{ $hive->apiary->name }}</p>
                            <p><strong>Nacimiento:</strong> {{ $hive->birth_date ? $hive->birth_date->format('d/m/Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="flex border-b border-gray-200">
                <button @click="openTab = 1" :class="{'border-b-2 border-yellow-500 text-yellow-600': openTab === 1}" class="px-4 py-2 text-gray-500 font-semibold hover:text-yellow-500 focus:outline-none">Detalles</button>
                <button @click="openTab = 2" :class="{'border-b-2 border-yellow-500 text-yellow-600': openTab === 2}" class="px-4 py-2 text-gray-500 font-semibold hover:text-yellow-500 focus:outline-none">Reina</button>
                <button @click="openTab = 3" :class="{'border-b-2 border-yellow-500 text-yellow-600': openTab === 3}" class="px-4 py-2 text-gray-500 font-semibold hover:text-yellow-500 focus:outline-none">Inspecciones</button>
                <button @click="openTab = 4" :class="{'border-b-2 border-yellow-500 text-yellow-600': openTab === 4}" class="px-4 py-2 text-gray-500 font-semibold hover:text-yellow-500 focus:outline-none">Eventos</button>
            </div>

            <!-- Tab Content -->
            <div class="bg-white rounded-b-lg shadow-md p-6">
                <!-- Details Tab -->
                <div x-show="openTab === 1">
                    <h4 class="text-xl font-semibold mb-4">Información Adicional</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <p><strong>Rating:</strong> {{ $hive->rating ?? 'N/A' }}/100</p>
                        <p><strong>Ubicación Específica:</strong> {{ $hive->location ?? 'N/A' }}</p>
                        <p><strong>QR Code:</strong> {{ $hive->qr_code ?? 'N/A' }}</p>
                        <div class="col-span-2">
                            <p><strong>Notas:</strong></p>
                            <p class="mt-1 text-gray-700 p-3 bg-gray-50 rounded-md">{{ $hive->notes ?? 'Sin notas.' }}</p>
                        </div>
                    </div>
                </div>
                <!-- Queen Tab -->
                <div x-show="openTab === 2">
                    <h4 class="text-xl font-semibold mb-4">Reina Actual e Historial</h4>
                    <!-- Current Queen -->
                    <div class="mb-6">
                        <h5 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-2">Reina Actual</h5>
                        @if ($hive->queen)
                            <p><strong>Raza:</strong> {{ $hive->queen->breed ?? 'N/A' }}</p>
                            <p><strong>Introducida:</strong> {{ $hive->queen->introduction_date ? $hive->queen->introduction_date->format('d/m/Y') : 'N/A' }}</p>
                        @else
                            <p>No hay información de la reina actual.</p>
                        @endif
                    </div>
                    <!-- Queen History -->
                    <div>
                        <h5 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-2">Historial de Reinas</h5>
                        @forelse ($hive->queenHistories as $history)
                            <div class="border-l-4 border-yellow-400 pl-4 mb-4">
                                <p><strong>Fecha de cambio:</strong> {{ $history->change_date->format('d/m/Y') }}</p>
                                <p><strong>Razón:</strong> {{ $history->reason }}</p>
                                <p><strong>Notas:</strong> {{ $history->notes ?? 'Sin notas.' }}</p>
                            </div>
                        @empty
                            <p>No hay historial de reinas.</p>
                        @endforelse
                    </div>
                </div>
                <!-- Inspections Tab -->
                <div x-show="openTab === 3">
                    <h4 class="text-xl font-semibold mb-4">Historial de Inspecciones</h4>
                    @forelse ($hive->inspections as $inspection)
                        <div class="border-l-4 border-blue-400 pl-4 mb-4">
                             <p><strong>Fecha:</strong> {{ $inspection->inspection_date->format('d/m/Y') }}</p>
                             <p><strong>Población:</strong> {{ $inspection->population }}</p>
                             <p><strong>Plagas/Enfermedades:</strong> {{ $inspection->pests_diseases }}</p>
                        </div>
                    @empty
                        <p>No hay inspecciones registradas.</p>
                    @endforelse
                </div>
                <!-- Events Tab -->
                <div x-show="openTab === 4">
                    <h4 class="text-xl font-semibold mb-4">Historial de Eventos</h4>
                    @forelse ($hive->events as $event)
                        <div class="border-l-4 border-green-400 pl-4 mb-4">
                            <p><strong>Fecha:</strong> {{ $event->event_date->format('d/m/Y') }}</p>
                            <p><strong>Tipo:</strong> {{ $event->type }}</p>
                            <p><strong>Detalles:</strong> {{ $event->details }}</p>
                        </div>
                    @empty
                        <p>No hay eventos registrados.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
