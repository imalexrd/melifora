<!-- Google Maps Modal -->
<div id="google-maps-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-10 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('Seleccionar Ubicación en el Mapa') }}</h3>
            <button id="close-map-modal" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="mt-2">
            <input id="pac-input" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary-light focus:ring-opacity-50 mb-4" type="text" placeholder="Buscar una ubicación...">
            <div id="map" style="height: 500px; width: 100%;"></div>
        </div>
        <div class="items-center px-4 py-3 mt-4 text-right">
            <button id="confirm-location-button" class="px-4 py-2 bg-primary text-white text-base font-medium rounded-md w-auto shadow-sm hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-primary-light">
                {{ __('Confirmar Ubicación') }}
            </button>
        </div>
    </div>
</div>
