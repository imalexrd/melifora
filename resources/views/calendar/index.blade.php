<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calendario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Calendar Section -->
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900" id='calendar'>
                            <!-- Calendar will be rendered here -->
                        </div>
                    </div>
                </div>

                <!-- Tasks and Events Panel -->
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Tareas y Eventos</h3>
                            <ul class="space-y-4">
                                <!-- Placeholder Item 1 -->
                                <li class="border-l-4 border-blue-500 pl-4">
                                    <p class="font-semibold">Revisar Colmena #3</p>
                                    <p class="text-sm text-gray-500">15 de Agosto, 2025</p>
                                </li>
                                <!-- Placeholder Item 2 -->
                                <li class="border-l-4 border-green-500 pl-4">
                                    <p class="font-semibold">Cosecha de Miel</p>
                                    <p class="text-sm text-gray-500">20 de Agosto, 2025</p>
                                </li>
                                <!-- Placeholder Item 3 -->
                                <li class="border-l-4 border-yellow-500 pl-4">
                                    <p class="font-semibold">Tratamiento de Varroa</p>
                                    <p class="text-sm text-gray-500">1 de Septiembre, 2025</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
