<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $apiary->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p><strong>{{ __('Location') }}:</strong> {{ $apiary->location }}</p>
                    <p><strong>{{ __('Created at') }}:</strong> {{ $apiary->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>{{ __('Updated at') }}:</strong> {{ $apiary->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
