<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Colmenas') }}
            </h2>
            <button type="button" class="open-create-hive-modal-button inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 active:bg-opacity-95 focus:outline-none focus:border-primary focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Añadir Colmena') }}
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($hives as $hive)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300 ease-in-out">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-bold text-gray-900">{{ $hive->name }}</h3>
                                <span class="px-2 py-1 text-xs font-semibold text-white rounded-full {{
                                    match($hive->status) {
                                        'Activa' => 'bg-green-500',
                                        'Invernando' => 'bg-blue-500',
                                        'Enjambrazon' => 'bg-yellow-500',
                                        'Despoblada' => 'bg-red-500',
                                        'Huerfana' => 'bg-purple-500',
                                        'Zanganera' => 'bg-orange-500',
                                        'En formacion' => 'bg-teal-500',
                                        'Revision' => 'bg-cyan-500',
                                        'Mantenimiento' => 'bg-sky-500',
                                        'Alimentacion Artificial' => 'bg-indigo-500',
                                        'Crianza de reinas' => 'bg-pink-500',
                                        'Pillaje' => 'bg-rose-500',
                                        'Pillera' => 'bg-fuchsia-500',
                                        'Union' => 'bg-violet-500',
                                        'Sin uso' => 'bg-gray-400',
                                        default => 'bg-gray-500',
                                    }
                                }}">{{ $hive->status }}</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-4">{{ $hive->type }}</p>
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('hives.show', $hive) }}" class="text-sm text-green-600 hover:text-green-900 font-semibold">Ver</a>
                                <a href="{{ route('hives.edit', $hive) }}" class="text-sm text-blue-600 hover:text-blue-900 font-semibold">Editar</a>
                                <form action="{{ route('hives.destroy', $hive) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-900 font-semibold">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12">
                        <p class="text-gray-500 text-lg">{{ __('No tienes colmenas todavía.') }}</p>
                        <p class="text-gray-400 mt-2">{{ __('¡Crea tu primera colmena para empezar a gestionar tus abejas!') }}</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $hives->links() }}
            </div>
        </div>
    </div>

    <x-create-hive-modal :apiaries="$apiaries" :statuses="$statuses" :types="$types" />
</x-app-layout>
