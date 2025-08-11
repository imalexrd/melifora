<div class="mt-8">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Historial de Cosechas</h3>
    <div class="space-y-6">
        @forelse ($hive->harvests->sortByDesc('harvest_date') as $harvest)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6 sm:flex sm:items-center sm:justify-between">
                    <div class="sm:flex sm:items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-12 w-12 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10s5 2 5 2l-2.646 2.646a.5.5 0 00.708.708L15 12.5V15a1 1 0 001 1h.5a1 1 0 001-1v-2.5l2.121-2.121a.5.5 0 00-.353-.854H18a1 1 0 00-1 1v1.5l-2.646 2.646a.5.5 0 00.708.708L17.5 15V12a1 1 0 00-1-1h-1.5a1 1 0 00-1 1v1.5l-2.646 2.646a.5.5 0 00.708.708L15 15.5V18a1 1 0 001 1h.5a1 1 0 001-1v-2.5l2.121-2.121a.5.5 0 00-.353-.854H18a1 1 0 00-1 1v1.5l-2.646 2.646a.5.5 0 00.708.708L17.5 18H19a1 1 0 001-1v-1.5l-2.121-2.121a.5.5 0 00-.854.353V15a1 1 0 001 1h.5a1 1 0 001-1v-1.5l-2.121-2.121a.5.5 0 00-.854.353V12a1 1 0 001 1h1.5a1 1 0 001-1V9.5a1 1 0 00-1-1h-1.5a1 1 0 00-1 1V12l-2.646 2.646a.5.5 0 00.708.708L12.5 12H15a1 1 0 001-1V9.5a1 1 0 00-1-1h-1.5a1 1 0 00-1 1V12l-2.646 2.646a.5.5 0 00.708.708L10 12h2.5a1 1 0 001-1V9.5a1 1 0 00-1-1H12a1 1 0 00-1 1v2.5L8.879 9.379a.5.5 0 00-.854.353V12a1 1 0 001 1h1.5a1 1 0 001-1V9.5a1 1 0 00-1-1H9a1 1 0 00-1 1v2.5L5.879 9.379a.5.5 0 00-.854.353V12a1 1 0 001 1h1.5a1 1 0 001-1V9.5a1 1 0 00-1-1H6a1 1 0 00-1 1v2.5L2.879 9.379a.5.5 0 00-.854.353V12a1 1 0 001 1h1.5a1 1 0 001-1V9.5a1 1 0 00-1-1H3a1 1 0 00-1 1v2.5a8 8 0 0115.657 5.157z"/>
                            </svg>
                        </div>
                        <div class="mt-4 sm:mt-0 sm:ml-6 text-center sm:text-left">
                            <p class="text-xl font-bold text-gray-900">{{ $harvest->quantity_kg }} kg</p>
                            <p class="text-sm text-gray-600">{{ $harvest->harvest_date->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-0 text-center sm:text-right">
                        <p class="text-sm text-gray-600">Origen: {{ $harvest->origin }}</p>
                        <p class="text-sm text-gray-600">Color: {{ $harvest->color_tone }}</p>
                    </div>
                </div>
                @if ($harvest->notes)
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <p class="text-sm text-gray-700">{{ $harvest->notes }}</p>
                </div>
                @endif
            </div>
        @empty
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">No hay cosechas registradas para esta colmena.</p>
            </div>
        @endforelse
    </div>
</div>
